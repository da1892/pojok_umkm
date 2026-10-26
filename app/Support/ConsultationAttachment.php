<?php

namespace App\Support;

use ArrayAccess;
use JsonSerializable;
use Stringable;
use Illuminate\Support\Facades\Storage;

class ConsultationAttachment implements Stringable, ArrayAccess, JsonSerializable
{
    public string $path;
    public string $name;
    public ?string $data;
    public string $url;
    public string $view_url;
    public bool $is_image;
    public string $extension;
    public bool $exists;

    public function __construct(array $attributes = [])
    {
        $this->path = (string)($attributes['path'] ?? '');
        $this->name = (string)($attributes['name'] ?? basename($this->path));
        $this->data = !empty($attributes['data']) ? (string)$attributes['data'] : null;

        $targetName = !empty($this->path) ? $this->path : $this->name;
        $this->extension = strtolower(pathinfo($targetName, PATHINFO_EXTENSION));
        $this->is_image = in_array($this->extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg']);

        $disk = Storage::disk('public');
        $localExists = !empty($this->path) && ($disk->exists($this->path) || file_exists(public_path('storage/' . $this->path)));

        // Self-heal: If physical file is missing locally on this computer, but base64 data exists in DB, restore it!
        if (!$localExists && !empty($this->data) && !empty($this->path)) {
            try {
                if (str_contains($this->data, ';base64,')) {
                    [, $encoded] = explode(';base64,', $this->data, 2);
                    $disk->put($this->path, base64_decode($encoded));
                    $localExists = true;
                }
            } catch (\Throwable $e) {
                // If writing fails (e.g. read-only fs), data URI will still be used
            }
        }

        $this->exists = $localExists || !empty($this->data);
        $this->url = !empty($this->path) ? asset('storage/' . $this->path) : ($this->data ?? '#');
        // view_url prefers data URI if local physical file doesn't exist, or fallback to asset URL
        $this->view_url = !empty($this->data) ? $this->data : $this->url;
    }

    public function __toString(): string
    {
        return $this->path;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->{$offset});
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->{$offset} ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->{$offset} = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->{$offset});
    }

    public function jsonSerialize(): mixed
    {
        return [
            'path' => $this->path,
            'name' => $this->name,
            'data' => $this->data,
            'url' => $this->url,
            'view_url' => $this->view_url,
            'is_image' => $this->is_image,
            'extension' => $this->extension,
            'exists' => $this->exists,
        ];
    }
}
