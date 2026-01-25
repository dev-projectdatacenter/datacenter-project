<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Tout utilisateur authentifié peut faire une demande
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'justification' => 'required|string|max:1000',
        ];
    }

    /**
     * Messages d'erreur personnalisés pour une meilleure expérience utilisateur.
     */
    public function messages(): array
    {
        return [
            'resource_id.required' => 'Veuillez sélectionner une ressource à réserver.',
            'start_date.after' => 'La date de début doit être dans le futur.',
            'end_date.after' => 'La date de fin doit être postérieure à la date de début.',
            'justification.required' => 'La justification est obligatoire pour traiter votre demande.',
        ];
    }
}
