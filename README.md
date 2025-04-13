# 🚲 Veliko

[![Symfony](https://img.shields.io/badge/Symfony-7.0-000000?logo=symfony&logoColor=white)](https://symfony.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## Overview

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
- **Leaflet.js** (map display)
- **Vélib' API** (real-time data)
- **Mock Vélib API** (static dev data)
- **Webpack Encore** (assets management)
- **Node.js / npm** (front-end)

---

## ⚙️ Setup

### 1. Clone

```bash
git clone https://github.com/your-username/veliko.git
cd veliko
```

### 2. Env file

```bash
cp .env.example .env
```

> Edit required variables (API key, DB, etc.)

---

### 3. Docker

```bash
docker compose up -d
```

The provided `compose.yaml` file contains all needed services.

---

### 4. PHP dependencies

```bash
composer install
```

---

### 5. Front-end dependencies

```bash
npm install
```

---

### 6. Load Migrations

```bash
symfony console d:m:m
```

### 7. Start Symfony server

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

## 🧑‍💻 Auteur / Author

Développé par **Gabin** – Student project.

---

## 📄 Licence / License

This project is licensed under the [MIT License](LICENSE).
