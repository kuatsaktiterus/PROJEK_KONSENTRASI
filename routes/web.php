<?php

use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\JadwalKelasController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\NilaiDanSemesterController;
use App\Http\Controllers\Admin\PembagianKelasController;
use App\Http\Controllers\Admin\PembagianKelasSiswaController;
use App\Http\Controllers\Admin\PengumumanAdminController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Guru\GuruController as GurusContentController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\RaportMataPelajaranController;
use App\Http\Controllers\Siswa\SiswaController as SiswaContentController;
use App\Http\Controllers\PengumumanGuruController;
use App\Http\Controllers\SuperAdmin\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');

Route::prefix('app')->middleware('auth')->group(function()
{
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengumuman-guru/{action}/{id}', [PengumumanGuruController::class, 'actionPengumumanGuru']);
    Route::resource('/pengumuman-guru', PengumumanGuruController::class);
});

Route::prefix('app')->middleware('admin')->group(function () {

    Route::resource('/admin', AdminController::class);
    Route::get('/admin/{action}/{id}', [AdminController::class, 'actionAdmin']);

    Route::resource('/siswa', SiswaController::class);
    Route::get('/siswa/{id}/delete', [SiswaController::class, 'actionDeleteSiswa']);
    Route::post('siswa-import', [SiswaController::class, 'store_from_excel'])->name('siswa.store.excel');
    
    Route::resource('/guru', GuruController::class);
    Route::get('/guru/{id}/delete', [GuruController::class, 'actionDeleteGuru']);
    Route::post('guru-import', [GuruController::class, 'store_from_excel'])->name('guru.store.excel');
    
    Route::resource('/jadwal', JadwalController::class);
    Route::get('/jadwal/{action}/{id}', [JadwalController::class, 'actionJadwal']);

    Route::resource('/kelas', KelasController::class);
    
    Route::resource('/jurusan', JurusanController::class);
    Route::get('/jurusan/{action}/{id}', [JurusanController::class, 'actionJurusan']);
    
    Route::resource('/pembagian-kelas', PembagianKelasController::class);
    Route::get('/pembagian-kelas-siswa/action/{action}/{id}', [PembagianKelasController::class, 'actionPembagianKelas']);
    
    Route::resource('/mata-pelajaran', MataPelajaranController::class);
    Route::get('/mata-pelajaran/{action}/{id}', [MataPelajaranController::class, 'actionMataPelajaran']);

    Route::post('pembagian-kelas-siswa/{id}/{idPembagianKelas}', [App\Http\Controllers\Admin\PembagianKelasSiswaController::class, 'store']);
    Route::resource('/pembagian-kelas-siswa', PembagianKelasSiswaController::class);
    Route::delete('pembagian-kelas-siswa/{pembagian_kelas_siswa}/{idSiswa}', [App\Http\Controllers\Admin\PembagianKelasSiswaController::class, 'destroy'])->name('pembagian-kelas-siswa.destroy');
    
    Route::resource('/jadwal-kelas', JadwalKelasController::class);
    Route::get('/jadwal-kelas/{action}/{id}', [JadwalKelasController::class, 'actionJadwalKelas']);
    
    Route::resource('/pengumuman-sekolah', PengumumanAdminController::class);
    Route::get('/pengumuman-sekolah/{action}/{id}', [PengumumanAdminController::class, 'actionPengumuman']);

    Route::get('/pengumuman-guru/hapus/{id}', [PengumumanGuruController::class, 'actionPengumumanAdmin']);

    Route::put('/ganti-password-superadmin/{id}', [AdminController::class, 'gantiPassword'])->name('change-pass-superadmin.put');

    Route::put('/nilai-semester/{id_arsip}/{id_tahun_ajar}', [NilaiDanSemesterController::class, 'akhiriSemester'])->name('nilai-semester.update');
    Route::post('/nilai-semester', [NilaiDanSemesterController::class, 'mulaiSemester'])->name('nilai-semester.post');

    Route::get('/nilai-semester', [NilaiDanSemesterController::class, 'index'])->name('nilai-semester.index');
    Route::get('/nilai-semester-siswa', [NilaiDanSemesterController::class, 'siswa'])->name('nilai-semester-siswa.index');
    Route::get('/nilai-semester-raport-siswa/{id}/{idSiswa}', [NilaiDanSemesterController::class, 'raportIndex'])->name('nilai-semester-raport.index');
    Route::get('/nilai-semester-list-raport/{id}', [NilaiDanSemesterController::class, 'listRaport'])->name('nilai-semester-list-raport.index');
});

