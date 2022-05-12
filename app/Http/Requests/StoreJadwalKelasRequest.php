<?php

namespace App\Http\Requests;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\PembagianKelas;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class StoreJadwalKelasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $getRuleJadwal = array();
        foreach (Jadwal::all() as $jadwal) {
            $getRuleJadwal[] = '' . $jadwal->id . '';
        }

        $getRulePembagianKelas = array();
        foreach (PembagianKelas::all() as $kelas) {
            $getRulePembagianKelas[] = '' . $kelas->id . '';
        }

        $getRuleGuru = array();
        foreach (Guru::all() as $guru) {
            $getRuleGuru[] = '' . $guru->id . '';
        }

        $getRuleMapel = array();
        foreach (MataPelajaran::all() as $mapel) {
            $getRuleMapel[] = '' . $mapel->id . '';
        }

        return [
            'mapel' => ['required', Rule::in($getRuleMapel)],
            'pembagian_kelas' => ['required', Rule::in($getRulePembagianKelas)],
            'pengajar' => ['required', Rule::in($getRuleGuru)],
            'jadwal' => ['required', Rule::in($getRuleJadwal)],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        foreach ($errors as $errs) {
            foreach ($errs as $error) {
                $errmsg[] = $error;
            }
        }
        Alert::warning('Gagal!', "Gagal menambahkan data. Error = ". $errmsg[0]);
        return redirect()->back();
    }
}
