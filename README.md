# 🔗 Mini LinkedIn — API Backend

Plateforme de recrutement développée avec **Laravel 11** et **JWT Auth**.

## 📌 Description

Cette API met en relation des candidats et des recruteurs :
- Un **candidat** peut créer son profil, ajouter ses compétences et postuler à des offres d'emploi.
- Un **recruteur** peut publier des offres et gérer les candidatures reçues.
- Un **administrateur** supervise et modère l'ensemble de la plateforme.

## ⚙️ Prérequis

- PHP 8.3
- Composer
- MySQL via WAMP
- Laravel 11

## 🚀 Installation

### 1. Cloner le projet
```bash
git clone https://github.com/mbarkimahmoud-maker/mini-linkedin
cd mini-linkedin
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Configurer l'environnement
```bash
copy .env.example .env
```

Ouvrez `.env` et modifiez ces lignes :

DB_DATABASE=mini_linkedin
DB_USERNAME=root
DB_PASSWORD=

### 4. Générer les clés
```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Créer la base de données
Créez une base de données nommée `mini_linkedin` dans **phpMyAdmin**.

### 6. Migrations et seeders
```bash
php artisan migrate:fresh --seed
```

### 7. Lancer le serveur
```bash
php artisan serve
```

---

## 👥 Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | admin@linkedin.ma | password |
| Recruteur | recruteur1@linkedin.ma | password |
| Candidat | candidat1@linkedin.ma | password |

---

## 🛣️ Routes de l'API

### 🔓 Authentification
| Méthode | Route | Accès | Description |
|---------|-------|-------|-------------|
| POST | `/api/register` | Public | Inscription |
| POST | `/api/login` | Public | Connexion |
| GET | `/api/me` | Connecté | Infos du compte |
| POST | `/api/logout` | Connecté | Déconnexion |

### 👤 Profil
| Méthode | Route | Accès | Description |
|---------|-------|-------|-------------|
| POST | `/api/profil` | Candidat | Créer son profil |
| GET | `/api/profil` | Candidat | Consulter son profil |
| PUT | `/api/profil` | Candidat | Modifier son profil |
| POST | `/api/profil/competences` | Candidat | Ajouter une compétence |
| DELETE | `/api/profil/competences/{competence}` | Candidat | Retirer une compétence |

### 💼 Offres
| Méthode | Route | Accès | Description |
|---------|-------|-------|-------------|
| GET | `/api/offres` | Connecté | Liste des offres actives |
| GET | `/api/offres/{offre}` | Connecté | Détail d'une offre |
| POST | `/api/offres` | Recruteur | Créer une offre |
| PUT | `/api/offres/{offre}` | Recruteur propriétaire | Modifier une offre |
| DELETE | `/api/offres/{offre}` | Recruteur propriétaire | Supprimer une offre |

### 📨 Candidatures
| Méthode | Route | Accès | Description |
|---------|-------|-------|-------------|
| POST | `/api/offres/{offre}/candidater` | Candidat | Postuler à une offre |
| GET | `/api/mes-candidatures` | Candidat | Ses propres candidatures |
| GET | `/api/offres/{offre}/candidatures` | Recruteur propriétaire | Candidatures reçues |
| PATCH | `/api/candidatures/{candidature}/statut` | Recruteur propriétaire | Changer le statut |

### 🛡️ Administration
| Méthode | Route | Accès | Description |
|---------|-------|-------|-------------|
| GET | `/api/admin/users` | Admin | Liste tous les utilisateurs |
| DELETE | `/api/admin/users/{user}` | Admin | Supprimer un compte |
| PATCH | `/api/admin/offres/{offre}` | Admin | Activer/désactiver une offre |

---

## 📡 Events & Listeners

| Event | Déclencheur | Action |
|-------|-------------|--------|
| `CandidatureDeposee` | Candidat postule à une offre | Log dans `storage/logs/candidatures.log` |
| `StatutCandidatureMis` | Recruteur change le statut | Log dans `storage/logs/candidatures.log` |

---

## 📁 Collection Postman

Disponible dans `postman/mini-linkedin.json` — couvre tous les endpoints et les cas d'erreur (401, 403, 422).

---

## ✍️ Auteurs

Projet réalisé dans le cadre du cours **Technologies Backend** — ENSAM Casablanca
Encadrant : **WARDI Ahmed**
Realise par : Salma Tiouli / Mahmoud M'barki