Route::prefix('app')->middleware('guru')->group(function()
{
    Route::get('jadwal-kelas-guru', [GurusContentController::class, 'jadwalKelas'])->name('jadwal-kelas-guru.index');
    Route::get('mata-pelajaran-guru', [GurusContentController::class, 'mataPelajaran'])->name('mata-pelajaran-guru.index');
    Route::get('siswa-guru', [GurusContentController::class, 'siswa'])->name('siswa-guru.index');
    Route::get('pengumuman-guru/{action}/{id}', [PengumumanGuruController::class, 'actionPengumumanGuru']);
    Route::get('profil-guru', [GurusContentController::class, 'profil'])->name('profil-guru.index');
    Route::get('password-guru', [GurusContentController::class, 'indexPassword'])->name('index-password-guru.index');
    Route::put('update-password-guru', [GurusContentController::class, 'updatePassword'])->name('update-password-guru.update');

    // nilai
    Route::get('/nilai-siswa/create/{id_siswa}/{id_jadwal_kelas}', [NilaiController::class, 'create'])->name("nilai-siswa-creata.create");
    Route::post('/nilai-siswa/{id_jadwal_kelas}/{id_siswa}', [NilaiController::class, 'store'])->name('nilai-siswa-siswa.store');
    Route::resource('/nilai-siswa', NilaiController::class);
    Route::get('/nilai-siswa/siswa/{id}', [NilaiController::class, 'siswa'])->name('nilai-siswa-siswa.show');

    Route::get('/perwalian-kelas', [NilaiController::class, 'perwalianKelas'])->name('perwalian-kelas.index');
    Route::get('/perwalian-kelas-siswa/{id}', [NilaiController::class, 'siswaPerwalianKelas'])->name('perwalian-kelas-siswa.index');
    Route::get('/perwalian-kelas-raport/{id}', [NilaiController::class, 'raportPerwalianKelas'])->name('perwalian-kelas-raport.index');
    Route::post('/perwalian-kelas-raport-submit/{id}', [NilaiController::class, 'submitRaportPerwalianKelas'])->name('perwalian-kelas-raport-submit.update');

    Route::put('/raport-matapelajaran', [RaportMataPelajaranController::class, 'update'])->name('raport-matapelajaran.update');
    Route::put('/raport-matapelajaran/{id}', [RaportMataPelajaranController::class, 'submit'])->name('raport-matapelajaran-submit.update');
});

Route::prefix('app')->middleware('siswa')->group(function()
{
    Route::get('guru-siswa', [SiswaContentController::class, 'guru'])->name('guru-siswa.index');
    Route::get('info-kelas-siswa', [SiswaContentController::class, 'infoKelas'])->name('info-kelas-siswa.index');
    Route::get('jadwal-kelas-siswa', [SiswaContentController::class, 'jadwalKelas'])->name('jadwal-kelas-siswa.index');
    Route::get('matapelajaran-siswa', [SiswaContentController::class, 'mataPelajaran'])->name('matapelajaran-siswa.index');
    Route::get('profil-siswa', [SiswaContentController::class, 'profil'])->name('profil-siswa.index');
    Route::get('ganti-password-siswa', [SiswaContentController::class, 'gantiPassword'])->name('ganti-password-siswa.index');
    Route::put('ganti-password-siswa', [SiswaContentController::class, 'gantiPasswordUpdate'])->name('ganti-password-siswa.put');
});

Auth::routes([
    // 'login' => false, // Login routes...

    'register' => false, // Register Routes...

    'reset' => false, // Reset Password Routes...

    'verify' => false, // Email Verification Routes...
]);
