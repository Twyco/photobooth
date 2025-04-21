<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Imagick;

class ConvertToWebP
{
    public static function convertAndSave(string $sourcePath, string $destinationPath): void
    {
        $relativeDestPath = Str::replaceFirst(Storage::disk('public')->path(''), '', $destinationPath);

        try {
            $image = new Imagick;
            $image->readImage($sourcePath);
            $image->setImageFormat('webp');
            $image->setImageCompressionQuality(10);
            $image->setOption('webp:method', '6');
            $image->setOption('webp:lossless', 'false');

            Storage::disk('public')->put($relativeDestPath, $image->getImageBlob());
            $image->clear();
            $image->destroy();
        } catch (Exception $e) {
            Log::error('Fehler beim Konvertieren zu WebP: '.$e->getMessage());
        }
    }
}
