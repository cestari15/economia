<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEventoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Altere para true se qualquer usuário logado pode criar
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'reminder_days_before' => 'nullable|integer|min:0',
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
        return [
            'title.required' => 'O título do evento é obrigatório.',
            'start.required' => 'A data do evento é obrigatória.',
        ];
    }
}
