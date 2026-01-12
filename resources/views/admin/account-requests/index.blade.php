@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-space-cadet">Demandes d'inscription</h1>
            <p class="text-muted">Validez ou rejetez les nouvelles demandes d'accès.</p>
        </div>
        <span class="badge badge-warning" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
            <i class="fas fa-clock"></i> 3 En attente
        </span>
    </div>

    <div class="card p-0 overflow-hidden">
        <table class="table w-100">
            <thead class="bg-light border-bottom">
                <tr>
                    <th class="p-3 text-left">Demandeur</th>
                    <th class="p-3 text-left">Département / Labo</th>
                    <th class="p-3 text-left">Motif de la demande</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-right">Décision</th>
                </tr>
            </thead>
            <tbody>
                
                <tr class="border-bottom">
                    <td class="p-3">
                        <div class="font-bold text-space-cadet">Yassine Etudiant</div>
                        <div class="text-xs text-muted">yassine.e@etudiant.ma</div>
                        <div class="text-xs text-primary mt-1">Doctorant</div>
                    </td>
                    <td class="p-3">Génie Informatique</td>
                    <td class="p-3" style="max-width: 300px;">
                        <p class="text-sm text-muted m-0">"Je suis doctorant en 1ère année et j'ai besoin d'accéder au cluster pour mes recherches sur l'IA."</p>
                    </td>
                    <td class="p-3 text-sm text-muted">Aujourd'hui, 09:00</td>
                    <td class="p-3 text-right">
                        <div class="d-flex justify-end gap-2">
                            <button class="btn btn-sm btn-success" title="Accepter"><i class="fas fa-check"></i> Valider</button>
                            <button class="btn btn-sm btn-danger" title="Rejeter"><i class="fas fa-times"></i></button>
                        </div>
                    </td>
                </tr>

                <tr class="border-bottom">
                    <td class="p-3">
                        <div class="font-bold text-space-cadet">Sara Professeur</div>
                        <div class="text-xs text-muted">sara.p@univ.ma</div>
                        <div class="text-xs text-info mt-1">Enseignant</div>
                    </td>
                    <td class="p-3">Mathématiques</td>
                    <td class="p-3" style="max-width: 300px;">
                        <p class="text-sm text-muted m-0">"Supervision des projets de fin d'études."</p>
                    </td>
                    <td class="p-3 text-sm text-muted">Hier, 14:20</td>
                    <td class="p-3 text-right">
                        <div class="d-flex justify-end gap-2">
                            <button class="btn btn-sm btn-success"><i class="fas fa-check"></i> Valider</button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                        </div>
                    </td>
                </tr>

                 <tr class="border-bottom" style="background-color: #fff5f5;">
                    <td class="p-3">
                        <div class="font-bold text-space-cadet">Invité Externe</div>
                        <div class="text-xs text-muted">contact@entreprise.com</div>
                        <div class="text-xs text-warning mt-1">Partenaire</div>
                    </td>
                    <td class="p-3">Partenariat Industriel</td>
                    <td class="p-3" style="max-width: 300px;">
                        <p class="text-sm text-muted m-0">"Accès temporaire pour démo."</p>
                    </td>
                    <td class="p-3 text-sm text-muted">10 Jan 2026</td>
                    <td class="p-3 text-right">
                        <div class="d-flex justify-end gap-2">
                            <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

        </div>

</div>
@endsection