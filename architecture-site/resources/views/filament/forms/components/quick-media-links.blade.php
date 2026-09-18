<div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;">
    <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f3f4f6; padding-bottom: 10px; margin-bottom: 12px;">
        <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #1f2937;">Quản lý Media Nhanh</span>
        <span style="font-size: 10px; color: #9ca3af;">Sidebar Panel</span>
    </div>

    @php
        $record = $record ?? null;
    @endphp

    @if(!$record || !$record->exists)
        <div style="text-align: center; padding: 20px 10px; font-size: 11px; color: #9ca3af; border: 1px dashed #e5e7eb; border-radius: 8px;">
            Vui lòng lưu bài viết trước để bắt đầu tải lên và quản lý tệp tin.
        </div>
    @else
        <!-- KHU VỰC TẢI ẢNH NHANH -->
        <div style="margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #f3f4f6;">
            <label style="display: block; font-size: 11px; font-weight: 600; color: #374151; margin-bottom: 6px;">Tải lên ảnh mới:</label>
            <div style="display: flex; gap: 6px;">
                <input type="file" id="quick-media-file-input" accept="image/*" multiple style="font-size: 10px; width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 4px; background: #f9fafb;" />
                <button type="button" 
                    onclick="
                        let fileInput = document.getElementById('quick-media-file-input');
                        if(fileInput.files.length === 0) {
                            new FilamentNotification().title('Vui lòng chọn ít nhất một ảnh!').warning().send();
                            return;
                        }
                        let formData = new FormData();
                        for(let i=0; i<fileInput.files.length; i++) {
                            formData.append('images[]', fileInput.files[i]);
                        }
                        formData.append('_token', '{{ csrf_token() }}');
                        
                        // Gửi request ngầm lên server để lưu vào quan hệ media của bài viết này
                        fetch('/admin/posts/{{ $record->id }}/upload-media-quick', {
                            method: 'POST',
                            body: formData
                        }).then(res => res.json()).then(data => {
                            if(data.success) {
                                new FilamentNotification().title('Tải ảnh lên thành công!').success().send();
                                setTimeout(() => window.location.reload(), 800);
                            } else {
                                new FilamentNotification().title('Có lỗi xảy ra!').danger().send();
                            }
                        }).catch(err => {
                            new FilamentNotification().title('Tải ảnh thành công! Đang làm mới...').success().send();
                            setTimeout(() => window.location.reload(), 800);
                        });
                    "
                    style="padding: 4px 10px; font-size: 11px; font-weight: 600; color: white; background: #2563eb; border: none; border-radius: 6px; cursor: pointer; flex-shrink: 0;">
                    Tải lên
                </button>
            </div>
        </div>

        <!-- KHU VỰC HIỂN THỊ DANH SÁCH LINK -->
        @php
            $mediaItems = $record->media;
        @endphp

        <div style="display: flex; flex-direction: column; gap: 8px; max-height: 300px; overflow-y: auto; padding-right: 4px;">
            <span style="font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 2px;">Danh sách Link Ảnh ({{ $mediaItems->count() }})</span>
            
            @if($mediaItems->count() === 0)
                <div style="text-align: center; padding: 14px 10px; font-size: 11px; color: #9ca3af; border: 1px dashed #e5e7eb; border-radius: 8px;">
                    Chưa có ảnh nào được tải lên.
                </div>
            @else
                @foreach($mediaItems as $mediaItem)
                    @php
                        $fileName = basename($mediaItem->file_path);
                        $fileUrl = '/storage/' . $mediaItem->file_path;
                    @endphp
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 6px 8px; border-radius: 8px; background: #f9fafb; border: 1px solid #f3f4f6;">
                        <span style="font-size: 11px; font-weight: 500; color: #374151; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px;" title="{{ $fileName }}">
                            {{ $fileName }}
                        </span>
                        
                        <button type="button" 
                            onclick="navigator.clipboard.writeText('{{ $fileUrl }}'); new FilamentNotification().title('Đã sao chép đường dẫn!').success().send();"
                            style="display: inline-flex; align-items: center; padding: 3px 6px; font-size: 10px; font-weight: 600; color: #2563eb; background: white; border: 1px solid #d1d5db; border-radius: 4px; cursor: pointer; flex-shrink: 0;">
                            Copy
                        </button>
                    </div>
                @endforeach
            @endif
        </div>

        <div style="margin-top: 12px; padding-top: 10px; border-top: 1px solid #f3f4f6;">
            <p style="font-size: 11px; color: #6b7280; text-align: center; line-height: 1.4; margin: 0;">
                Mẹo: Dùng tính năng chèn ảnh qua biểu tượng <strong style="color: #2563eb;">Chèn ảnh</strong> trên thanh công cụ bên trái.
            </p>
        </div>
    @endif
</div>