<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Contracts\MediaServiceInterface;

class MediaService implements MediaServiceInterface
{
    public function uploadMedia(array $files, $mediable, bool $deleteExisting = false): void
    {
        if ($deleteExisting) {
            $this->deleteAllMedia($mediable);
        }

        foreach ($files as $file) {
            $fileName = $file->hashName();
            $path = $file->storeAs('media', $fileName, 'public');

            $url = Storage::url($path);

            $media = new Media([
                'url' => $url,
                'type' => $this->getMediaType($file->getClientMimeType()),
            ]);

            $mediable->media()->save($media);
        }
    }


    private function deleteAllMedia($mediable): void
    {
        $existingMedia = $mediable->media;

        foreach ($existingMedia as $media) {
            if (Storage::disk('public')->exists('media/' . basename($media->url))) {
                Storage::disk('public')->delete('media/' . basename($media->url));
            }
            $media->delete();
        }
    }

    private function getMediaType(string $mimeType): string
    {
        if (str_starts_with($mimeType, 'image')) {
            return 'image';
        }

        if (str_starts_with($mimeType, 'video')) {
            return 'video';
        }

        return 'unknown';
    }
}
