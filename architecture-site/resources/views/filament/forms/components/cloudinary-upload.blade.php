@php
    $statePath = $getStatePath();
    $currentValue = $getState();
    $directory = $directory ?? 'uploads';
    $maxSize = $maxSize ?? 20971520;
    $isMultiple = $isMultiple ?? false;
    $currentValues = $isMultiple ? (array) $currentValue : [$currentValue];
    $currentFiles = collect($currentValues)
        ->filter()
        ->map(fn ($value) => [
            'id' => $value,
            'name' => basename((string) $value),
            'url' => cloudinary_image_url($value, 400),
            'uploaded' => true,
        ])
        ->values()
        ->all();
@endphp

<div
    x-data="{
        state: $wire.entangle('{{ $statePath }}'),
        multiple: @js($isMultiple),
        files: @js($currentFiles),
        isDragging: false,
        uploading: false,
        uploadCount: 0,
        error: '',
        openPicker() {
            this.$refs.file.click();
        },
        handleDrop(event) {
            this.isDragging = false;
            this.uploadFiles(Array.from(event.dataTransfer.files || []));
        },
        handleInput(event) {
            this.uploadFiles(Array.from(event.target.files || []));
        },
        async uploadFiles(selectedFiles) {
            if (!selectedFiles.length) return;
            this.error = '';
            this.uploadCount = selectedFiles.length;

            this.uploading = true;
            try {
                const uploadedFiles = [];
                for (const file of selectedFiles) {
                    if (!file.type.match(/^image\/(jpeg|png|webp)$/)) {
                        throw new Error('Chỉ chấp nhận ảnh JPG, PNG hoặc WEBP.');
                    }

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
                    this.files = [...this.files, ...uploadedFiles.map(file => ({
                        id: file.public_id,
                        name: file.original_filename || file.public_id.split('/').pop(),
                        url: file.secure_url,
                        uploaded: true,
                    }))];
                } else {
                    this.state = uploadedFiles[0].public_id;
                    this.files = [{
                        id: uploadedFiles[0].public_id,
                        name: uploadedFiles[0].original_filename || uploadedFiles[0].public_id.split('/').pop(),
                        url: uploadedFiles[0].secure_url,
                        uploaded: true,
                    }];
                }
            } catch (error) {
                this.error = error.message || 'Không thể tải ảnh lên.';
            } finally {
                this.uploading = false;
                this.uploadCount = 0;
                this.$refs.file.value = '';
            }
        },
        removeFile(index) {
            this.files.splice(index, 1);
            this.state = this.multiple
                ? this.files.map(file => file.id)
                : null;
            this.$refs.file.value = '';
        }
    }"
    class="space-y-3"
>
    <input type="hidden" wire:model="{{ $statePath }}">

    <template x-if="files.length">
        <div class="space-y-2">
            <template x-for="(file, index) in files" :key="file.id">
                <div class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
                    <img :src="file.url" :alt="file.name" class="h-16 w-20 shrink-0 rounded-lg bg-gray-100 object-cover">
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-gray-800" x-text="file.name"></p>
                        <p class="mt-1 flex items-center gap-1 text-xs font-medium text-emerald-600">
                            <span class="inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-100">✓</span>
                            Đã tải lên Cloudinary
                        </p>
                    </div>
                    <button type="button" x-on:click="removeFile(index)" class="shrink-0 rounded-lg px-2 py-1 text-xs font-semibold text-gray-500 hover:bg-red-50 hover:text-red-600">
                        Xóa
                    </button>
                </div>
            </template>
        </div>
    </template>

    <div
        x-on:dragover.prevent="isDragging = true"
        x-on:dragleave.prevent="isDragging = false"
        x-on:drop.prevent="handleDrop($event)"
        x-on:click="if (!uploading) openPicker()"
        class="group cursor-pointer rounded-xl border-2 border-dashed px-5 py-8 text-center transition"
        :class="isDragging ? 'border-primary-500 bg-primary-50' : 'border-gray-300 bg-gray-50 hover:border-primary-400 hover:bg-primary-50/50'"
    >
        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-white text-gray-400 shadow-sm group-hover:text-primary-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4 4 4M4 16.5v1.25A2.25 2.25 0 0 0 6.25 20h11.5A2.25 2.25 0 0 0 20 17.75V16.5" />
            </svg>
        </div>
        <p class="mt-3 text-sm font-semibold text-gray-700" x-show="!uploading">Kéo & thả ảnh vào đây</p>
        <p class="my-1 text-xs text-gray-400" x-show="!uploading">hoặc</p>
        <button type="button" x-on:click.stop="openPicker()" x-show="!uploading" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-700">
            Chọn ảnh
        </button>
        <p x-show="uploading" class="text-sm font-semibold text-primary-700">Đang tải <span x-text="uploadCount"></span> ảnh lên Cloudinary...</p>
        <p class="mt-3 text-xs text-gray-400" x-show="!uploading">JPG, PNG, WEBP <span class="mx-1">•</span> tối đa 20MB mỗi ảnh</p>
        <input x-ref="file" type="file" accept="image/jpeg,image/png,image/webp" class="sr-only" :multiple="multiple" x-on:change="handleInput">
    </div>

    <p x-show="error" x-text="error" class="rounded-lg bg-red-50 px-3 py-2 text-sm text-danger-600"></p>
</div>
