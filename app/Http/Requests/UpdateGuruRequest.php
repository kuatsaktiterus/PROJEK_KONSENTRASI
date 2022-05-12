<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateGuruRequest extends FormRequest
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
        return (request()->filled('password')) ?
        [
            'nama'                  => 'required|max:255|string',
            'jenis_kelamin'         => ['required', Rule::in('laki-laki', 'perempuan')],
            'golongan'              => 'required|max:255|string',
            'no_telepon'            => 'required|max:255|string',
            'alamat'                => 'required|max:255|string',
            'pendidikan_terakhir'   => 'required|max:255|string',
            'jurusan_pendidikan'    => 'required|max:255|string',
            'foto'                  => 'mimes:jpeg,jpg,png,webp|max:2048',
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
            'nama'                  => 'required|max:255|string',
            'jenis_kelamin'         => ['required', Rule::in('laki-laki', 'perempuan')],
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
        Alert::warning('Gagal!', "Gagal mengubah data. Error = ". $errmsg[0]);
        return redirect()->back();
    }
}
