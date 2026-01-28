# Design System & UI - Data Center Management System

**Module développé par** : CHAYMA  
**Rôle** : UI/UX Designer & Frontend Developer  
**Période** : Janvier 2026

## Vue d'ensemble

Ce module constitue l'identité visuelle et l'ossature interactive du système. Mon rôle a été de créer un langage visuel commun pour que l'utilisateur navigue de manière fluide, que ce soit sur les graphiques d'Ouarda ou les formulaires .

## Problématique résolue

Comment harmoniser le travail de 5 développeurs différents pour que l'application ressemble à un produit unique, professionnel et "Premium", tout en garantissant une réactivité parfaite sur mobile ?

## Architecture & Concepts

### Palette Colorimétrique (Identité Visuelle)

J'ai choisi une palette "Elite Business" pour inspirer confiance et technicité :

| Couleur | Code Hex | Usage |
|---------|----------|-------|
| Bleu Nuit | #0f1e3f | Header, Sidebar, Boutons primaires |
| Doré Ocre | #997953 | Hover, bordures actives, icônes |
| Crème | #e2d1b9 | Fonds de cartes, bordures légères |
| Bleu Delft | #213a56 | Footer, textes de titres |

### Principes de l'Interface

| Principe | Implémentation |
|----------|----------------|
| Atomic Design | Création de composants réutilisables (boutons, inputs, modales) |
| Namespace Global | Utilisation de window.App en Vanilla JS pour éviter les conflits |
| Mobile First | Interface entièrement responsive via Flexbox et Media Queries |
| Feedback Immédiat | Système de notifications (Toasts) pour chaque action utilisateur |

## Fonctionnalités principales

### Design System (Blade & CSS)

- Layout Global : Structure Header/Footer unifiée
- Formulaires Stylisés : Design personnalisé pour tous les types d'inputs (Select, Textarea, Password)
- Composants Réutilisables : Alertes, badges de statut (Disponible, Maintenance, etc.)

### Composants JavaScript (Vanilla JS)

- Système de Notifications : Toasts animés avec 4 états (success, error, warning, info)
- Système de Tabs : Navigation par onglets pour les dashboards complexes
- Modales Dynamiques : Fenêtres surgissantes pour les confirmations ou éditions rapides
- Menu Mobile : Navigation optimisée pour les écrans tactiles

### Intégration & Cohérence

- Merge & Polish : Fusion avec le travail d'Ouarda (Ressources) pour habiller ses tableaux
- Harmonisation : Standardisation des espacements (Paddings/Margins) sur toutes les vues

## Interfaces développées

### Fichiers Maîtres

```
public/
├── css/
│   ├── admin.css         → Variables, resets et styles globaux
│   ├── app.css  → Styles des boutons, cartes, modales
|   ├── notifications.css
|   ├── reservations.css
|   ├── resources.css
|   └── statistics.css 
|
└── js/
    ├── app.js          → Cœur de l'interactivité (App.utils, App.components)
    ├── calendar.js
    ├── charts.js
    ├── notifications.js
    ├── reservations.js
    ├── statistics.js
    └── tech-reservations.js

resources/views/
├── layouts/
│   ├── admin.blade.php   → Structure parente (Master Layout)
|   ├── app.blade.php
|   └── guest.blade.php
|
└── components/
    ├── alert.blade.php
    ├── badge.blade.php
    ├── breadcrumbs.blade.php
    ├── button.blade.php
    ├── card.blade.php
    ├── footer.blade.php
    ├── form-input.blade.php
    ├── form-select.blade.php
    ├── form-textarea.blade.php
    └── navigation.blade.php
```

### Structure du code (Côté Frontend)

```

public/js/
└── app.js             (Namespace App.components & App.utils)
```

## Expérience Utilisateur & Sécurité

### Accessibilité & UX

- Responsive Design : Adaptation des tableaux complexes en listes lisibles sur mobile
- Protection Frontend : Validation JavaScript des formulaires avant l'envoi au backend

## Compétences développées

### Techniques

- CSS Moderne : Variables CSS, Flexbox, Grid, Animations keyframes
- Vanilla JavaScript : Programmation orientée objet pour les composants UI
- Git Avancé : Gestion des conflits lors des fusions (Merges) avec le backend

### Transversales

- Direction Artistique : Création d'une charte graphique cohérente
- Coordination : Travail en amont pour fournir des composants exploitables par Fatima, FatimaZahrae, Ouarda et Halima
- Agilité : Adaptation rapide du design suite aux retours de l'équipe


# Vérifier la cohérence visuelle sur les pages backend
php artisan serve
```
# Workflow de collaboration

1. CHAYMAE crée les composants de base
   └─▶ 2. Partage via Git (branch: design-system)
        └─▶ 3. Équipe intègre dans leurs modules
             └─▶ 4. CHAYMAE harmonise lors des merges
                  └─▶ 5. Validation finale & polish

## Contact & Support

📞 Contact & Support
Développeuse : CHAYMA
Email : chayma.oualili26@gmail.com
GitHub : chaymaoualili-dotcom
LinkedIn : [chayma oualili](https://www.linkedin.com/in/chayma-oualili-87b44339b/)
---

## 📄 Licence

Ce projet est développé dans le cadre d'un projet académique.  
© 2026 Data Center Management Team

*✨ Interface sublimée par CHAYMA ✨*

*"Le design n'est pas seulement ce qu'on voit, c'est comment on l'utilise"*