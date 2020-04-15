# Cassrolton

![Laravel](https://github.com/Anthony-Jhoiro/projet-cours-laravel/workflows/Laravel/badge.svg)

## Mise en place

### Installation


```shell script
# Installer les dépendances php
composer install
# Installer les dépendances javascript
npm install
# Compilations des assets javascript
npm run dev
# Générer une clé de cryptage
php artisan key:generate #après avoir créer un .env
```

### Mise en place

```shell script
# créer un fichier .env à la racine du projet, copier coller le .env.example et ajouter le nom de la base de données sous cette forme : DB_DATABASE=nomBdd (le DB_DATABASE existe déjà, il faut juste changer la valueur)
# Générer une clé de cryptage après avoir créer le .env :
php artisan key:generate
```

### Serveur de développement
```shell script
php artisan serve
npm run watch
```
