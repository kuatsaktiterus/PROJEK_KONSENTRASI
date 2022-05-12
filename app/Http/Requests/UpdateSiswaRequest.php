<?php

namespace App\Http\Requests;

use App\Models\Jurusan;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateSiswaRequest extends FormRequest
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
        $getRuleJurusan = array();
        foreach (Jurusan::all() as $jurusan) {
            $getRuleJurusan[] = '' . $jurusan->id . '';
        }

        return (request()->filled('password')) ? 
        [
            'nama' => 'required|max:255|string',
            'jenis_kelamin' => ['required', Rule::in('laki-laki', 'perempuan')],
            'no_telepon' => 'required|max:255|string',
            'tempat_lahir' => 'required|max:255|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|max:255|string',
            'alamat_lengkap' => 'required|max:255|string',
            'alamat_rt' => 'required|max:255|string',
            'alamat_rw' => 'required|max:255|string',
            'alamat_kelurahan' => 'required|max:255|string',
            'alamat_kecamatan' => 'required|max:255|string',
            'kode_pos' => 'required|max:8|string',
            'tinggal_bersama' => ['required', Rule::in('orang tua', 'wali', 'sendiri')],
            'transportasi' => ['required', Rule::in('angkutan umum', 'kendaraan pribadi', 'antar jemput', 'jalan kaki')],
            'jurusan' => ['required', Rule::in($getRuleJurusan)],
            'foto' => 'mimes:jpeg,jpg,png,webp|max:2048',
            'password' => ['required',
                     Password::min(8)
                     ->mixedCase()
                     ->letters()
                     ->numbers()
                     ->symbols()
                     ->uncompromised(),
                ],
        ] :
        [
            'nama' => 'required|max:255|string',
            'jenis_kelamin' => ['required', Rule::in('laki-laki', 'perempuan')],
            'no_telepon' => 'required|max:255|string',
            'tempat_lahir' => 'required|max:255|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|max:255|string',
            'alamat_lengkap' => 'required|max:255|string',
            'alamat_rt' => 'required|max:255|string',
            'alamat_rw' => 'required|max:255|string',
            'alamat_kelurahan' => 'required|max:255|string',
            'alamat_kecamatan' => 'required|max:255|string',
            'kode_pos' => 'required|max:8|string',
            'tinggal_bersama' => ['required', Rule::in('orang tua', 'wali', 'sendiri')],
            'transportasi' => ['required', Rule::in('angkutan umum', 'kendaraan pribadi', 'antar jemput', 'jalan kaki')],
            'jurusan' => ['required', Rule::in($getRuleJurusan)],
            'foto' => 'mimes:jpeg,jpg,png,webp|max:2048',
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
        Alert::warning('Gagal!', "Gagal mengubah data. Error = ". $errmsg[0]);
        return redirect()->back();
    }
}
