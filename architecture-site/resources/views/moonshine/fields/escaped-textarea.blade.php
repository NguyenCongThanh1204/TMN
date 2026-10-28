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
