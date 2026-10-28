<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use MoonShine\UI\Fields\Text;

final class MediaPicker extends Text
{
    protected string $view = 'app-moonshine::fields.media-picker';

    /**
     * Sibling of an image field: picking sets $column to the chosen library path.
     */
    public static function forColumn(string $label, string $column): self
    {
        $field = self::make($label, $column.'_library');

        return $field
            ->customAttributes(['data-media-target' => $column])
            ->onApply(static function (mixed $item, mixed $value) use ($column, $field): mixed {
                if (is_string($value) && trim($value) !== '') {
                    data_set($item, $column, (string) $value);
                }

                unset($item->{$field->getColumn()});

                return $item;
            });
    }
}
