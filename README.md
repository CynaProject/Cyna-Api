# Cyna-Api

Cyna-Api est l'API du projet **Cyna**, développée avec **PHP 8** et le framework **Symfony**.  
Elle sert de backend à l'application Cyna et fournit une interface RESTful conforme, construite avec **API Platform**.

## Technologies utilisées

- PHP 8
- Symfony
- API Platform
- Doctrine ORM
- MariaDb
- Authentification JWT

## Structure du projet

- `src/Entity` – Entités représentant les modèles de données
- `src/Controller` – Contrôleurs personnalisés (si nécessaire)
- `config/` – Configuration du projet Symfony
- `public/` – Point d'entrée principal de l’API
- `migrations/` – Migrations de la base de données
- `public/images/` – Répertoire contenant les images du projet

## Installation

1. Cloner le dépôt :
   ```bash
   git clone git@github.com:CynaProject/Cyna-Api.git
   cd cyna-api
   ```

2. Installer les dépendances :
  ```bash
  composer install
  ```

4. Créer la base de données et exécuter les migrations :
  ```bash
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
  ```



