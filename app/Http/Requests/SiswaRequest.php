<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRequest extends FormRequest
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
        $rules = [
            'nis' => 'required|numeric',
            'name' => 'required',
            'kelas_id' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
            'username' => 'required|regex:/^[A-Za-z][A-Za-z0-9]*$/',
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = 'required';
        }

        return $rules;
    }
}
