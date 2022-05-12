<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UploadPhotoService {
    public function UploadPhoto($path)
    {
        try {
            $image = request()->file('foto');
            $name = time().$image->getClientOriginalName();
            Storage::putFileAs("/public/image/$path/", $image, $name);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $name;
    }
}