<?php

namespace App\Http\Controllers\Guru;

use App\DataTables\Guru\Nilai\KelasDatatable;
use App\DataTables\Guru\Nilai\MataPelajaranDatatable;
use App\DataTables\Guru\Nilai\SiswaDatatable;
use App\DataTables\Guru\PerwalianKelas\KelasDataTable as PerwalianKelasKelasDataTable;
use App\DataTables\Guru\PerwalianKelas\SiswaDataTable as PerwalianKelasSiswaDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNilaiRequest;
use App\Models\ArsipRekapitulasiKelas;
use App\Models\JadwalKelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\PembagianKelas;
use App\Models\PembagianKelasSiswa;
use App\Models\Raport;
use App\Models\RaportMataPelajaran;
use App\Models\RekapitulasiKelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Services\CreateNilaiService;
use App\Services\CreateRaportMataPelajaranService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class NilaiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guru');
    }

    public function index(MataPelajaranDatatable $dataTable)
    {
        return $dataTable->with('id', Auth::user()->guru->id)->render('app.guru.nilai.mata-pelajaran');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_siswa, $id_jadwal_kelas)
    {
        try {
            
            $idSiswa = Crypt::decrypt($id_siswa);
            $idJadwalKelas = Crypt::decrypt($id_jadwal_kelas);

            $nilaiSiswa = Nilai::where('id_siswa', $idSiswa)->where('id_jadwal_kelas', $idJadwalKelas)->first();

            $jadwalKelas = JadwalKelas::findOrFail($idJadwalKelas);

            $mataPelajaran = $jadwalKelas->MataPelajaran;
            $pembagianKelas = $jadwalKelas->PembagianKelas;
            $tahunAjar = TahunAjaran::where('aktif', true)->first();
            $siswa = Siswa::findOrFail($idSiswa);

            $raport = ArsipRekapitulasiKelas::where('id_tahun_ajaran', $tahunAjar->id)->first()->Raport->where('id_siswa', $idSiswa)->first();
            $raportMataPelajaran = RaportMataPelajaran::where('id_raport', $raport->id)->where('mata_pelajaran', $mataPelajaran->nama_mapel)->first();
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        
        return view("app.guru.nilai.nilai", 
        [
            'nilaiSiswa' => $nilaiSiswa,
            'mataPelajaran' => $mataPelajaran, 
            'pembagianKelas' => $pembagianKelas, 
            'jadwalKelas' => $jadwalKelas, 
            'tahunAjar' => $tahunAjar,
            'siswa' => $siswa,
            'raport' => $raport,
            'raportMataPelajaran' => $raportMataPelajaran
        ]);
    }

    public function perwalianKelas(PerwalianKelasKelasDataTable $dataTable)
    {
        return $dataTable->with('id', Auth::user()->guru->id)->render('app.guru.nilai.perwalian-kelas.perwalian-kelas');
    }

    public function siswaPerwalianKelas($id, PerwalianKelasSiswaDataTable $dataTable)
    {
        try {
            $id = Crypt::decrypt($id);
            $rekapitulasiKelas = RekapitulasiKelas::where('id_pembagian_kelas', $id)->first();
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        return $dataTable->with('id', $id)->render('app.guru.nilai.perwalian-kelas.siswa', ['id' => $id, 'rekap' => $rekapitulasiKelas]);
    }

    public function raportPerwalianKelas($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $tahunAjar = TahunAjaran::where('aktif', true)->first();
            $raport = Raport::whereHas('ArsipRekapitulasiKelas', function ($q) use($tahunAjar)
            {
                $q->where('id_tahun_ajaran', $tahunAjar->id);
            })->where('id_siswa', $id)->first();
            $pembagianKelas = PembagianKelasSiswa::where('id_siswa', $id)->first()->pembagiankelas;
            $raportMataPelajaran = RaportMataPelajaran::where('id_raport', $raport->id)->where('submit', true)->get();
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        return view('app.guru.nilai.perwalian-kelas.raport', [
            'raport' => $raport, 
            'raportMataPelajaran' => $raportMataPelajaran,
            'pembagianKelas' => $pembagianKelas
        ]);
    }

    public function store($id_jadwal_kelas, $id_siswa, StoreNilaiRequest $request)
    {
        $createNilaiService = new CreateNilaiService;
        try {
            $id_jadwal_kelas = Crypt::decrypt($id_jadwal_kelas);
            $id_siswa = Crypt::decrypt($id_siswa);
            $jadwalKelas = JadwalKelas::findOrFail($id_jadwal_kelas);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $request = $request->validated();
        $raportMataPelajaran = RaportMataPelajaran::find($request['id_raport_mata_pelajaran']);
        if ($raportMataPelajaran && $raportMataPelajaran['submit']) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data nilai, Raport Telah Disubmit');
        }

        try {
            $createNilaiService->CreateNilai($request, $id_jadwal_kelas, $id_siswa);

            if ($request['tugas'] && $request['ulangan_harian'] && $request['uts'] && $request['uas']) {

                $nilai = ($request['tugas'] * 0.4) + ($request['ulangan_harian'] * 0.2) + ($request['uts'] * 0.1) + ($request['uas'] * 0.3);
                $nilai = (int) $nilai;
                (new CreateRaportMataPelajaranService)->CreateRaportMataPelajaran($nilai, $jadwalKelas, $request);
            } elseif ($request['id_raport_mata_pelajaran']) {
                RaportMataPelajaran::destroy($request['id_raport_mata_pelajaran']);
            }
            
            return redirect()->back()->withSuccessMessage('Berhasil menyimpan nilai');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data nilai '. $th->getMessage())->withInput();
        }
    }

    public function show($id_matapelajaran, KelasDatatable $dataTable)
    {
        try {
            $id_matapelajaran = Crypt::decrypt($id_matapelajaran);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        return $dataTable->with('id', $id_matapelajaran)->render('app.guru.nilai.kelas');
    }

    public function submitRaportPerwalianKelas($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            $arsipRekapitulasiKelas = TahunAjaran::where('aktif', true)->first()->ArsipRekapitulasiKelas;
            RekapitulasiKelas::create([
                'id_pembagian_kelas' => $id,
                'id_arsip_rekapitulasi_kelas' => $arsipRekapitulasiKelas->id,
            ]);
            return redirect()->back()->withSuccessMessage('Berhasil mensubmit raport');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal mensubmit data raport '. $th->getMessage());
        }
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
        //
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

    public function siswa($id_jadwal_kelas, SiswaDatatable $dataTable)
    {
        try {
            $id_jadwal_kelas = Crypt::decrypt($id_jadwal_kelas);
            $jadwalKelas = JadwalKelas::findOrFail($id_jadwal_kelas);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }


        return $dataTable->with(['id' => $id_jadwal_kelas, 'id_pembagian_kelas' => $jadwalKelas->PembagianKelas->id])->render('app.guru.nilai.siswa', ['data' => $jadwalKelas]);
    }
}
