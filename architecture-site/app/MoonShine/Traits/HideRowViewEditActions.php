<?php

declare(strict_types=1);

namespace App\MoonShine\Traits;

use MoonShine\Contracts\UI\ActionButtonContract;

trait HideRowViewEditActions
{
    protected function modifyDetailButton(ActionButtonContract $button): ActionButtonContract
    {
        return $button->class('hidden');
    }

    protected function modifyEditButton(ActionButtonContract $button): ActionButtonContract
    {
        return $button->class('hidden');
    }
}
