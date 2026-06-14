# عرب لتأجير السيارات - Car Rental Platform

A bilingual (Arabic/English) car rental platform built with Laravel, Livewire, and Vue 3.

## Features

- **Admin Dashboard** — Manage fleet, bookings, licenses, and control center with Livewire
- **Vue SPA** — Public pages (home, cars listing, car details, booking, about, contact)
- **Fleet Map** — Interactive Leaflet map with 10 Yemeni city markers on the dashboard
- **Multi-Image Gallery** — Upload and display multiple images per car
- **Dark Mode** — Full theme toggle with persistent preference
- **Offline Fonts** — Cairo (Arabic), Inter (Latin), Material Symbols served locally
- **API** — RESTful endpoints for cars, bookings, and authentication

## Requirements

- PHP 8.1+
- Composer 2.x
- Node.js 18+
- NPM 9+
- MySQL / MariaDB

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/albabuskits/car-rental-website.git
   cd car-rental-website
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Then edit `.env` to set your database credentials and app URL.

5. **Run database migrations**
   ```bash
   php artisan migrate
   ```

6. **Create storage symlink**
   ```bash
   php artisan storage:link
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

## Running the project

Start the Laravel development server:

```bash
php artisan serve
```

For development with Vite hot-reloading:

```bash
npm run dev
```

## Key Commands

| Command | Description |
|---|---|
| `npm run build` | Build production assets |
| `npm run dev` | Start Vite dev server with HMR |
| `php artisan migrate` | Run database migrations |
| `php artisan storage:link` | Create public/storage symlink |
| `php artisan view:clear` | Clear cached Blade views |
| `php artisan optimize:clear` | Clear all cached files |

## Project Structure

```
app/
├── Http/Controllers/Api/   # REST API controllers
├── Livewire/               # Livewire admin components
└── Models/                  # Eloquent models
resources/
├── js/
│   ├── components/         # Vue components (AppHeader, AppFooter)
│   ├── views/              # Vue page components
│   ├── router/             # Vue Router config
│   └── main.js             # Vue app entry
├── views/
│   ├── layouts/            # Blade layouts (admin, user)
│   └── livewire/           # Livewire Blade views
└── css/
    └── app.css             # Tailwind + custom dark mode styles
routes/
├── api.php                 # API routes
└── web.php                 # Web routes
```

## License

Proprietary — All rights reserved.
