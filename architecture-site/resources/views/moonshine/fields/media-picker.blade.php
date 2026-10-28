@props([
    'value' => '',
    'label' => '',
])

@php
    $target = $attributes->get('data-media-target', 'thumbnail');
@endphp

<div class="space-y-2" data-media-picker data-media-target="{{ $target }}">
    <input
        {{ $attributes->except('data-media-target')->merge(['type' => 'hidden']) }}
        value="{{ $value ?? '' }}"
        data-media-picker-input
    >
    <div class="flex flex-wrap items-center gap-2">
        <button class="btn btn-secondary" type="button" data-media-picker-open>Chọn ảnh từ thư viện</button>
        <button class="btn" type="button" data-media-picker-clear hidden>Bỏ chọn</button>
    </div>
    <div class="flex items-center gap-3" data-media-picker-selected hidden>
        <img class="h-16 w-16 rounded-md object-cover" alt="" data-media-picker-preview>
        <span class="min-w-0 break-all text-xs text-slate-500" data-media-picker-path></span>
    </div>
    <!-- <p class="text-xs text-slate-500">áº¢nh Ä‘Ã£ cÃ³ trong Media Library sáº½ Ä‘Æ°á»£c dÃ¹ng láº¡i, khÃ´ng táº£ilÃªn trÃ¹ng. Náº¿u chÆ°a cÃ³, hÃ£y táº£i áº£nh tá»« mÃ¡y á»Ÿ Ã´ phÃ­a trÃªn.</p> -->
</div>

@include('app-moonshine::partials.media-modal')

<script>
    (() => {
        if (window.__mediaPickerBound) {
            return;
        }

        window.__mediaPickerBound = true;

        const render = (picker, path, thumb) => {
            const selected = picker.querySelector('[data-media-picker-selected]');
            const clear = picker.querySelector('[data-media-picker-clear]');
            const preview = picker.querySelector('[data-media-picker-preview]');

            picker.querySelector('[data-media-picker-input]').value = path;
            picker.querySelector('[data-media-picker-path]').textContent = path;
            preview.src = thumb || '';
            selected.hidden = clear.hidden = path === '';
        };

        document.addEventListener('click', (event) => {
            const open = event.target.closest('[data-media-picker-open]');
            const clear = event.target.closest('[data-media-picker-clear]');

            if (open) {
                const picker = open.closest('[data-media-picker]');
                const hint = picker.closest('form')?.querySelector('[name="slug"]')?.value || '';

                window.MediaModal.open({
                    hint,
                    onSelect: ({ path, url, thumb }) => render(picker, path || url, thumb || url),
                });
            }

            if (clear) {
                render(clear.closest('[data-media-picker]'), '', '');
            }
        });

    })();
</script>
