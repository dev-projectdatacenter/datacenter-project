# 🖥️ Module : Gestion des Ressources Data Center
**Développeuse :** OUARDA ✨

---

## 📖 Présentation
Ce module est le cœur opérationnel de l'application. Sa mission est de gérer l'inventaire complet du Data Center (serveurs, stockage, équipements réseau) et de fournir une vision analytique de l'infrastructure.

## ⚙️ Logique Appliquée
L'architecture suit une logique de **gestion de cycle de vie** :
1.  **Inventaire Statutaire :** Chaque ressource possède un état dynamique (`Disponible`, `Occupé`, `Maintenance`, `Hors-service`).
2.  **Modularité :** Séparation stricte entre les ressources et leurs catégories pour une évolutivité maximale.
3.  **Traçabilité :** Liaison directe entre les équipements, les incidents signalés et les maintenances planifiées.
4.  **Analytics :** Transformation des données brutes en indicateurs visuels (CPU, RAM, Taux d'utilisation).

---

## 🛠️ Mes Réalisations

### 🔹 Backend (Le Cerveau)
*   **Controllers :** Gestion intelligente du CRUD (`Resource`, `Category`, `Maintenance`).
*   **Security :** Validation stricte des données via `ResourceRequest`.
*   **Logiciel :** Calcul de performances via `ResourceStatisticsService`.

### 🔹 Frontend (L'Expérience)
*   **Interfaces :** Vues Blade élégantes et responsives pour la gestion quotidienne.
*   **Dashboards :** Visualisation de données avec des graphiques interactifs.
*   **Design :** UI/UX sur mesure avec des styles CSS isolés et modernes.

---

## 🚀 Fonctionnalités Clés
*   ✅ **CRUD Complet :** Création, lecture, mise à jour et suppression sécurisée.
*   📊 **Statistiques Réelles :** Monitoring visuel de l'état du parc.
*   🛠️ **Suivi Maintenance :** Historique détaillé des interventions techniques.
*   ⚠️ **Gestion Incidents :** Système de reporting rapide pour les pannes.

---

### 💻 Stack Technique (Ma Partie)
*   **Langages :** PHP (Laravel), JavaScript, CSS3 vanilla.
*   **Outils :** Blade Engine, Chart.js (pour les stats), FontAwesome.

---

*“Optimiser l’infrastructure pour garantir la performance.”* 💡
