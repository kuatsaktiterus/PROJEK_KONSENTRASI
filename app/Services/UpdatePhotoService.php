<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UpdatePhotoService {
    public function UpdatePhoto($file, $path, $user)
    {
        try {
            $file = storage_path('app/public/image/siswa/') . $path;
            if (is_file($file) && ($user->foto != 'Default.png')) {
                Storage::delete("/public/image/siswa/". $user->foto);
            }
    
            $name = (new UploadPhotoService)->UploadPhoto($path);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $name;
    }
}