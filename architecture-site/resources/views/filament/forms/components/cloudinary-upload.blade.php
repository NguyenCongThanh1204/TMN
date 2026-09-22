@php
    $statePath = $getStatePath();
    $currentValue = $getState();
    $directory = $directory ?? 'uploads';
    $maxSize = $maxSize ?? 20971520;
    $isMultiple = $isMultiple ?? false;
    $currentValues = $isMultiple ? (array) $currentValue : [$currentValue];
    $currentUrls = collect($currentValues)->filter()->map(fn ($value) => cloudinary_image_url($value, 400))->values()->all();
@endphp

<div
    x-data="{
        state: $wire.entangle('{{ $statePath }}'),
        fileName: '',
        multiple: @js($isMultiple),
        previewUrls: @js($currentUrls),
        uploading: false,
        error: '',
        async upload(event) {
            const files = Array.from(event.target.files || []);
            if (!files.length) return;
            this.error = '';
            this.fileName = files.map(file => file.name).join(', ');

            this.uploading = true;
            try {
                const uploadedFiles = [];
                for (const file of files) {
                    if (file.size > {{ $maxSize }}) {
                        throw new Error('Ảnh vượt quá dung lượng cho phép.');
                    }

                    const signed = await fetch(@js($signatureUrl), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': @js(csrf_token()),
                        },
                        body: JSON.stringify({ folder: @js($directory) }),
                    }).then(response => {
                        if (!response.ok) throw new Error('Không cấp được chữ ký upload.');
                        return response.json();
                    });

                    const body = new FormData();
                    body.append('file', file);
                    body.append('api_key', signed.api_key);
                    body.append('timestamp', signed.timestamp);
                    body.append('signature', signed.signature);
                    body.append('folder', signed.folder);

                    const uploaded = await fetch(signed.upload_url, {
                        method: 'POST',
                        body,
                    }).then(response => {
                        if (!response.ok) throw new Error('Cloudinary upload thất bại.');
                        return response.json();
                    });

                    uploadedFiles.push(uploaded);
                }

                if (this.multiple) {
                    this.state = [...(Array.isArray(this.state) ? this.state : []), ...uploadedFiles.map(file => file.public_id)];
                    this.previewUrls = [...this.previewUrls, ...uploadedFiles.map(file => file.secure_url)];
                } else {
                    this.state = uploadedFiles[0].public_id;
                    this.previewUrls = [uploadedFiles[0].secure_url];
                }
            } catch (error) {
                this.error = error.message || 'Không thể tải ảnh lên.';
                this.fileName = '';
            } finally {
                this.uploading = false;
            }
        },
        clear() {
            this.state = this.multiple ? [] : null;
            this.previewUrls = [];
            this.fileName = '';
            this.$refs.file.value = '';
        }
    }"
    class="space-y-3"
>
    <input type="hidden" wire:model="{{ $statePath }}">

    <template x-if="previewUrls.length">
        <div class="grid grid-cols-2 gap-2 overflow-hidden rounded-lg border border-gray-200 bg-gray-50 p-2">
            <template x-for="previewUrl in previewUrls" :key="previewUrl">
                <img :src="previewUrl" alt="Ảnh đã tải lên" class="h-32 w-full object-contain">
            </template>
            <button type="button" x-on:click="clear" class="absolute right-2 top-2 rounded-md bg-white px-2 py-1 text-xs text-red-600 shadow">
                Xóa
            </button>
        </div>
    </template>

    <label class="flex cursor-pointer items-center justify-center rounded-lg border border-dashed border-gray-300 px-4 py-5 text-sm text-gray-600 hover:border-primary-500">
        <span x-show="!uploading" x-text="fileName || 'Chọn ảnh để tải trực tiếp lên Cloudinary'"></span>
        <span x-show="uploading">Đang tải lên Cloudinary...</span>
        <input x-ref="file" type="file" accept="image/*" class="sr-only" x-on:change="upload">
    </label>

    <p x-show="error" x-text="error" class="text-sm text-danger-600"></p>
</div>
