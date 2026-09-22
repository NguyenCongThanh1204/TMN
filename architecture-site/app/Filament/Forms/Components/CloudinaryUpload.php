<?php

namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\ViewField;

class CloudinaryUpload extends ViewField
{
    protected string $view = 'filament.forms.components.cloudinary-upload';

    protected function setUp(): void
    {
        parent::setUp();

        $this->viewData([
            'signatureUrl' => route('filament.cloudinary.signature'),
        ]);
    }

    public function directory(string | Closure $directory): static
    {
        return $this->viewData(fn () => [
            'directory' => trim((string) $this->evaluate($directory), '/'),
        ]);
    }

    public function image(): static
    {
        return $this;
    }

    public function maxSize(int $kilobytes): static
    {
        return $this->viewData(['maxSize' => $kilobytes * 1024]);
    }

    public function imageEditor(): static
    {
        return $this;
    }

    public function preserveFilenames(bool $condition = true): static
    {
        return $this;
    }

    public function getUploadedFileNameForStorageUsing(Closure $callback): static
    {
        return $this;
    }

    public function multiple(bool $condition = true): static
    {
        return $this->viewData(['isMultiple' => $condition]);
    }

    public function fetchFileInformation(bool $condition = true): static
    {
        return $this;
    }
}
