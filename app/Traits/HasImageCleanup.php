<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

trait HasImageCleanup
{
    /**
     * Get the image fields that should be cleaned up
     */
    protected function getImageFields(): array
    {
        return ['image', 'icon', 'photo', 'picture'];
    }

    /**
     * Get the model name for logging
     */
    protected function getModelName(): string
    {
        return class_basename($this);
    }

    /**
     * Clean up image files when model is deleted
     */
    public static function bootHasImageCleanup()
    {
        static::deleted(function ($model) {
            $model->cleanupImages();
        });

        static::updated(function ($model) {
            $model->cleanupOldImages();
        });
    }

    /**
     * Clean up all image files for this model
     */
    public function cleanupImages(): void
    {
        foreach ($this->getImageFields() as $field) {
            if ($this->$field) {
                $this->deleteImageFile($this->$field, $field);
            }
        }
    }

    /**
     * Clean up old images when they are replaced
     */
    public function cleanupOldImages(): void
    {
        foreach ($this->getImageFields() as $field) {
            if ($this->wasChanged($field)) {
                $oldImage = $this->getOriginal($field);
                
                // Delete the old image if it exists and is different from the new one
                if ($oldImage && $oldImage !== $this->$field) {
                    $this->deleteImageFile($oldImage, $field);
                }
            }
        }
    }

    /**
     * Delete image file from storage
     */
    protected function deleteImageFile(?string $imagePath, string $fieldName = 'image'): void
    {
        if (!$imagePath) {
            return;
        }

        try {
            // Try to delete from storage disk first
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Log::info("Deleted {$fieldName} file from storage disk: {$imagePath}", [
                    'model' => $this->getModelName(),
                    'field' => $fieldName
                ]);
                return;
            }
            
            // Fallback to direct file deletion if storage disk fails
            $fullPath = storage_path('app/public/' . $imagePath);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
                Log::info("Deleted {$fieldName} file directly: {$imagePath}", [
                    'model' => $this->getModelName(),
                    'field' => $fieldName
                ]);
                return;
            }

            Log::info("Image file not found for deletion: {$imagePath}", [
                'model' => $this->getModelName(),
                'field' => $fieldName
            ]);

        } catch (\Exception $e) {
            // Log the error but don't throw it to prevent breaking the deletion process
            Log::warning("Failed to delete {$fieldName} file: {$imagePath}", [
                'error' => $e->getMessage(),
                'model' => $this->getModelName(),
                'field' => $fieldName
            ]);
        }
    }
}
