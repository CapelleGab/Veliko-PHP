# 🚲 Veliko

[![Symfony](https://img.shields.io/badge/Symfony-7.0-000000?logo=symfony&logoColor=white)](https://symfony.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

**🇫🇷 Français | 🇬🇧 English**

---

## 🇫🇷 Présentation

**Veliko** est une application web développée avec **Symfony 7**, permettant de consulter en temps réel les informations des stations de vélos en libre-service (type Vélib’).

### Fonctionnalités :

- Nombre maximal de vélos qu'une station peut accueillir.
- Nombre de vélos **mécaniques** disponibles.
- Nombre de vélos **électriques** disponibles.
- Ajouter des **stations en favoris** pour un accès rapide.
- Affichage **interactif sur une carte** grâce à Leaflet.js.

---

## 🇬🇧 Overview

**Veliko** is a web application built with **Symfony 7** to view real-time information about bike-sharing stations (like Vélib’).

### Features:

- Maximum capacity of bikes per station.
- Number of available **mechanical** bikes.
- Number of available **electric** bikes.
- Ability to **add favorite stations** for quick access.
- Interactive **map display** using Leaflet.js.

---

## 🧰 Tech Stack / Stack technique

- **Symfony 7**
- **Leaflet.js** (map display / affichage de carte)
- **Vélib' API** (real-time data / données en temps réel)
- **Mock Vélib API** (static dev data / données de test)
- **Webpack Encore** (assets management)
- **Node.js / npm** (front-end)

---

## ⚙️ Setup / Installation

### 1. Clone / Cloner le projet

```bash
git clone https://github.com/your-username/veliko.git
cd veliko
```

### 2. Env file / Fichier `.env`

```bash
cp .env.example .env
```

> 🇫🇷 Modifiez les variables nécessaires (clé API, DB, etc.)  
> 🇬🇧 Edit required variables (API key, DB, etc.)

---

### 3. Docker

```bash
docker compose up -d
```

Un fichier `compose.yaml` est fourni avec tous les services nécessaires.  
The provided `compose.yaml` file contains all needed services.

---

### 4. PHP dependencies / Dépendances PHP

```bash
composer install
```

---

### 5. Front-end dependencies / Dépendances front-end

```bash
npm install
```

---

### 6. Load Migrations

```bash
symfony console d:m:m
```

### 7. Start Symfony server / Lancer le serveur

```bash
symfony serve
```

---

### 8. Assets build (Webpack Encore)

- Dev:

```bash
npm run watch
```

- Production:

```bash
npm run build
```

---

## 📌 Favoris / Favorites

- 🇫🇷 Les favoris sont enregistrés en local (localStorage).
- 🇬🇧 Favorites are saved locally (localStorage).

👉 Une gestion serveur peut être envisagée par la suite.  
👉 Server-side storage may be implemented later.

---

## 🧑‍💻 Auteur / Author

Développé par **Gabin** – Projet étudiant / Student project.

---

## 📄 Licence / License

Ce projet est sous licence [MIT](LICENSE).  
This project is licensed under the [MIT License](LICENSE).
