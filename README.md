# Mini application de gestion des rendez-vous

Mini application web développée dans le cadre d'un stage PFA, permettant de gérer les patients, les médecins, les spécialités médicales et les rendez-vous d'un établissement de santé.

## Contexte

Le périmètre de ce projet est volontairement limité afin d'être réalisable dans un délai de 20 jours. L'objectif principal est de démontrer la capacité à comprendre un besoin, modéliser les données, développer des écrans CRUD et appliquer des règles métier de base.

## Technologies utilisées

- **PHP** (architecture MVC)
- **MySQL**
- **PDO** pour l'accès à la base de données
- HTML / CSS (sans framework front-end)

## Fonctionnalités

### Gestion des spécialités
- Ajouter, modifier, supprimer et consulter la liste des spécialités médicales
- Une spécialité associée à au moins un médecin ne peut pas être supprimée

### Gestion des médecins
- Ajouter, modifier, supprimer et consulter la liste des médecins
- Un médecin est rattaché à une seule spécialité
- Un médecin ayant des rendez-vous associés ne peut pas être supprimé

### Gestion des patients
- Ajouter, modifier, supprimer et consulter la liste des patients
- Un patient ayant des rendez-vous associés ne peut pas être supprimé

### Gestion des rendez-vous
- Créer, modifier, annuler et marquer un rendez-vous comme réalisé
- Un rendez-vous nouvellement créé prend automatiquement le statut **Planifié**
- Statuts possibles : `PLANIFIE`, `ANNULE`, `REALISE`
- Un rendez-vous annulé ne peut plus être modifié
- Un médecin ne peut pas avoir deux rendez-vous à la même date et à la même heure
- Filtrage de la liste des rendez-vous par médecin et par date

## Modélisation

Le diagramme de classes proposé avant le développement est disponible ici :
[docs/Diagramme_classes_gestion_rdv_L1.pdf](docs/Diagramme_classes_gestion_rdv_L1.pdf)

## Structure du projet

stage_gestion_rdv/
├── assets/ # CSS
├── config/ # Connexion à la base de données
├── controllers/ # Contrôleurs (logique métier)
├── database/ # Script SQL de création de la base
├── docs/ # Documentation (diagramme de classes)
├── models/ # Modèles (accès aux données)
├── views/ # Vues (affichage)
├── .env.example # Exemple de configuration
└── index.php # Page d'accueil


## Installation

### Prérequis
- [WampServer](https://www.wampserver.com/) (ou XAMPP / équivalent) avec PHP 8+ et MySQL
- Un navigateur web

### Étapes

1. **Cloner le dépôt** dans le dossier `www` de WampServer :
git clone https://github.com/votre-utilisateur/stage-gestion-rdv.git

2. **Créer la base de données** dans phpMyAdmin, nommée `gestion_rdv`

3. **Importer la structure** : dans phpMyAdmin, onglet Importer, sélectionner le fichier `database/gestion_rdv.sql`

4. **Configurer la connexion** : créer un fichier `.env` à la racine du projet avec le contenu suivant (à adapter selon votre configuration) :
DB_HOST=localhost
DB_NAME=gestion_rdv
DB_USER= votre_user_name
DB_PASS= votre_pass_word

5. **Démarrer WampServer** et accéder à l'application via :

http://localhost/stage_gestion_rdv/


## Auteur

Zineb — Stage PFA, Licence Sciences du Logiciel, Université Mohammed V de Rabat