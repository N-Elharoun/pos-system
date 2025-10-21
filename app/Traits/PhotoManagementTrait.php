<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait PhotoManagementTrait
{
    public function uploadPhoto(Request $request, $inputName, $storagePath, $photoUsage)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $fileName = time() . '_' .  $file->getClientOriginalName();
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
    }
    public function uploadGallery(Request $request, $inputName, $storagePath, $photoUsage)
    {
        if ($request->hasfile($inputName)) {
            foreach ($this->gallery as $oldGallery) {
                Storage::disk('public')->delete($oldGallery->path);
                $oldGallery->delete();
            }
            foreach ($request->file($inputName) as $gallery) {
                $fileName = time() . '_' . $gallery->getClientOriginalName();
                $path = $gallery->storeAs($storagePath, $fileName, 'public');
                $ext = $gallery->getClientOriginalExtension();

                $this->gallery()->create([
                    'path' => $path,
                    'ext' => $ext,
                    'usage' => $photoUsage,
                ]);
            }
        }
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
