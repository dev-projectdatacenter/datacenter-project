<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email|unique:account_requests,email',
            'phone' => 'nullable|string|max:20',
            'department' => 'required|string|in:engineering,research,teaching,phd,admin',
            'position' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|string|min:8',
            'manager_name' => 'nullable|string|max:255',
            'manager_email' => 'nullable|email|max:255',
            'justification' => 'required|string|max:1000',
            'terms' => 'required|accepted',
            'data_processing' => 'required|accepted',
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
            'department.required' => 'Le département est obligatoire.',
            'department.in' => 'Le département sélectionné n\'est pas valide.',
            'position.required' => 'Le poste est obligatoire.',
            'position.max' => 'Le poste ne doit pas dépasser 255 caractères.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.',
            'password_confirmation.required' => 'La confirmation du mot de passe est obligatoire.',
            'manager_name.max' => 'Le nom du responsable ne doit pas dépasser 255 caractères.',
            'manager_email.email' => 'L\'adresse email du responsable n\'est pas valide.',
            'manager_email.max' => 'L\'adresse email du responsable ne doit pas dépasser 255 caractères.',
            'justification.required' => 'La justification est obligatoire.',
            'justification.max' => 'La justification ne doit pas dépasser 1000 caractères.',
            'terms.required' => 'Vous devez accepter les conditions.',
            'terms.accepted' => 'Vous devez accepter les conditions.',
            'data_processing.required' => 'Vous devez accepter le traitement des données.',
            'data_processing.accepted' => 'Vous devez accepter le traitement des données.',
        ];
    }
}
