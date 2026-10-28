@props([
    'value' => '',
    'label' => '',
    'galleryItems' => [],
])

<div class="pg" data-project-gallery>
    <input type="hidden" name="gallery_add" value="[]" data-pg-add>
    <input type="hidden" name="gallery_remove" value="[]" data-pg-remove>

    <div class="pg-actions">
        <button type="button" class="pg-btn pg-btn--primary" data-pg-library>Thêm từ Media Library</button>
        <label class="pg-btn">
            Tải ảnh từ máy
            <input type="file" name="gallery_files[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple hidden data-pg-files>
        </label>
        <span class="pg-hint" data-pg-count></span>
    </div>

    <div class="pg-grid" data-pg-grid>
        @foreach ($galleryItems as $item)
            <figure class="pg-item" data-pg-existing="{{ $item['id'] }}">
                <img src="{{ $item['url'] }}" alt="" loading="lazy">
                <figcaption title="{{ $item['path'] }}">{{ basename($item['path']) }}</figcaption>
                <button type="button" class="pg-remove" data-pg-remove-existing aria-label="Gỡ ảnh">&times;</button>
            </figure>
        @endforeach
    </div>
    <p class="pg-hint">Ảnh được lưu khi bấm "Lưu" của form. Gỡ ảnh chỉ xóa liên kết với dự án, không xóa ảnh trên Cloudinary.</p>
</div>

@include('app-moonshine::partials.media-modal')

<style>
    .pg { display: grid; gap: .75rem; font-family: inherit; }
    .pg-actions { display: flex; flex-wrap: wrap; align-items: center; gap: .5rem; }
    .pg-btn { display: inline-flex; align-items: center; min-height: 2.25rem; padding: .4rem .9rem; border: 1px solid #cbd5e1; border-radius: .5rem; background: #fff; color: #0f172a; font: inherit; font-size: .875rem; font-weight: 600; cursor: pointer; }
    .pg-btn:hover { background: #f1f5f9; }
    .pg-btn--primary { border-color: #0284c7; background: #0284c7; color: #fff; }
    .pg-btn--primary:hover { background: #0369a1; }
    .pg-hint { margin: 0; color: #64748b; font-size: .8rem; }
    .pg-grid { display: grid; gap: .6rem; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); }
    .pg-item { position: relative; min-width: 0; margin: 0; overflow: hidden; border: 1px solid #e2e8f0; border-radius: .6rem; background: #fff; }
    .pg-item img { display: block; width: 100%; aspect-ratio: 4 / 3; object-fit: cover; background: #f1f5f9; }
    .pg-item figcaption { overflow: hidden; padding: .3rem .5rem; font-size: .72rem; text-overflow: ellipsis; white-space: nowrap; }
    .pg-item.is-new { border-color: #0284c7; }
    .pg-remove { position: absolute; top: .3rem; right: .3rem; width: 1.5rem; height: 1.5rem; border: 0; border-radius: 999px; background: rgba(15, 23, 42, .75); color: #fff; font: inherit; line-height: 1; cursor: pointer; }
    .pg-remove:hover { background: #dc2626; }
</style>

<script>
    (() => {
        if (window.__projectGalleryBound) {
            return;
        }

        window.__projectGalleryBound = true;

        const read = (input) => { try { return JSON.parse(input.value || '[]'); } catch (e) { return []; } };
        const write = (input, list) => { input.value = JSON.stringify(list); };

        const makeItem = (src, label, isNew) => {
            const figure = document.createElement('figure');
            figure.className = 'pg-item' + (isNew ? ' is-new' : '');
            const img = document.createElement('img');
            img.alt = '';
            img.src = src;
            const caption = document.createElement('figcaption');
            caption.textContent = label;
            caption.title = label;
            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'pg-remove';
            remove.setAttribute('aria-label', 'Bỏ ảnh');
            remove.innerHTML = '&times;';
            figure.append(img, caption, remove);

            return { figure, remove };
        };

        const refresh = (root) => {
            const count = root.querySelectorAll('.pg-item.is-new').length + Number(root.dataset.pgFiles || 0);
            root.querySelector('[data-pg-count]').textContent = count > 0 ? count + ' ảnh mới chờ lưu' : '';
        };

        document.addEventListener('change', (event) => {
            const files = event.target.closest('[data-pg-files]');

            if (files) {
                const root = files.closest('[data-project-gallery]');
                root.dataset.pgFiles = files.files.length;
                refresh(root);
            }
        });

        document.addEventListener('click', (event) => {
            const root = event.target.closest('[data-project-gallery]');

            if (!root) {
                return;
            }

            const grid = root.querySelector('[data-pg-grid]');
            const addInput = root.querySelector('[data-pg-add]');
            const removeInput = root.querySelector('[data-pg-remove]');

            if (event.target.closest('[data-pg-remove-existing]')) {
                const figure = event.target.closest('[data-pg-existing]');
                write(removeInput, [...read(removeInput), Number(figure.dataset.pgExisting)]);
                figure.remove();
            }

            if (event.target.closest('[data-pg-library]')) {
                const slug = root.closest('form')?.querySelector('[name="slug"]')?.value || '';

                window.MediaModal.open({
                    hint: slug,
                    multiple: true,
                    onSelect: ({ path, thumb }) => {
                        const list = read(addInput);

                        if (list.includes(path)) {
                            return;
                        }

                        write(addInput, [...list, path]);
                        const { figure, remove } = makeItem(thumb, path.split('/').pop(), true);
                        remove.addEventListener('click', () => {
                            write(addInput, read(addInput).filter((item) => item !== path));
                            figure.remove();
                            refresh(root);
                        });
                        grid.appendChild(figure);
                        refresh(root);
                    },
                });
            }
        });
    })();
</script>
