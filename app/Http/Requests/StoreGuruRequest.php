<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class StoreGuruRequest extends FormRequest
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
        return [
            'nama'                  => 'required|max:255|string',
            'jenis_kelamin'         => ['required', Rule::in('laki-laki', 'perempuan')],
            'nip'                   => 'required|max:255|string|unique:gurus,nip|unique:App\models\User,username',
            'golongan'              => 'required|max:255|string',
            'no_telepon'            => 'required|max:255|string',
            'alamat'                => 'required|max:255|string',
            'pendidikan_terakhir'   => 'required|max:255|string',
            'jurusan_pendidikan'    => 'required|max:255|string',
            'foto'                  => 'mimes:jpeg,jpg,png,webp|max:2048',
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
