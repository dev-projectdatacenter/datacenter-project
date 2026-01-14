# 🎨 Design System - DataCenter Project

Ce projet utilise une architecture **CSS pure (Sans Framework)**.
Merci de ne pas ajouter Bootstrap ou Tailwind.

## 🛠 Guide d'utilisation des composants

Pour garder une cohérence visuelle, n'écrivez pas de HTML brut. Utilisez les composants Blade :

### 1. Boutons
```html
<x-button>Valider</x-button>
<x-button class="btn-danger">Supprimer</x-button>
<x-button class="btn-outline">Annuler</x-button>

### 2. Formulaires
Plus besoin de gérer les labels ou les erreurs, tout est automatique :

HTML

<x-form-input name="email" label="Email" type="email" required />

<x-form-input name="password" label="Mot de passe" type="password" />

<x-form-select name="role" label="Rôle" :options="$roles" />

<x-form-textarea name="description" label="Détails" />

### 3. Conteneurs & Feedback
HTML

<x-card>
    Votre contenu...
</x-card>

<x-alert type="success">Opération réussie</x-alert>
<x-alert type="error">Erreur survenue</x-alert>

### 📐 Layouts disponibles
Public/Auth : @extends('layouts.guest')

Utilisateur connecté : @extends('layouts.app')

Administrateur : @extends('layouts.admin')