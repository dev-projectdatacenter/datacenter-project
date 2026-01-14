<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:account_requests,email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role_requested' => 'required|in:USER,TECH_MANAGER,INVITE',
            'message' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'phone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères.',
            'role_requested.required' => 'Le type de compte est obligatoire.',
            'role_requested.in' => 'Le type de compte sélectionné n\'est pas valide.',
            'message.max' => 'Le message ne doit pas dépasser 1000 caractères.',
        ];
    }
}
