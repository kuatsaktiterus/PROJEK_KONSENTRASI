<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateMataPelajaranRequest extends FormRequest
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
        try {
            $id = Crypt::decrypt($this->route('mata_pelajaran'));
        } catch (DecryptException $e) {
            return abort(404);
        }

        return [
            'nama_mapel'            => 'required|max:255|string|unique:App\Models\MataPelajaran,nama_mapel,'.$id,
            'kkm'                   => 'required|max:100|integer',
            'deskripsi_predikat_a'  => 'required|string',
            'deskripsi_predikat_b'  => 'required|string',
            'deskripsi_predikat_c'  => 'required|string',
            'deskripsi_predikat_d'  => 'required|string',
            'semester'              => 'required|integer|between:1,6',
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
