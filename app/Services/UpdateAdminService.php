<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;

class UpdateAdminService {
    public function UpdateAdmin($admin, $request, $passReq)
    {
        try {
            $admin->update([
                'nama' => $request['nama'],
            ]);

            $admin->User()->update([
                'username' => $request['username'],
            ]);

            if (request()->filled('password')) {
                try {
                    $admin->User()->update([
                        'password' => Hash::make($passReq['password']),
                    ]);
                } catch (\Throwable $th) {
                    return redirect()->back()->withWarningMessage('Anda gagal mengupdate password user');
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}