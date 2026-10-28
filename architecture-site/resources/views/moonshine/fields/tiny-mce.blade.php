@props([
    'value' => '',
    'label' => '',
])

<textarea
    {{ $attributes->merge([
        'aria-label' => $label ?? '',
        'class' => 'form-textarea',
    ]) }}
>{{ e($value ?? '') }}</textarea>

@include('app-moonshine::partials.media-modal')

<script>
    (() => {
        const initializeTinyMce = (root = document) => {
            if (!window.tinymce) {
                return;
            }

            const decodeHtmlEntities = (value) => {
                const textarea = document.createElement('textarea');
                textarea.innerHTML = value;

                return textarea.value;
            };

            root.querySelectorAll('textarea[data-tinymce]').forEach((textarea) => {
                if (textarea.dataset.tinymceInitialized === 'true') {
                    return;
                }

                textarea.dataset.tinymceInitialized = 'true';

                const mediaButton = document.createElement('button');
                mediaButton.type = 'button';
                mediaButton.className = 'btn-secondary mb-2';
                mediaButton.textContent = 'Chọn ảnh từ Media Library';
                textarea.parentElement?.prepend(mediaButton);
                mediaButton.addEventListener('click', () => {
                    window.MediaModal.open({
                        hint: textarea.form?.querySelector('[name="slug"]')?.value || '',
                        onSelect: ({ url }) => {
                            const editor = window.tinymce.get(textarea.id) || window.tinymce.activeEditor;

                            editor.insertContent(`<p><img src="${editor.dom.encode(url)}" alt=""></p>`);
                            editor.save();
                            textarea.dispatchEvent(new Event('input', { bubbles: true }));
                        },
                    });
                });

                window.tinymce.init({
                    target: textarea,
                    height: 560,
                    menubar: true,
                    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount',
                    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | code fullscreen',
                    branding: false,
                    promotion: false,
                    license_key: 'gpl',
                    entity_encoding: 'raw',
                    relative_urls: false,
                    remove_script_host: false,
                    images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                        const formData = new FormData();
                        const slugField = textarea.form?.querySelector('[name="slug"]');

                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        formData.append('slug', slugField?.value || '');

                        fetch('{{ route('moonshine.tiny-mce.upload') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: formData,
                        })
                            .then(async (response) => {
                                const payload = await response.json();

                                if (!response.ok || !payload.location) {
                                    throw new Error(payload.message || 'Không tìm thấy ảnh.');
                                }

                                resolve(payload.location);
                            })
                            .catch((error) => reject({ message: error.message, remove: true }));
                    }),
                    setup: (editor) => {
                        editor.on('init', () => {
                            const decodedContent = decodeHtmlEntities(textarea.value);

                            if (decodedContent !== textarea.value) {
                                editor.setContent(decodedContent);
                                editor.save();
                            }
                        });

                        editor.on('change input undo redo', () => {
                            editor.save();
                            textarea.dispatchEvent(new Event('input', { bubbles: true }));
                        });

                        textarea.form?.addEventListener('submit', () => {
                            editor.save();
                        });
                    },
                });
            });
        };

        const loadTinyMce = (callback) => {
            if (window.tinymce) {
                callback();

                return;
            }

            const existingScript = document.querySelector('script[data-moonshine-tinymce]');

            if (existingScript) {
                existingScript.addEventListener('load', callback, { once: true });

                return;
            }

            const script = document.createElement('script');

            script.src = '{{ asset('vendor/tinymce/tinymce.min.js') }}';
            script.dataset.moonshineTinymce = 'true';
            script.addEventListener('load', callback, { once: true });
            script.addEventListener('error', () => {
                console.error('KhÃ´ng thá»ƒ táº£i TinyMCE cho MoonShine.');
            }, { once: true });
            document.head.appendChild(script);
        };

        const initialize = () => loadTinyMce(() => initializeTinyMce(document));

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initialize, { once: true });
        } else {
            initialize();
        }

        document.addEventListener('moonshine:page-loaded', initialize);
    })();
</script>
