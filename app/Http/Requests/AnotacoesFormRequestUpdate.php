<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AnotacoesFormRequestUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|max:101|min:5',
            'categoria' => 'required|max:100|min:2',
            'valor' => 'required|decimal:10,2',
            'data' => 'required|date',

        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => $validator->errors()
        ]));
    }
    public function messages()
    {
        return  [
            'nome.max' => 'O campo nome não pode ter mais de 100 caracteres.',
            'nome.min' => 'O campo nome deve ter no mínimo 5 caracteres.',
            'categoria.max' => 'O campo categoria não pode ter mais de 100 caracteres.',
            'categoria.min' => 'O campo categoria deve ter no mínimo 2 caracteres.',
            'data.date' => 'formáto de data inválido',
            'valor.decimal' => 'Este campo recebe apenas numeros decimais',
        ];
    }
}
