<?php

namespace App\Http\Controllers\SuperAdmin;

use App\DataTables\SuperAdmin\AdminDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Admin;
use App\Models\User;
use App\Services\CreateUserService;
use App\Services\UpdateAdminService;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('superadmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminDatatable $dataTable)
    {
        return $dataTable->render('app.super-admin.admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(AdminCreateRequest $request)
    {
        $request = $request->validated();

        $request['role'] = 'admin';

        try {
            $user = (new CreateUserService())->CreateUser($request);
    
            $user->Admin()->create([
                'nama' => $request['nama'],
            ]);
        } catch (\Throwable $th) {
            $user->delete();
            return redirect()->back()->withWarningMessage('Gagal menambahkan data admin, '. $th->getMessage() );
        }
        return redirect()->back()->withSuccessMessage('Berhasil menambahkan data admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $admin = Admin::findOrFail($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        return $admin;
    }

    public function actionAdmin($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $admin = Admin::findOrFail($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
        $returnHTML = view('app.super-admin.admin_action', ['data' => $admin, 'action' => $action])->render();
        return response()->json(['html' => $returnHTML]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        $request = $request->validated();

        try {
            $id = Crypt::decrypt($id);
            $admin = Admin::find($id);

            (new UpdateAdminService())->UpdateAdmin($admin, $request, $request);
            return redirect()->back()->withSuccessMessage('Berhasil mengedit data admin');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal mengedit data admin, '. $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            $admin = Admin::find($id);
            $id = $admin->user->id;
            User::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus data admin, '. $e->getMessage());
        }
    }


    // ganti password superadmin
    public function gantiPassword(UpdatePasswordRequest $request)
    {
        $request = $request->validated();

        try {
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request['newPassword'])]);
            return redirect()->back()->withSuccessMessage('Berhasil mengganti password');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal mengganti password, '. $e->getMessage());
        }
    }
}
