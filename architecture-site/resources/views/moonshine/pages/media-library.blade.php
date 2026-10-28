@php
    $currentFolderId = $currentFolder?->id;
    $libraryUrl = route('moonshine.page', ['pageUri' => 'media-library']);
    $selectTarget = preg_match('/^[a-z0-9_]{1,40}$/', (string) request()->query('select')) ? (string) request()->query('select') : null;
    $folderUrl = function (?int $folderId) use ($libraryUrl, $selectTarget): string {
        $query = http_build_query(array_filter(['folder' => $folderId, 'select' => $selectTarget]));

        return $query === '' ? $libraryUrl : $libraryUrl.'?'.$query;
    };
    $activeFolderIds = $breadcrumbs->pluck('id')->map(fn ($id): int => (int) $id)->all();

    $renderTree = function (int $parentId) use (&$renderTree, $folders, $currentFolderId, $activeFolderIds, $folderUrl): void {
        foreach ($folders->get((string) $parentId, collect()) as $folder) {
            $active = $folder->id === $currentFolderId;
            $hasChildren = $folders->has((string) $folder->id);
            $expanded = in_array((int) $folder->id, $activeFolderIds, true);
            echo '<li class="ml-tree__item" data-folder-item>';
            echo '<div class="ml-tree__row">';
            echo '<a class="ml-tree__link'.($active ? ' is-active' : '').'" href="'.e($folderUrl($folder->id)).'" title="'.e($folder->name).'"'.($active ? ' aria-current="page"' : '').'>';
            echo '<svg class="ml-icon ml-tree__folder-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/></svg>';
            echo '<span class="ml-tree__name">'.e($folder->name).'</span>';
            echo '</a>';
            if ($hasChildren) {
                echo '<button class="ml-tree__toggle" type="button" aria-label="Mở thư mục con của '.e($folder->name).'" aria-expanded="'.($expanded ? 'true' : 'false').'" data-tree-toggle>';
                echo '<svg class="ml-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>';
                echo '</button>';
            }
            echo '</div>';
            if ($hasChildren) {
                echo '<ul class="ml-tree__children"'.($expanded ? '' : ' hidden').'>';
                $renderTree($folder->id);
                echo '</ul>';
            }
            echo '</li>';
        }
    };
@endphp

