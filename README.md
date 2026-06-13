# Stock Manager

Application web de gestion de stock développée avec **Laravel 12** et **Bootstrap 5**.  
Elle permet de gérer des produits et des clients avec un tableau de bord synthétique.

---

## Table des matières

1. [Prérequis](#prérequis)
2. [Stack technique](#stack-technique)
3. [Architecture du projet](#architecture-du-projet)
4. [Installation](#installation)
5. [Lancer l'application](#lancer-lapplication)
6. [Compte de test](#compte-de-test)
7. [Fonctionnalités](#fonctionnalités)
8. [Marges d'améliorations](#marges-dameliorations)
9. [Routes disponibles](#routes-disponibles)
10. [Guide de test manuel](#guide-de-test-manuel)
11. [Remettre la base à zéro](#remettre-la-base-%C3%A0-z%C3%A9ro)

---

## Prérequis

| Outil | Version utilisée |
|---|---|
| PHP | 8.2.12 |
| Composer | 2.8.10 |
| Node.js | 18+ |
| NPM | 9+ |
| MySQL| 8.0+ |

---

## Stack technique

- **Backend** : Laravel 12
- **PHP** : 8.2.12
- **Composer** : 2.8.10
- **Authentification** : Laravel Breeze
- **Frontend** : Bootstrap 5.3 + Bootstrap Icons
- **Base de données** : MySQL (SQLite supporté pour les tests rapides)
- **Templating** : Blade

---

## Architecture du projet

```
stock-manager/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                        # Contrôleurs Breeze (login, register…)
│   │   │   ├── ClientController.php         # CRUD clients
│   │   │   ├── DashboardController.php      # Statistiques du tableau de bord
│   │   │   ├── ProductController.php        # CRUD produits
│   │   │   ├── ProfileController.php        # Profil utilisateur
│   │   │   └── Controller.php               # Classe de base
│   │   └── Middleware/                      # Middleware applicatifs
│   └── Models/
│       ├── Client.php
│       ├── Product.php
│       └── User.php
│
├── database/
│   ├── factories/
│   │   ├── ClientFactory.php                # Générateur de faux clients
│   │   ├── ProductFactory.php               # Générateur de faux produits
│   │   └── UserFactory.php
│   ├── migrations/
│   │   ├── 2026_06_13_182119_create_products_table.php
│   │   ├── 2026_06_13_184547_create_clients_table.php
│   │   └── ... autres migrations
│   └── seeders/
│       ├── ClientSeeder.php
│       ├── DatabaseSeeder.php               # Point d'entrée des seeders
│       ├── ProductSeeder.php
│       └── UserSeeder.php                   # Compte admin de test
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── auth/                            # Vues Breeze (login, register…)
│       ├── clients/
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── index.blade.php
│       ├── components/                      # Composants réutilisables
│       ├── dashboard.blade.php              # Tableau de bord
│       ├── layouts/
│       │   └── app.blade.php                # Layout principal Bootstrap
│       └── products/
│           ├── create.blade.php             # Formulaire création
│           ├── edit.blade.php               # Formulaire édition
│           └── index.blade.php              # Liste paginée
│
└── routes/
    ├── auth.php                             # Routes Breeze
    └── web.php                              # Routes principales
```

---

## Installation

### 1. Cloner le projet

```bash
git clone https://github.com/Narisolo-gif/stock-manager-test.git
cd stock-manager-test
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JS

```bash
npm install
npm run build
```

### 4. Configurer l'environnement

```bash
cp .env.example .env ou copy .env.example .env (commande windows)
php artisan key:generate
```

Ouvre le fichier `.env` et configure ta base de données :

```env
# MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stock-manager
DB_USERNAME=root
DB_PASSWORD=

```


### 5. Créer la base de données (MySQL uniquement)

```sql
CREATE DATABASE `stock-manager` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Migrer et injecter les données de test

```bash
php artisan migrate --seed
```

Cette commande crée toutes les tables et insère automatiquement :

| Données | Quantité |
|---|---|
| Compte admin | 1 |
| Produits (stock normal) | 20 |
| Produits (stock faible ≤ 5) | 4 |
| Produits (rupture de stock) | 3 |
| Clients | 15 |

---

## Lancer l'application

```bash
php artisan serve
```

L'application est accessible sur : **http://127.0.0.1:8000**

---

## Compte de test

| Champ | Valeur |
|---|---|
| **Email** | `admin@stock.com` |
| **Mot de passe** | `password` |

---

## Fonctionnalités

### Tableau de bord
- Nombre total de produits
- Nombre total de clients
- Nombre de produits en stock faible (quantité ≤ 5) avec alerte visuelle
- Accès rapides vers les actions principales

### Produits
- Lister avec pagination (10 par page)
- Badges de stock colorés (vert / orange / rouge)
- Créer avec validation complète
- Modifier
- Supprimer avec confirmation

### Clients
- Lister avec pagination
- Créer, modifier, supprimer

### Authentification (Breeze)
- Inscription / Connexion
- Déconnexion
- Modification du profil et du mot de passe
- Redirection automatique : session active → dashboard, sinon → login

---

## Marges d'améliorations
### Bug
- les icones paginations sont trop grandes
- 
### Renforcement de l'accès admin
- Ajouter un système de rôles (`admin`, `user`) et un middleware `role:admin`.
- Restreindre les vues et actions sensibles aux administrateurs uniquement.
- Ajouter des politiques (`Gate` / `Policy`) pour sécuriser l'accès aux ressources produits et clients.
- Journaliser les actions CRUD avec audit trail pour les suppressions et modifications.
- Activer une validation multi-facteur ou une vérification renforcée pour le compte admin.

### Division en sprints par module
- **Sprint 1 : Authentification & dashboard**
  - Mise en place de Breeze, login/logout, profil, accès au dashboard.
  - Tableau de bord et redirections de base.
- **Sprint 2 : Gestion des produits**
  - CRUD produits, validations, listes paginées, affichage des statuts de stock.
  - Recherche et filtres de stock.
- **Sprint 3 : Gestion des clients**
  - CRUD clients, validations, listes clients, recherche.
  - Ajout de champs contacts et adresse.
- **Sprint 4 : Améliorations UX / reporting**
  - Recherche avancée, messages d'erreur, responsive design.
  - Export de données, sauvegarde, tests supplémentaires.

### Autres pistes
- Ajouter une API REST pour produits et clients.
- Ajouter l'import/export CSV et Excel.
- Ajouter des tests automatisés fonctionnels et unitaires.
- Mettre en place un vrai moteur de recherche (Scout / Elasticsearch) pour la recherche textuelle.
- Gérer des permissions plus fines (`CRUD` par rôle, accès module). 

### Test plus approfondie
- re cloner le projet
- suivre le processus d'installation
- retester l'application
---

## Routes disponibles

### Publiques (redirigent vers login si non connecté)

| Méthode | URL | Description |
|---|---|---|
| GET | `/` | Redirige vers dashboard ou login |
| GET | `/login` | Page de connexion |
| GET | `/register` | Page d'inscription |

### Protégées (authentification requise)

| Méthode | URL | Description |
|---|---|---|
| GET | `/dashboard` | Tableau de bord |
| GET | `/products` | Liste des produits |
| GET | `/products/create` | Formulaire création produit |
| POST | `/products` | Enregistrer un produit |
| GET | `/products/{id}/edit` | Formulaire édition produit |
| PUT | `/products/{id}` | Mettre à jour un produit |
| DELETE | `/products/{id}` | Supprimer un produit |
| GET | `/clients` | Liste des clients |
| GET | `/clients/create` | Formulaire création client |
| POST | `/clients` | Enregistrer un client |
| GET | `/clients/{id}/edit` | Formulaire édition client |
| PUT | `/clients/{id}` | Mettre à jour un client |
| DELETE | `/clients/{id}` | Supprimer un client |
| GET | `/profile` | Éditer le profil |
| POST | `/logout` | Se déconnecter |

> Consulter toutes les routes : `php artisan route:list`

---

## Guide de test manuel

### Authentification

| # | Action | Résultat attendu |
|---|---|---|
| 1 | Ouvrir `http://127.0.0.1:8000` sans session | Redirigé vers `/login` |
| 2 | Se connecter avec `admin@stock.com` / `password` | Redirigé vers `/dashboard` |
| 3 | Rouvrir `/` avec session active | Redirigé vers `/dashboard` |
| 4 | Cliquer sur **Se déconnecter** | Redirigé vers `/login` |
| 5 | Tenter d'accéder à `/dashboard` sans session | Redirigé vers `/login` |

### Tableau de bord

| # | Action | Résultat attendu |
|---|---|---|
| 6 | Consulter `/dashboard` | 3 cartes affichent les stats (27 produits, 15 clients, 7 en stock faible/rupture) |
| 7 | Vérifier la carte **Stock faible** | Chiffre en rouge si > 0 |

### Produits

| # | Action | Résultat attendu |
|---|---|---|
| 8 | Aller sur `/products` | Tableau paginé, 10 produits par page |
| 9 | Cliquer **Nouveau produit** | Formulaire vide s'affiche |
| 10 | Soumettre le formulaire vide | Erreurs de validation en rouge sur chaque champ |
| 11 | Saisir un prix négatif (`-5`) | Erreur : "Le prix ne peut pas être négatif" |
| 12 | Créer un produit valide | Redirigé vers la liste avec message de succès vert |
| 13 | Cliquer **Modifier** sur un produit | Formulaire pré-rempli avec les données existantes |
| 14 | Vider le nom et sauvegarder | Erreur de validation, données restaurées |
| 15 | Cliquer **Supprimer** | Confirmation navigateur, puis suppression et message de succès |
| 16 | Créer un produit avec quantité `0` | Badge **Rupture** rouge dans la liste |
| 17 | Créer un produit avec quantité `3` | Badge **3 restants** orange dans la liste |
| 18 | Créer un produit avec quantité `50` | Badge **50 en stock** vert dans la liste |

### Clients

| # | Action | Résultat attendu |
|---|---|---|
| 19 | Aller sur `/clients` | Liste des 15 clients seedés |
| 20 | Créer / modifier / supprimer un client | Même comportement que les produits |

---

## Remettre la base à zéro

Pour réinitialiser complètement la base et réinjecter les données de test :

```bash
php artisan migrate:fresh --seed
```

> ⚠️ Cette commande **supprime toutes les données** et recrée les tables depuis zéro.
> À utiliser uniquement en environnement de développement/test.

---

## Commandes utiles

```bash
# Lancer le serveur de développement
php artisan serve

# Vider tous les caches
php artisan optimize:clear

# Lister toutes les routes
php artisan route:list

# Vérifier l'état des migrations
php artisan migrate:status

# Seed uniquement (sans recréer les tables)
php artisan db:seed
```

