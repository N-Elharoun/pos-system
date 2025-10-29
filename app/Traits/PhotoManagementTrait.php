<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait PhotoManagementTrait
{
    public function createPhoto(Request $request, string $inputName, string $storagePath, string $photoUsage)
    {
        if (!$request->hasFile($inputName)) {
            return;
        }

        $file = $request->file($inputName);
        $fileName = time() . '_' . $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $path = $file->storeAs($storagePath, $fileName, 'public');

        $this->photo()->create([
            'path' => $path,
            'ext' => $ext,
            'usage' => $photoUsage,
        ]);
    }
    public function updatePhoto(Request $request, string $inputName, string $storagePath, string $photoUsage)
    {
        if (!$request->hasFile($inputName)) {
            return;
        }

        $file = $request->file($inputName);
        $fileName = time() . '_' . $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $path = $file->storeAs($storagePath, $fileName, 'public');

        if ($this->photo) {
            Storage::disk('public')->delete($this->photo->path);
            $this->photo()->update([
                'path' => $path,
                'ext' => $ext,
                'usage' => $photoUsage,
            ]);
        } else {
            $this->photo()->create([
                'path' => $path,
                'ext' => $ext,
                'usage' => $photoUsage,
            ]);
        }
    }
    public function createGallery(Request $request, string $inputName, string $storagePath, string $photoUsage)
    {
        if (!$request->hasFile($inputName)) {
            return;
        }

        foreach ($request->file($inputName) as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($storagePath, $fileName, 'public');
            $ext = $file->getClientOriginalExtension();

            $this->gallery()->create([
                'path' => $path,
                'ext' => $ext,
                'usage' => $photoUsage,
            ]);
        }
    }

    /**
     * Update gallery by replacing all existing items.
     */
    public function updateGallery(Request $request, string $inputName, string $storagePath, string $photoUsage)
    {
        if (!$request->hasFile($inputName)) {
            return;
        }

        // Delete old gallery
        foreach ($this->gallery as $oldGallery) {
            Storage::disk('public')->delete($oldGallery->path);
            $oldGallery->delete();
        }

        // Add new gallery items
        $this->createGallery($request, $inputName, $storagePath, $photoUsage);
    }
    public function deletePhoto()
    {
        if ($this->photo) {
            Storage::disk('public')->delete($this->photo->path);
            $this->photo->delete();
        }
    }
    public function deleteGallery()
    {
        foreach ($this->gallery as $oldGallery) {
            Storage::disk('public')->delete($oldGallery->path);
            $oldGallery->delete();
        }
    }
}