<style>
    .ml { --ml-blue: #0284c7; --ml-blue-dark: #0369a1; --ml-blue-soft: #e0f2fe; --ml-red: #dc2626; --ml-border: #bae6fd; --ml-text: #0f172a; --ml-muted: #64748b; display: grid; gap: 1rem; min-width: 0; color: var(--ml-text); }
    .ml *, .ml *::before, .ml *::after { box-sizing: border-box; }
    .ml-layout { display: grid; grid-template-columns: minmax(220px, 270px) minmax(0, 1fr); gap: 1rem; align-items: start; min-width: 0; }
    @media (max-width: 980px) { .ml-layout { grid-template-columns: 1fr; } }
    .ml-card { background: #fff; border: 1px solid var(--ml-border); border-radius: .75rem; box-shadow: 0 1px 2px rgba(2, 132, 199, .06); }
    .ml-sidebar, .ml-main { min-width: 0; }
    .ml-main { display: grid; align-content: start; gap: 1rem; }
    .ml-card__head { display: flex; align-items: center; justify-content: space-between; gap: .5rem; padding: .8rem .9rem; border-bottom: 1px solid var(--ml-border); font-weight: 600; }
    .ml-card__body { padding: 1rem; }
    .ml-icon { width: 1.125rem; height: 1.125rem; flex: none; }
    .ml-btn, .ml-input, .ml-tree-filter { font-family: inherit; }
    .ml-alert { padding: .75rem 1rem; border-radius: .5rem; border: 1px solid; font-size: .9rem; }
    .ml-alert--ok { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
    .ml-alert--err { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
    .ml-alert--info { background: #eff6ff; border-color: #bfdbfe; color: #1e40af; }
    .ml-tree-wrap { display: grid; gap: .5rem; }
    .ml-tree-filter { min-height: 2.25rem; font-size: .85rem; }
    .ml-tree-scroll { max-height: min(42vh, 390px); min-height: 5rem; overflow: auto; overscroll-behavior: contain; padding-right: .2rem; }
    .ml-tree, .ml-tree__children { list-style: none; margin: 0; padding: 0; display: grid; gap: .15rem; }
    .ml-tree__children[hidden], [data-folder-item][hidden] { display: none; }
    .ml-tree__item { min-width: 0; }
    .ml-tree__row { display: flex; min-width: 0; align-items: center; gap: .15rem; }
    .ml-tree__children { margin: .15rem 0 .15rem .75rem; padding-left: .45rem; border-left: 1px solid var(--ml-border); }
    .ml-tree__link { display: flex; flex: 1; min-width: 0; max-width: 100%; align-items: center; gap: .5rem; overflow: hidden; padding: .45rem .55rem; border-radius: .5rem; color: var(--ml-text); text-decoration: none; font-size: .86rem; }
    .ml-tree__link:hover { background: var(--ml-blue-soft); }
    .ml-tree__link.is-active { background: var(--ml-blue); color: #fff; }
    .ml-tree__folder-icon { color: var(--ml-blue); }
    .ml-tree__link.is-active .ml-tree__folder-icon { color: #fff; }
    .ml-tree__toggle { display: grid; place-items: center; width: 2rem; height: 2rem; flex: none; padding: 0; border: 0; border-radius: .4rem; background: transparent; color: var(--ml-muted); cursor: pointer; }
    .ml-tree__toggle:hover, .ml-tree__toggle:focus-visible { background: var(--ml-blue-soft); color: var(--ml-blue-dark); outline: none; }
    .ml-tree__toggle[aria-expanded="true"] svg { transform: rotate(90deg); }
    .ml-tree__toggle svg { transition: transform .15s ease; }
    .ml-tree__name { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ml-link-all { font-size: .85rem; font-weight: 500; color: var(--ml-blue); text-decoration: none; }
    .ml-link-all:hover { text-decoration: underline; }
    .ml-link-all[aria-current="page"] { padding: .3rem .55rem; border-radius: .4rem; background: var(--ml-blue-soft); color: var(--ml-blue-dark); }
    .ml-form { display: grid; gap: .5rem; }
    .ml-label { font-size: .8rem; font-weight: 600; color: var(--ml-muted); text-transform: uppercase; letter-spacing: .03em; }
    .ml-input { width: 100%; min-height: 2.5rem; padding: .5rem .75rem; border: 1px solid #cbd5e1; border-radius: .5rem; background: #fff; font-size: .9rem; }
    .ml-input:focus { outline: 2px solid var(--ml-blue); outline-offset: 0; border-color: var(--ml-blue); }
    .ml-btn { display: inline-flex; align-items: center; justify-content: center; gap: .4rem; min-height: 2.25rem; padding: .4rem .9rem; border: 1px solid transparent; border-radius: .5rem; font-size: .85rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: background .15s, color .15s; }
    .ml-btn--primary { background: var(--ml-blue); color: #fff; }
    .ml-btn--primary:hover { background: var(--ml-blue-dark); }
    .ml-btn--ghost { background: #fff; color: var(--ml-blue-dark); border-color: var(--ml-border); }
    .ml-btn--ghost:hover { background: var(--ml-blue-soft); }
    .ml-btn--danger { background: #fff; color: var(--ml-red); border-color: #fecaca; }
    .ml-btn--danger:hover { background: var(--ml-red); color: #fff; }
    .ml-btn--block { width: 100%; }
    .ml-divider { border-top: 1px solid var(--ml-border); margin: 1rem 0; }
    .ml-toolbar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: .75rem; min-width: 0; }
    .ml-toolbar > div:first-child { flex: 1 1 18rem; min-width: 0; }
    .ml-title { margin: 0; font-size: 1.25rem; font-weight: 700; overflow-wrap: anywhere; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden; }
    .ml-sub { margin: .15rem 0 0; font-size: .85rem; color: var(--ml-muted); }
    .ml-crumbs { display: flex; flex-wrap: wrap; align-items: center; gap: .35rem; font-size: .85rem; color: var(--ml-muted); margin-bottom: .35rem; min-width: 0; }
    .ml-crumbs a { color: var(--ml-blue); text-decoration: none; max-width: 16rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ml-crumbs a:hover { text-decoration: underline; }
    .ml-search { display: flex; flex: 1 1 19rem; max-width: 26rem; gap: .5rem; min-width: min(100%, 17rem); }
    .ml-search .ml-input { min-width: 0; }
    .ml-upload { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 13rem) auto; gap: .6rem; padding: .85rem; background: var(--ml-blue-soft); border: 1px dashed var(--ml-blue); border-radius: .75rem; min-width: 0; }
    @media (max-width: 680px) { .ml-upload { grid-template-columns: minmax(0, 1fr); } .ml-search { max-width: none; } }
    .ml-upload-card { display: grid; gap: .65rem; padding: .9rem; border: 1px solid var(--ml-border); border-radius: .75rem; background: #fff; }
    .ml-upload-card__intro { display: grid; gap: .15rem; font-size: .9rem; min-width: 0; overflow-wrap: anywhere; }
    .ml-upload-card__intro span { color: var(--ml-muted); font-size: .8rem; }
    .ml-section { margin: 0 0 .5rem; font-size: .8rem; font-weight: 700; color: var(--ml-muted); text-transform: uppercase; letter-spacing: .04em; }
    .ml-folders { display: grid; grid-template-columns: repeat(auto-fill, minmax(11rem, 1fr)); gap: .75rem; }
    .ml-folders > * { min-width: 0; max-width: 100%; }
    .ml-folder { display: flex; min-width: 0; max-width: 100%; align-items: center; gap: .6rem; padding: .75rem .9rem; background: #fff; border: 1px solid var(--ml-border); border-radius: .6rem; color: var(--ml-text); text-decoration: none; font-weight: 500; }
    .ml-folder:hover { border-color: var(--ml-blue); background: var(--ml-blue-soft); }
    .ml-folder .ml-icon { color: var(--ml-blue); width: 1.4rem; height: 1.4rem; }
    .ml-folder__name { display: -webkit-box; flex: 1; min-width: 0; overflow: hidden; overflow-wrap: anywhere; -webkit-box-orient: vertical; -webkit-line-clamp: 2; }
    .ml-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 12rem), 1fr)); gap: .85rem; min-width: 0; }
    .ml-item { display: flex; min-width: 0; max-width: 100%; flex-direction: column; overflow: hidden; background: #fff; border: 1px solid var(--ml-border); border-radius: .75rem; transition: box-shadow .15s, border-color .15s; }
    .ml-item:hover { border-color: var(--ml-blue); box-shadow: 0 6px 16px rgba(2, 132, 199, .15); }
    .ml-item__thumb { display: block; aspect-ratio: 1 / 1; background: #f1f5f9; }
    .ml-item__thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .ml-item__body { display: grid; grid-template-columns: minmax(0, 1fr); min-width: 0; gap: .5rem; padding: .7rem; }
    .ml-item__text { min-width: 0; }
    .ml-item__name { min-width: 0; max-width: 100%; font-size: .85rem; font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ml-item__cap { min-width: 0; max-width: 100%; font-size: .75rem; color: var(--ml-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ml-item__actions { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: .4rem; min-width: 0; }
    .ml-item__actions--single { grid-template-columns: minmax(0, 1fr); }
    .ml-item__actions form { display: contents; }
    .ml-item__actions .ml-btn { min-width: 0; min-height: 2rem; padding: .25rem .5rem; font-size: .78rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ml-empty { grid-column: 1 / -1; padding: 2.5rem 1rem; text-align: center; color: var(--ml-muted); background: #fff; border: 1px dashed var(--ml-border); border-radius: .75rem; }
    .ml-pagination { display: flex; justify-content: center; max-width: 100%; overflow-x: auto; }
    .ml-pagination nav svg { width: 1.1rem; height: 1.1rem; }
    @media (prefers-reduced-motion: reduce) { .ml * { scroll-behavior: auto !important; transition-duration: .01ms !important; } }
</style>

<div class="ml">
    @if (session('status'))
        <div class="ml-alert ml-alert--ok">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="ml-alert ml-alert--err">{{ session('error') }}</div>
    @endif

    <div class="ml-layout">
        <aside class="ml-card ml-sidebar">
            <div class="ml-card__head">
                <span>Thư mục</span>
                <a class="ml-link-all" href="{{ $folderUrl(null) }}" @if (!$currentFolderId) aria-current="page" @endif>Tất cả ảnh</a>
            </div>
            <div class="ml-card__body">
                <div class="ml-tree-wrap">
                    <input class="ml-input ml-tree-filter" type="search" placeholder="Tìm thư mục..." aria-label="Tìm thư mục" data-folder-filter>
                    <div class="ml-tree-scroll">
                        <ul class="ml-tree" data-folder-tree>
                            {!! $renderTree(0) !!}
                        </ul>
                    </div>
                </div>

                @unless ($selectTarget)
                <div class="ml-divider"></div>

                <form class="ml-form" method="POST" action="{{ route('moonshine.media-library.folders.store') }}">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $currentFolderId }}">
                    <label class="ml-label" for="ml-new-folder">{{ $currentFolder ? 'Tạo thư mục con' : 'Tạo thư mục gốc' }}</label>
                    <input id="ml-new-folder" class="ml-input" name="name" required maxlength="120" placeholder="Tên thư mục">
                    <button class="ml-btn ml-btn--primary ml-btn--block" type="submit">Tạo thư mục</button>
                </form>

                @if ($currentFolder)
                    <div class="ml-divider"></div>
                    <form class="ml-form" method="POST" action="{{ route('moonshine.media-library.folders.update', $currentFolder) }}">
                        @csrf
                        @method('PATCH')
                        <label class="ml-label" for="ml-rename-folder">Đổi tên thư mục</label>
                        <input id="ml-rename-folder" class="ml-input" name="name" required maxlength="120" value="{{ $currentFolder->name }}">
                        <button class="ml-btn ml-btn--ghost ml-btn--block" type="submit">Đổi tên</button>
                    </form>
                    <form class="ml-form" style="margin-top: .5rem" method="POST" action="{{ route('moonshine.media-library.folders.destroy', $currentFolder) }}" onsubmit="return confirm('Chỉ thư mục trống mới được xóa. Tiếp tục?')">
                        @csrf
                        @method('DELETE')
                        <button class="ml-btn ml-btn--danger ml-btn--block" type="submit">Xóa thư mục</button>
                    </form>
                @endif
                @endunless
            </div>
        </aside>

        <section class="ml-main">
            <div class="ml-card">
                <div class="ml-card__body ml-toolbar">
                    <div>
                        <div class="ml-crumbs">
                            <a href="{{ $folderUrl(null) }}">Media</a>
                            @foreach ($breadcrumbs as $crumb)
                                <span>/</span>
                                <a href="{{ $folderUrl($crumb->id) }}">{{ $crumb->name }}</a>
                            @endforeach
                        </div>
                        <h1 class="ml-title">{{ $currentFolder?->name ?? 'Tất cả media' }}</h1>
                        <p class="ml-sub">{{ number_format($media->total()) }} ảnh trong mục này · Cloudinary</p>
                    </div>
                    <form class="ml-search" method="GET" action="{{ $libraryUrl }}">
                        @if ($currentFolderId)
                            <input type="hidden" name="folder" value="{{ $currentFolderId }}">
                        @endif
                        @if ($selectTarget)
                            <input type="hidden" name="select" value="{{ $selectTarget }}">
                        @endif
                        <input class="ml-input" name="search" value="{{ $search }}" placeholder="Tìm theo tên file">
                        <button class="ml-btn ml-btn--primary" type="submit">Tìm</button>
                    </form>
                </div>
            </div>

            @unless ($selectTarget)
            @if ($uploadTarget['uploadable'])
            <div class="ml-upload-card">
                <div class="ml-upload-card__intro">
                    <strong>Tải ảnh lên</strong>
                    <span>Chọn nhiều ảnh cùng lúc (tối đa 20). Ảnh được lưu trực tiếp vào Cloudinary{{ $currentFolder ? ' / '.$currentFolder->name : '' }}.</span>
                </div>
                <form class="ml-upload" method="POST" action="{{ route('moonshine.media-library.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="folder_id" value="{{ $currentFolderId }}">
                    <input class="ml-input" type="file" name="files[]" multiple accept="image/jpeg,image/png,image/gif,image/webp" required title="Chọn tối đa 20 ảnh cùng lúc">
                    <input class="ml-input" name="caption" maxlength="255" placeholder="Chú thích chung (tùy chọn)">
                    <button class="ml-btn ml-btn--primary" type="submit">Tải ảnh lên</button>
                </form>
            </div>
            @elseif ($currentFolder)
                <div class="ml-alert ml-alert--info" role="status">{{ $uploadTarget['message'] }}</div>
            @endif
            @endunless

            @if ($subfolders->isNotEmpty())
                <div>
                    <h2 class="ml-section">Thư mục con</h2>
                    <div class="ml-folders">
                        @foreach ($subfolders as $folder)
                            <a class="ml-folder" href="{{ $folderUrl($folder->id) }}" title="{{ $folder->name }}">
                                <svg class="ml-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/></svg>
                                <span class="ml-folder__name">{{ $folder->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div>
                <h2 class="ml-section">Hình ảnh</h2>
                <div class="ml-grid">
                    @forelse ($media as $item)
                        <article class="ml-item">
                            <span class="ml-item__thumb">
                                <img loading="lazy" src="{{ $item->thumbnail_url }}" alt="{{ $item->caption ?: basename($item->file_path) }}">
                            </span>
                            <div class="ml-item__body">
                                <div class="ml-item__text">
                                    <div class="ml-item__name" title="{{ $item->file_path }}">{{ basename($item->file_path) }}</div>
                                    <div class="ml-item__cap" title="{{ $item->caption }}">{{ $item->source }}{{ $item->caption ? ' · '.$item->caption : '' }}</div>
                                </div>
                                <div class="ml-item__actions{{ ($selectTarget || ! $item->upload_id) ? ' ml-item__actions--single' : '' }}">
                                    @if ($selectTarget)
                                        <button class="ml-btn ml-btn--primary js-select-media" type="button" data-target="{{ $selectTarget }}" data-url="{{ $item->url }}" data-thumb="{{ $item->thumbnail_url }}" data-path="{{ $item->file_path }}">Chọn ảnh này</button>
                                    @else
                                        <button class="ml-btn ml-btn--primary js-copy-media" type="button" data-url="{{ $item->url }}">Copy URL</button>
                                        @if ($item->upload_id)
                                            <form method="POST" action="{{ route('moonshine.media-library.media.destroy', $item->upload_id) }}" onsubmit="return confirm('Xóa ảnh này khỏi thư viện? Ảnh trên Cloudinary sẽ không bị xóa.')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="ml-btn ml-btn--danger" type="submit">Xóa ảnh</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="ml-empty">Chưa có ảnh trong thư mục này.</div>
                    @endforelse
                </div>
            </div>

            @if ($media->hasPages())
                <div class="ml-pagination">{{ $media->links() }}</div>
            @endif
        </section>
    </div>
</div>

<script>
    document.querySelectorAll('[data-tree-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const item = button.closest('[data-folder-item]');
            const children = item?.querySelector(':scope > .ml-tree__children');

            if (!children) {
                return;
            }

            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', String(!expanded));
            button.setAttribute('aria-label', `${expanded ? 'Mở' : 'Thu gọn'} thư mục con`);
            children.hidden = expanded;
        });
    });

    document.querySelectorAll('[data-folder-filter]').forEach((input) => {
        input.addEventListener('input', () => {
            const tree = input.closest('.ml-tree-wrap')?.querySelector('[data-folder-tree]');

            if (!tree) {
                return;
            }

            const query = input.value.trim().toLocaleLowerCase();
            const items = [...tree.querySelectorAll('[data-folder-item]')].reverse();

            items.forEach((item) => {
                const name = item.querySelector(':scope > .ml-tree__row .ml-tree__name')?.textContent?.toLocaleLowerCase() ?? '';
                const children = item.querySelector(':scope > .ml-tree__children');
                const button = item.querySelector(':scope > .ml-tree__row [data-tree-toggle]');
                const childMatches = children ? [...children.children].some((child) => !child.hidden) : false;
                const matches = query === '' || name.includes(query) || childMatches;

                item.hidden = !matches;

                if (children && button) {
                    if (query !== '' && childMatches) {
                        children.hidden = false;
                        button.setAttribute('aria-expanded', 'true');
                    } else if (query === '') {
                        const ancestorOfCurrent = button.closest('[data-folder-item]')
                            ?.querySelector(':scope > .ml-tree__children [aria-current="page"]');
                        children.hidden = !ancestorOfCurrent;
                        button.setAttribute('aria-expanded', String(Boolean(ancestorOfCurrent)));
                    }
                }
            });
        });
    });

    document.querySelectorAll('.js-copy-media').forEach((button) => {
        button.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(button.dataset.url);
                button.textContent = 'Đã copy';
            } catch (error) {
                window.prompt('Copy đường dẫn ảnh:', button.dataset.url);
            }
            setTimeout(() => button.textContent = 'Copy URL', 1500);
        });
    });

    document.querySelectorAll('.js-select-media').forEach((button) => {
        button.addEventListener('click', () => {
            if (!window.opener) {
                window.prompt('Cửa sổ này không được mở từ form. Copy đường dẫn ảnh:', button.dataset.url);

                return;
            }

            window.opener.postMessage({
                type: 'moonshine-media-selected',
                target: button.dataset.target,
                url: button.dataset.url,
                thumb: button.dataset.thumb,
                path: button.dataset.path,
            }, window.location.origin);
            window.close();
        });
    });
</script>
