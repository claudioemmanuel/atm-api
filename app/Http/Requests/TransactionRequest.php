<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'cpf' => [
                'size:11'
            ],

            'bank_number' => [
                'required',
                'numeric'
            ],

            'account_number' => [
                'required',
                'numeric'
            ],

            'amount' => [
                'required',
                'integer',
                'min:20',
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required'  => 'O :attribute é obrigatório',
            'numeric'   => 'Favor informar somente números',
            'integer'   => 'Favor informar somente números inteiros',
            'min'       => 'O valor mínimo é 20'
        ];
    }
}
