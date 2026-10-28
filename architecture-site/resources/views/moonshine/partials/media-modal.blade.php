<style>
    .mm-overlay { position: fixed; inset: 0; z-index: 9999; display: none; align-items: center; justify-content: center; padding: 1rem; background: rgba(15, 23, 42, .55); }
    .mm-overlay.is-open { display: flex; }
    .mm-dialog, .mm-dialog button, .mm-dialog input, .mm-dialog p { font-family: inherit; }
    .mm-dialog { display: flex; flex-direction: column; width: min(1100px, 100%); height: min(760px, 100%); overflow: hidden; border-radius: .75rem; background: #fff; color: #0f172a; box-shadow: 0 20px 50px rgba(0, 0, 0, .3); }
    .mm-head { display: flex; align-items: center; gap: .75rem; padding: .75rem 1rem; border-bottom: 1px solid #e2e8f0; }
    .mm-head h3 { margin: 0; font-size: 1rem; font-weight: 600; white-space: nowrap; }
    .mm-head input[type=search] { flex: 1; min-width: 0; padding: .4rem .7rem; border: 1px solid #cbd5e1; border-radius: .5rem; }
    .mm-close { border: 0; background: transparent; font-size: 1.5rem; line-height: 1; cursor: pointer; }
    .mm-body { display: grid; flex: 1; min-height: 0; grid-template-columns: 220px minmax(0, 1fr); }
    .mm-tree { overflow-y: auto; padding: .5rem; border-right: 1px solid #e2e8f0; background: #f8fafc; }
    .mm-tree-tools { display: flex; gap: .4rem; margin-bottom: .4rem; }
    .mm-tool { padding: .2rem .55rem; border: 1px solid #cbd5e1; border-radius: .4rem; background: #fff; font-size: .75rem; cursor: pointer; }
    .mm-tool:hover { background: #e2e8f0; }
    .mm-row { display: flex; align-items: center; min-width: 0; border-radius: .4rem; }
    .mm-row:hover { background: #e2e8f0; }
    .mm-row.is-active { background: #dbeafe; color: #1d4ed8; font-weight: 600; }
    .mm-caret { flex: 0 0 1.4rem; width: 1.4rem; padding: .35rem 0; border: 0; background: transparent; font-size: .8rem; cursor: pointer; }
    .mm-caret:disabled { cursor: default; }
    .mm-link { flex: 1; min-width: 0; overflow: hidden; padding: .35rem .4rem .35rem 0; border: 0; background: transparent; color: inherit; font-weight: inherit; text-align: left; text-overflow: ellipsis; white-space: nowrap; cursor: pointer; font-size: .85rem; }    .mm-main { display: flex; min-width: 0; min-height: 0; flex-direction: column; }
    .mm-grid { display: grid; flex: 1; align-content: start; gap: .75rem; overflow-y: auto; padding: 1rem; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); grid-auto-rows: max-content; overscroll-behavior: contain; }
    .mm-card { flex-shrink: 0; display: flex; min-width: 0; flex-direction: column; overflow: hidden; padding: 0; border: 1px solid #e2e8f0; border-radius: .6rem; background: #fff; cursor: pointer; text-align: left; }
    .mm-card:hover { border-color: #3b82f6; box-shadow: 0 0 0 2px #bfdbfe; }
    .mm-card img { width: 100%; aspect-ratio: 4 / 3; object-fit: cover; background: #f1f5f9; }
    .mm-card span { display: block; overflow: hidden; padding: .4rem .5rem; font-size: .75rem; text-overflow: ellipsis; white-space: nowrap; }
    .mm-card.is-picked { border-color: #16a34a; box-shadow: 0 0 0 2px #bbf7d0; }
    .mm-status { padding: 2rem 1rem; color: #64748b; text-align: center; grid-column: 1 / -1; }
    .mm-foot { padding: .5rem 1rem; border-top: 1px solid #e2e8f0; text-align: center; }
    @media (max-width: 720px) { .mm-body { grid-template-columns: 1fr; grid-template-rows: auto minmax(0, 1fr); } .mm-tree { max-height: 7rem; border-right: 0; border-bottom: 1px solid #e2e8f0; } }
</style>

<script>
    (() => {
        if (window.MediaModal) {
            return;
        }

        const browseUrl = @js(route('moonshine.media-library.browse'));
        const cache = new Map();
        let overlay = null;
        let state = null;

        const el = (tag, className, text) => {
            const node = document.createElement(tag);
            if (className) node.className = className;
            if (text !== undefined) node.textContent = text;
            return node;
        };

        const fetchPage = (params) => {
            const url = new URL(browseUrl, window.location.origin);
            Object.entries(params).forEach(([key, value]) => {
                if (value !== null && value !== undefined && value !== '') url.searchParams.set(key, value);
            });
            const key = url.toString();

            if (!cache.has(key)) {
                cache.set(key, fetch(key, { headers: { Accept: 'application/json' }, credentials: 'same-origin' })
                    .then((response) => {
                        if (!response.ok) throw new Error('HTTP ' + response.status);
                        return response.json();
                    })
                    .catch((error) => { cache.delete(key); throw error; }));
            }

            return cache.get(key);
        };

        const close = () => overlay?.classList.remove('is-open');

        const build = () => {
            overlay = el('div', 'mm-overlay');
            overlay.innerHTML = `
                <div class="mm-dialog" role="dialog" aria-modal="true" aria-label="Media Library">
                    <div class="mm-head">
                        <h3>Chọn ảnh từ thư viện</h3>
                        <input type="search" placeholder="Tìm theo tên ảnh..." data-mm-search>
                        <button type="button" class="mm-close" data-mm-close aria-label="Đóng">&times;</button>
                    </div>
                    <div class="mm-body">
                        <div class="mm-tree" data-mm-tree></div>
                        <div class="mm-main">
                            <div class="mm-grid" data-mm-grid></div>
                            <div class="mm-foot" data-mm-foot hidden><button type="button" class="btn" data-mm-more>Tải thêm</button> <button type="button" class="btn btn-primary" data-mm-done hidden>Xong</button></div>
                        </div>
                    </div>
                </div>`;
            document.body.appendChild(overlay);

            overlay.addEventListener('click', (event) => {
                if (event.target === overlay || event.target.closest('[data-mm-close]') || event.target.closest('[data-mm-done]')) close();
                if (event.target.closest('[data-mm-more]')) load(state.folder, state.search, state.page + 1, true);
            });

            let timer = null;
            overlay.querySelector('[data-mm-search]').addEventListener('input', (event) => {
                clearTimeout(timer);
                timer = setTimeout(() => load(state.folder, event.target.value.trim(), 1, false), 250);
            });
        };

        const expanded = new Set();
        let lastFolders = [];
        let lastActive = null;

        const renderTree = (folders, activeId) => {
            lastFolders = folders;
            lastActive = activeId;

            const byId = new Map(folders.map((folder) => [folder.id, folder]));
            for (let node = byId.get(activeId); node && node.parent_id != null; node = byId.get(node.parent_id)) {
                expanded.add(node.parent_id);
            }

            const tree = overlay.querySelector('[data-mm-tree]');
            tree.replaceChildren();

            const tools = el('div', 'mm-tree-tools');
            const toggleAll = (open) => {
                folders.forEach((folder) => open ? expanded.add(folder.id) : expanded.delete(folder.id));
                renderTree(lastFolders, lastActive);
            };
            [['Mở hết', true], ['Thu gọn', false]].forEach(([label, open]) => {
                const tool = el('button', 'mm-tool', label);
                tool.type = 'button';
                tool.addEventListener('click', () => toggleAll(open));
                tools.appendChild(tool);
            });
            tree.appendChild(tools);

            const add = (label, id, depth, hasChildren) => {
                const row = el('div', 'mm-row' + (id === activeId ? ' is-active' : ''));
                row.style.paddingLeft = (0.25 + depth * 0.9) + 'rem';

                const caret = el('button', 'mm-caret', hasChildren ? (expanded.has(id) ? '▾' : '▸') : '');
                caret.type = 'button';
                caret.disabled = !hasChildren;
                caret.setAttribute('aria-label', expanded.has(id) ? 'Thu gọn' : 'Mở rộng');
                caret.addEventListener('click', () => {
                    expanded.has(id) ? expanded.delete(id) : expanded.add(id);
                    renderTree(lastFolders, lastActive);
                });

                const link = el('button', 'mm-link', label);
                link.type = 'button';
                link.title = label;
                link.addEventListener('click', () => load(id, state.search, 1, false));

                row.append(caret, link);
                tree.appendChild(row);
            };

            const walk = (parentId, depth) => folders
                .filter((folder) => (folder.parent_id ?? null) === parentId)
                .forEach((folder) => {
                    const hasChildren = folders.some((child) => child.parent_id === folder.id);
                    add(folder.name, folder.id, depth, hasChildren);

                    if (hasChildren && expanded.has(folder.id)) {
                        walk(folder.id, depth + 1);
                    }
                });

            add('Tất cả ảnh', null, 0, false);
            walk(null, 0);
        };
        const renderItems = (items, append) => {
            const grid = overlay.querySelector('[data-mm-grid]');
            if (!append) grid.replaceChildren();

            if (!append && items.length === 0) {
                grid.appendChild(el('div', 'mm-status', 'Không có ảnh nào.'));
                return;
            }

            items.forEach((item) => {
                const card = el('button', 'mm-card');
                card.type = 'button';
                card.title = item.caption || item.file_path;
                const img = el('img');
                img.loading = 'lazy';
                img.alt = '';
                img.src = item.thumbnail_url || item.url;
                card.append(img, el('span', '', item.caption || item.file_path.split('/').pop()));
                card.addEventListener('click', () => {
                    if (state.multiple) {
                        card.classList.add('is-picked');
                    } else {
                        close();
                    }

                    state.onSelect({ path: item.file_path, url: item.url, thumb: item.thumbnail_url || item.url });
                });
                grid.appendChild(card);
            });
        };

        const load = (folder, search, page, append) => {
            state.folder = folder;
            state.search = search;
            state.page = page;

            const grid = overlay.querySelector('[data-mm-grid]');
            if (!append) {
                grid.replaceChildren(el('div', 'mm-status', 'Đang tải...'));
            }

            const hint = folder === null && page === 1 && !state.hintUsed ? state.hint : '';

            return fetchPage({ folder, hint, search, page })
                .then((data) => {
                    state.hintUsed = true;
                    state.folder = data.folder_id;
                    renderTree(data.folders, data.folder_id);
                    renderItems(data.items, append);
                    overlay.querySelector('[data-mm-more]').hidden = !data.has_more;
                    overlay.querySelector('[data-mm-foot]').hidden = !data.has_more && !state.multiple;
                })
                .catch(() => {
                    grid.replaceChildren(el('div', 'mm-status', 'Không tải được thư viện. Vui lòng thử lại.'));
                });
        };

        window.MediaModal = {
            open({ hint = '', multiple = false, onSelect }) {
                if (!overlay) build();
                state = { folder: null, search: '', page: 1, hint, hintUsed: false, multiple, onSelect };
                overlay.querySelector('[data-mm-done]').hidden = !multiple;
                overlay.querySelector('[data-mm-search]').value = '';
                overlay.classList.add('is-open');
                load(null, '', 1, false);
            },
            prefetch() {
                fetchPage({}).catch(() => {});
            },
        };

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') close();
        });

        (window.requestIdleCallback || ((callback) => setTimeout(callback, 1500)))(() => window.MediaModal.prefetch());
    })();
</script>
