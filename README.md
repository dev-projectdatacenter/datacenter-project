#  Application de Gestion de Data Center

![Laravel](https://img.shields.io/badge/Laravel-10-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![MySQL](https://img.shields.io/badge/MySQL-8-orange)
![License](https://img.shields.io/badge/License-Educational-green)

Application web développée avec Laravel/PHP et MySQL permettant de gérer la réservation, l'allocation et le suivi des ressources informatiques d'un Data Center (serveurs, machines virtuelles, baies de stockage, équipements réseau).

Cette application assure une gestion efficace et transparente des ressources à travers quatre profils utilisateurs avec des rôles et permissions différenciés.

---

##  Équipe de Développement

| Membre | Rôle | Responsabilités |
|--------|------|----------------|
| **FATIMA** | Coordinatrice + BDD | Base de données, Modèles Eloquent, Dashboards, Tests |
| **Fatima ZAHRAE** | Authentification | Auth, Sécurité, Rôles, Gestion utilisateurs |
| **OUARDA** | Ressources | CRUD ressources, Statistiques, Filtres |
| **HALIMA** | Réservations | Système de réservation, Notifications, CRON |
| **CHAYMAE** | Design System | Interface UI/UX, Composants, CSS/JS personnalisés |

---

##  Technologies Utilisées

### Backend
- **Framework :** Laravel 10
- **Langage :** PHP 8.2
- **Base de données :** MySQL 8
- **ORM :** Eloquent

### Frontend
- **CSS personnalisé** (Sans Bootstrap, Tailwind)
- **JavaScript Vanilla** (Sans jQuery)
- **Blade Templates**

### Outils de développement
- Git & GitHub
- Composer
- npm

---

##  Fonctionnalités Principales

###  Système d'Authentification ( Fatima ZAHRAE)
- Connexion / Inscription / Déconnexion
- Réinitialisation du mot de passe
- Gestion de 4 rôles utilisateurs
- Protection des routes par middleware
- Rate limiting (protection brute force)
- Logs d'activité

###  Gestion des Ressources (OUARDA)
- CRUD complet des ressources
- Catégories : Serveurs, VMs, Stockage, Réseau
- Filtres avancés (catégorie, statut, caractéristiques)
- Gestion de la maintenance
- Statistiques d'occupation avec graphiques

###  Système de Réservation (HALIMA)
- Demandes de réservation avec justification
- Validation automatique des disponibilités
- Détection des conflits (overlapping)
- Approbation/Refus par Tech Manager
- Historique complet des réservations
- Tâches CRON (activation/expiration automatique)

### Notifications (HALIMA)
- Notifications temps réel
- Alertes pour : validation, refus, expiration, maintenance
- Système de notifications internes

### Statistiques (OUARDA + FATIMA)
- Taux d'occupation global
- Statistiques par catégorie
- Réservations par département
- Graphiques interactifs

###  Interface Utilisateur (CHAYMAE)
- Design responsive (mobile + desktop)
- Composants Blade réutilisables
- CSS personnalisé
- Animations et interactions fluides

---

## 👤 Profils Utilisateurs

### 1. Invité
- Consultation des ressources en lecture seule
- Demande d'ouverture de compte
- Consultation des règles d'utilisation

### 2. Utilisateur Interne
- Recherche de ressources avec filtres
- Demande de réservation
- Suivi de ses demandes (En attente / Approuvée / Refusée)
- Historique personnel
- Notifications

### 3. Tech Manager
- Gestion des ressources supervisées
- Validation/Refus des demandes
- Mise en maintenance des ressources
- Consultation des demandes liées à ses ressources

### 4. Administrateur
- Gestion complète des utilisateurs et rôles
- Gestion du catalogue complet
- Consultation des statistiques globales
- Planification des maintenances
- Activation/Désactivation utilisateurs et ressources

---

## 🗄️ Structure de la Base de Données

### Tables Principales (FATIMA)
- `users` - Utilisateurs du système
- `account_requests` - Demandes de compte
- `resources` - Ressources du Data Center
- `categories` - Catégories de ressources
- `reservations` - Réservations
- `notifications` - Notifications
- `activity_logs` - Journalisation
- `maintenances` - Maintenances planifiées

---

##  Installation

### Prérequis
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & npm

### Étapes d'installation

1. **Cloner le repository**
```bash
git clone https://github.com/dev-projectdatacenter/datacenter-project.git
cd datacenter-project
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances JavaScript**
```bash
npm install
```

4. **Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurer la base de données**
Éditez le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

6. **Créer la base de données**
```bash
mysql -u root -p
CREATE DATABASE laravel;
exit;
```

7. **Exécuter les migrations**
```bash
php artisan migrate
```

8. **Peupler la base avec des données de test**
```bash
php artisan db:seed
```

9. **Lancer le serveur de développement**
```bash
php artisan serve
```

10. **Accéder à l'application**
Ouvrez votre navigateur : `http://localhost:8000` 

---

##  Comptes de Test

Après avoir exécuté les seeders, utilisez ces comptes :

### Administrateur
- **Email :** Chayma@gmail.ma
- **Mot de passe :** password

### Tech Manager
- **Email :** tech.manager@datacenter.com
- **Mot de passe :** password

### Utilisateur
- **Email :** fatimaZahrae@gmail.ma
- **Mot de passe :** password

---

## Structure du Projet
```
datacenter-project/
├── app/
│   ├── Console/Commands/          # Commandes CRON (HALIMA)
│   ├── Http/Controllers/          # Contrôleurs (TOUS)
│   ├── Http/Middleware/           # Middleware (Fatima ZAHRAE)
│   ├── Models/                    # Modèles Eloquent (FATIMA)
│   ├── Services/                  # Services métier (TOUS)
│   └── Policies/                  # Permissions (Fatima ZAHRAE)
├── database/
│   ├── migrations/                # Migrations (FATIMA)
│   └── seeders/                   # Seeders (FATIMA)
├── resources/
│   └── views/
│       ├── layouts/               # Layouts (CHAYMAE)
│       ├── components/            # Composants (CHAYMAE)
│       ├── auth/                  # Vues auth (Fatima ZAHRAE)
│       ├── admin/                 # Vues admin (Fatima ZAHRAE)
│       ├── resources/             # Vues ressources (OUARDA)
│       ├── reservations/          # Vues réservations (HALIMA)
│       └── dashboard/             # Dashboards (FATIMA)
├── public/
│   ├── css/                       # CSS personnalisés (CHAYMAE + OUARDA)
│   └── js/                        # JavaScript (CHAYMAE + HALIMA + OUARDA)
├── routes/
│   └── web.php                    # Routes (TOUS)
└── docs/                          # Documentation individuelle
    ├── fatima/
    ├── Fatima zahrae/
    ├── ouarda/
    ├── halima/
    └── chaymae/
```

---

##  Sécurité

- Authentification Laravel avec middleware
-  Protection CSRF sur tous les formulaires
-  Protection XSS
-  Rate Limiting sur les tentatives de connexion
-  Gestion des rôles et permissions
-  Journalisation des actions importantes
-  Validation des données côté serveur

---

##  Documentation

La documentation détaillée de chaque module se trouve dans le dossier `/docs` :

- [Documentation Base de Données](docs/fatima/rapport-fatima.md)
- [Documentation Authentification](docs/zahrae/Rapport-FatimaZahrae.md)
- [Documentation Ressources](docs/ouarda/rapport-ouarda.md)
- [Documentation Réservations](docs/halima/rapport-halima.md)
- [Documentation Design System](docs/chaymae/rapport-chaymae.md)
le rapport globale se trouve dans `/docs/RapportFinale`

---

##  Démonstration

Scénario de démonstration disponible dans : `video.mp4`

---

##  Contact

Pour toute question ou suggestion concernant ce projet :

- **Repository :** https://github.com/dev-projectdatacenter/datacenter-project
- **Issues :** https://github.com/dev-projectdatacenter/datacenter-project/issues

---

##  Licence

Ce projet a été développé dans un cadre académique.

---

##  Remerciements

Merci à toute l'équipe pour sa collaboration et son engagement dans ce projet :
- FATIMA - Coordinatrice et architecte BDD
- Fatima ZAHRAE - Experte en sécurité
- OUARDA - Spécialiste ressources et statistiques
- HALIMA - Architecte du système de réservation
- CHAYMAE - Designer UI/UX

---

**Développé avec coeur par l'équipe Data Center Management**

**Date :28 Janvier 2026

**Version :** 1.0
