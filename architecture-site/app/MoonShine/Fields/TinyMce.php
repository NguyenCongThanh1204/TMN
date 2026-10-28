<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use MoonShine\UI\Fields\Textarea;

final class TinyMce extends Textarea
{
    protected string $view = 'app-moonshine::fields.tiny-mce';
}
