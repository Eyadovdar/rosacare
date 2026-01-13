<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageService
{
    /**
     * Resize and optimize an image for hero sections
     *
     * @param string $imagePath Path to the image in storage
     * @param string $disk Storage disk name (default: 'public')
     * @param int $maxWidth Maximum width in pixels (default: 1920)
     * @param int $maxHeight Maximum height in pixels (default: 1080)
     * @param int $quality JPEG quality 0-100 (default: 90)
     * @return string|null Resized image path or null on failure
     */
    public static function resizeHeroImage(
        string $imagePath,
        string $disk = 'public',
        int $maxWidth = 1920,
        int $maxHeight = 1080,
        int $quality = 90
    ): ?string {
        return self::resizeImage($imagePath, $disk, $maxWidth, $maxHeight, $quality, 'hero');
    }

    /**
     * Resize and optimize an image for product sections
     *
     * @param string $imagePath Path to the image in storage
     * @param string $disk Storage disk name (default: 'public')
     * @param int $maxWidth Maximum width in pixels (default: 1200)
     * @param int $maxHeight Maximum height in pixels (default: 1200)
     * @param int $quality JPEG quality 0-100 (default: 85)
     * @return string|null Resized image path or null on failure
     */
    public static function resizeProductImage(
        string $imagePath,
        string $disk = 'public',
        int $maxWidth = 1200,
        int $maxHeight = 1200,
        int $quality = 85
    ): ?string {
        return self::resizeImage($imagePath, $disk, $maxWidth, $maxHeight, $quality, 'product');
    }

    /**
     * Generic image resize method
     */
    public static function resizeImage(
        string $imagePath,
        string $disk,
        int $maxWidth,
        int $maxHeight,
        int $quality,
        string $type = 'image'
    ): ?string {
        try {
            // Check if GD extension is available
            if (!extension_loaded('gd')) {
                Log::warning('GD extension not available, skipping image resize', ['path' => $imagePath]);
                return $imagePath;
            }

            // Check if file exists
            if (!Storage::disk($disk)->exists($imagePath)) {
                Log::warning('Image file not found for resizing', ['path' => $imagePath]);
                return $imagePath;
            }

            // Get full path to the image
            $fullPath = Storage::disk($disk)->path($imagePath);

            // Get image info
            $imageInfo = @getimagesize($fullPath);
            if (!$imageInfo) {
                Log::warning('Could not get image info', ['path' => $imagePath]);
                return $imagePath;
            }

            [$originalWidth, $originalHeight, $imageType] = $imageInfo;

            // Check if resizing is needed
            if ($originalWidth <= $maxWidth && $originalHeight <= $maxHeight) {
                // Image is already within limits, but we can still optimize it
                return self::optimizeImage($fullPath, $imagePath, $disk, $imageType, $quality);
            }

            // Calculate new dimensions maintaining aspect ratio
            $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
            $newWidth = (int) round($originalWidth * $ratio);
            $newHeight = (int) round($originalHeight * $ratio);

            // Create image resource from original
            $sourceImage = match ($imageType) {
                IMAGETYPE_JPEG => imagecreatefromjpeg($fullPath),
                IMAGETYPE_PNG => imagecreatefrompng($fullPath),
                IMAGETYPE_GIF => imagecreatefromgif($fullPath),
                IMAGETYPE_WEBP => imagecreatefromwebp($fullPath),
                default => null,
            };

            if (!$sourceImage) {
                Log::warning('Unsupported image type', ['path' => $imagePath, 'type' => $imageType]);
                return $imagePath;
            }

            // Create new image with calculated dimensions
            $newImage = imagecreatetruecolor($newWidth, $newHeight);

            // Preserve transparency for PNG and GIF
            if ($imageType === IMAGETYPE_PNG || $imageType === IMAGETYPE_GIF) {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
            }

            // Resize image with high-quality resampling
            imagecopyresampled(
                $newImage,
                $sourceImage,
                0, 0, 0, 0,
                $newWidth,
                $newHeight,
                $originalWidth,
                $originalHeight
            );

            // Generate new filename with extension
            $pathInfo = pathinfo($imagePath);
            $extension = strtolower($pathInfo['extension'] ?? 'jpg');

            // Use WebP for better compression if supported, otherwise keep original format
            $outputExtension = function_exists('imagewebp')
                ? 'webp'
                : $extension;

            $newFilename = $pathInfo['filename'] . '_resized.' . $outputExtension;
            $newPath = ($pathInfo['dirname'] && $pathInfo['dirname'] !== '.')
                ? $pathInfo['dirname'] . '/' . $newFilename
                : $newFilename;

            // Save resized image
            $tempPath = sys_get_temp_dir() . '/' . uniqid($type . '_resize_', true) . '.' . $outputExtension;

            $saved = match ($outputExtension) {
                'webp' => imagewebp($newImage, $tempPath, $quality),
                'jpg', 'jpeg' => imagejpeg($newImage, $tempPath, $quality),
                'png' => imagepng($newImage, $tempPath, 9),
                'gif' => imagegif($newImage, $tempPath),
                default => false,
            };

            if (!$saved) {
                imagedestroy($sourceImage);
                imagedestroy($newImage);
                Log::error('Failed to save resized image', ['path' => $imagePath]);
                return $imagePath;
            }

            // Upload to storage
            $fileContents = file_get_contents($tempPath);
            Storage::disk($disk)->put($newPath, $fileContents);
            Storage::disk($disk)->setVisibility($newPath, 'public');

            // Clean up
            imagedestroy($sourceImage);
            imagedestroy($newImage);
            @unlink($tempPath);

            // Delete original if different from new path
            if ($newPath !== $imagePath && Storage::disk($disk)->exists($imagePath)) {
                Storage::disk($disk)->delete($imagePath);
            }

            Log::info("{$type} image resized successfully", [
                'original' => $imagePath,
                'resized' => $newPath,
                'original_size' => "{$originalWidth}x{$originalHeight}",
                'new_size' => "{$newWidth}x{$newHeight}",
            ]);

            return $newPath;
        } catch (\Exception $e) {
            Log::error("Error resizing {$type} image", [
                'path' => $imagePath,
                'error' => $e->getMessage(),
            ]);
            return $imagePath; // Return original path on error
        }
    }

    /**
     * Optimize an image without resizing (compress/re-encode)
     */
    protected static function optimizeImage(
        string $fullPath,
        string $imagePath,
        string $disk,
        int $imageType,
        int $quality
    ): string {
        try {
            $sourceImage = match ($imageType) {
                IMAGETYPE_JPEG => imagecreatefromjpeg($fullPath),
                IMAGETYPE_PNG => imagecreatefrompng($fullPath),
                IMAGETYPE_GIF => imagecreatefromgif($fullPath),
                IMAGETYPE_WEBP => imagecreatefromwebp($fullPath),
                default => null,
            };

            if (!$sourceImage) {
                return $imagePath;
            }

            $pathInfo = pathinfo($imagePath);
            $extension = strtolower($pathInfo['extension'] ?? 'jpg');
            $tempPath = sys_get_temp_dir() . '/' . uniqid('hero_optimize_', true) . '.' . $extension;

            $saved = match ($extension) {
                'webp' => imagewebp($sourceImage, $tempPath, $quality),
                'jpg', 'jpeg' => imagejpeg($sourceImage, $tempPath, $quality),
                'png' => imagepng($sourceImage, $tempPath, 9),
                'gif' => imagegif($sourceImage, $tempPath),
                default => false,
            };

            if ($saved) {
                $fileContents = file_get_contents($tempPath);
                Storage::disk($disk)->put($imagePath, $fileContents);
                Storage::disk($disk)->setVisibility($imagePath, 'public');
                @unlink($tempPath);
            }

            imagedestroy($sourceImage);
            return $imagePath;
        } catch (\Exception $e) {
            Log::error('Error optimizing image', [
                'path' => $imagePath,
                'error' => $e->getMessage(),
            ]);
            return $imagePath;
        }
    }
}

