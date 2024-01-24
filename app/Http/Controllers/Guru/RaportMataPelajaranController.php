<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRaportMataPelajaranRequest;
use App\Models\RaportMataPelajaran;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RaportMataPelajaranController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guru');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(UpdateRaportMataPelajaranRequest $request)
    {
        $request = $request->validated();

        $raportMataPelajaran = RaportMataPelajaran::findOrFail($request['id_raport_mata_pelajaran']);
        if ($raportMataPelajaran && $raportMataPelajaran['submit']) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data nilai, Raport Telah Disubmit');
        }

        try {
            $raportMataPelajaran->update(
                [
                    'nilai_keterampilan' => $request['nilai'],
                    'predikat_keterampilan' => $request['predikat'],
                    'deskripsi_keterampilan' => $request['deskripsi']
                ]
            );
            
            return redirect()->back()->withSuccessMessage('Berhasil menyimpan nilai');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data nilai '. $th->getMessage())->withInput();
        }
    }

    public function submit($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            RaportMataPelajaran::findOrFail($id)->update([
                'submit' => true
            ]);

            return redirect()->back()->withSuccessMessage('Berhasil mensubmit nilai');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal mensubmit data nilai '. $th->getMessage());
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
        //
    }
}
