<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class StoreNilaiRequest extends FormRequest
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
            'id' => 'nullable|numeric',
            'id_raport' => 'nullable|numeric',
            'id_raport_mata_pelajaran' => 'nullable|numeric',
            'tugas' => 'numeric|between:0,100|nullable',
            'ulangan_harian' => 'numeric|between:0,100|nullable',
            'uts' => 'numeric|between:0,100|nullable',
            'uas' => 'numeric|between:0,100|nullable'
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
