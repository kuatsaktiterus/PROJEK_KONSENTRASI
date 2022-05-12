<?php

namespace App\Http\Requests;

use App\Models\Guru;
use App\Models\PembagianKelas;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class StorePembagianKelasRequest extends FormRequest
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
        $id = request()->session()->get('id_kelas');

        $getRuleGuru = array();
        foreach (Guru::all() as $guru) {
            $getRuleGuru[] = '' . $guru->id . '';
        }

        return [
            'nama_kelas' => ['required', Rule::unique('App\Models\PembagianKelas')->where('id_kelas', $id)],
            'wali_kelas' => ['required', Rule::in($getRuleGuru)],
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
