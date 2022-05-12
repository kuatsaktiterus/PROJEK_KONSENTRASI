<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateAdminRequest extends FormRequest
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
            $id = Crypt::decrypt($this->route('admin'));
            $admin = Admin::find($id);
        } catch (\Throwable $th) {
            abort(404);
        }
        if (request()->filled('password')) {
            return [
                'nama'      => 'required|max:255|string',
                'username'  => 'required|max:255|string|unique:users,username,'.$admin->id_user,
                'password' => ['required',
                 Password::min(8)
                 ->mixedCase()
                 ->letters()
                 ->numbers()
                 ->symbols()
                 ->uncompromised(),
                ]];
        }
        return [
            'nama'      => 'required|max:255|string',
            'username'  => 'required|max:255|string|unique:users,username,'.$admin->id_user,
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
        
        parent::failedValidation($validator);
    }
}
