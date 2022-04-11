<?php

namespace App\Http\Controllers\SuperAdmin;

use App\DataTables\SuperAdmin\AdminDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCreateRequest;
use App\Models\Admin;
use App\Models\User;
use App\Services\CreateUserService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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

        try {
            $user = (new CreateUserService())->CreateUser($request);
    
            $user->admin->create([
                'nama' => $request['nama'],
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal menambahkan data admin, '. $th->getMessage() );
        }
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
