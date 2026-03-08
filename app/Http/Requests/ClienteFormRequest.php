<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClienteFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|min:5|max:101',

            'email' => 'required|string|email|max:150|unique:clientes,email',

            // size:11 garante exatamente 11 dígitos
            'cpf' => [
                'required',
                'digits:11',
                'unique:clientes,cpf',
                function ($attribute, $value, $fail) {
                    if (!$this->validarCPF($value)) {
                        $fail('O CPF informado é inválido.');
                    }
                }
            ],

            // confirmed exige password_confirmation
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    protected function validarCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) return false;

        // Bloqueia CPF repetido
        if (preg_match('/(\d)\1{10}/', $cpf)) return false;

        // Validação oficial
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) return false;
        }

        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422));
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo 5 caracteres.',
            'nome.max' => 'O nome não pode ultrapassar 101 caracteres.',

            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Informe um email válido.',
            'email.unique' => 'Este email já está cadastrado.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.digits' => 'O CPF deve conter exatamente 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',

            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ];
    }
}