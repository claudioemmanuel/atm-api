<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

            'name' => [
                'required',
                'max:150'
            ],

            'cpf' => [
                'required',
                'unique:users,cpf',
                'size:11'
            ],

            'birth_date' => [
                'required',
                'date'
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'birth_date' => Carbon::createFromFormat('d/m/Y', $this->birth_date, 'America/Sao_Paulo')->format('Y-m-d')
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'unique'    => 'O :attribute já está em uso',
            'required'  => 'O :attribute é obrigatório'
        ];
    }
}
