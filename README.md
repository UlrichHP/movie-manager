# Projet : Création d'un système de gestion de films

**Description :** Le candidat devra créer une API pour un système de gestion de films en utilisant le framework Laravel. Ce système doit permettre de gérer des films, des genres de films, des acteurs et d'autres détails associés.

**Fonctionnalités requises :**

- **Gestion des films :**
  - Permettre l'ajout, la modification, la suppression et la consultation de détails sur les films, tels que le titre, la description, l'année de sortie, la durée, etc.

- **Genres de films :**
  - Permettre l'ajout, la modification, la suppression et la consultation des genres de films.
  - Associer des genres aux films.

- **Acteurs :**
  - Permettre l'ajout, la modification, la suppression et la consultation des acteurs.
  - Associer des acteurs aux films.

- **Recherche de films :**
  - Permettre la recherche de films par titre, genre ou acteur.

- **Sécurité et droits :**
  - Utiliser une authentification pour permettre l’accès à l’api.
  - Limiter aux administrateurs ou au créateur le droit de modifier et de supprimer des films, des genres et des acteurs.

- **Pagination :**
  - Paginer la liste des films pour une meilleure gestion des résultats.

## Installation

1. Clone the repository: `git clone https://github.com/UlrichHP/movie-manager.git`

2. Navigate to the project directory: `cd movie-manager`

3. Install dependencies using Composer: `composer install`

4. Create a copy of the `.env.example` file and rename it to `.env`. Update the necessary configuration variables such as database credentials.

5. Generate an application key: `php artisan key:generate`

6. Run database migrations: `php artisan migrate`

7. Start the development server: `php artisan serve`

8. _Optional:_ Generate Database seed: `php artisan db:seed`
