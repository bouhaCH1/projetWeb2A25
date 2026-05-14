# WorkWave - Plateforme Freelance & Offres d'Emploi

WorkWave est une application web PHP orientée MVC permettant de connecter des freelances (Job Seekers) et des entreprises (Employers). Elle intègre la gestion de missions, d'événements, d'un portfolio complet et de candidatures, avec des fonctionnalités avancées basées sur l'IA.

## Structure du Projet (MVC)

Le projet suit une architecture Model-View-Controller :

- **`/Controller`** : Contient tous les contrôleurs de l'application (ex: `UserController.php`, `PortfolioController.php`, `missionController.php`). Le fichier `index.php` sert de routeur principal.
- **`/Model`** : Contient les classes pour l'interaction avec la base de données (`Database.php`, `User.php`, etc.).
- **`/View`** : Contient toutes les vues (HTML/PHP). Elles sont divisées par entités (`/missions`, `/portfolio`, `/user`, `/layout`).

## Fonctionnalités Principales

- **Authentification & Rôles** : Gestion sécurisée des sessions avec séparation stricte des rôles (Admin, Employer, Job Seeker).
- **Missions & Candidatures** : Publication de missions par les entreprises, candidatures par les freelances avec statut en temps réel.
- **Portfolio & CV** : Chaque utilisateur peut présenter ses réalisations, diplômes, certifications et compétences.
- **Carte des Talents** : Géolocalisation dynamique pour trouver des entreprises ou des talents à proximité.
- **Événements & Réservations** : Gestion et participation à des événements professionnels.
- **Assistants IA** : Intégration d'outils intelligents pour l'analyse de CV et le coaching d'entretien.

## Installation

1. Cloner le repository dans votre dossier serveur (`htdocs` ou `/var/www/html`).
2. Créer une base de données MySQL nommée `job_platform`.
3. Importer le schéma de la base de données.
4. Assurez-vous que le fichier `Model/Database.php` contient vos accès locaux (root / sans mot de passe par défaut).
5. Lancer l'application via `http://localhost/WorkWave/Controller/index.php`.

## Technologies

- **Backend** : PHP 8+ (PDO, MVC natif)
- **Base de données** : MySQL
- **Frontend** : HTML5, CSS3, JavaScript (Vanilla), Bootstrap 5, FontAwesome
- **Cartographie** : Leaflet.js
- **Graphiques** : Chart.js
