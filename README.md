# EventSphere 🌎

[Insert Banner Image Here]

**EventSphere** is a comprehensive event management system and admin dashboard tailored for **La Consolacion University Philippines**. It offers a seamless platform for managing campus events, venue bookings, user registrations, and more.

---

## ✨ Features

-   **📅 Event Management**: Simplify event creation and tracking.
-   **🏛️ Venue Booking System**: Manage venue availability and bookings.
-   **👥 Speaker Management**: Assign and organize event speakers.
-   **📊 Real-time Analytics Dashboard**: Visualize event metrics and feedback.
-   **👤 User Registration & Authentication**: Secure and flexible user management.
-   **⭐ Event Feedback System**: Collect and analyze attendee feedback.
-   **📱 Responsive Design**: Optimized for all devices.

[Insert Features Screenshot Grid Here]

---

## 🚀 Tech Stack

EventSphere is powered by the TALL stack and modern DevOps tools:

<div align="center" style="margin-top: 10px;">
<a href="https://laravel.com" target="_blank"><img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
<a href="https://alpinejs.dev" target="_blank"><img src="https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=black" alt="Alpine.js"></a>
<a href="https://tailwindcss.com" target="_blank"><img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"></a>
<a href="https://livewire.laravel.com" target="_blank"><img src="https://img.shields.io/badge/Livewire-4E56A6?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire"></a>
<a href="https://filamentphp.com" target="_blank"><img src="https://img.shields.io/badge/Filament-22292f?style=for-the-badge&logo=filament&logoColor=white" alt="Filament"></a>
<a href="https://frankenphp.dev" target="_blank"><img src="https://img.shields.io/badge/FrankenPHP-6C4AB0?style=for-the-badge&logo=php&logoColor=white" alt="FrankenPHP"></a>
<a href="https://www.docker.com" target="_blank"><img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker"></a>
</div>

---

## 🎯 Core Modules

### 📅 Event Management

-   Create and manage events with ease.
-   Track attendance and handle registrations.
-   Set and monitor event capacity limits.

### 🏛️ Venue Management

-   Book and manage venues.
-   Check real-time availability.
-   View detailed venue information, including images.
-   Track venue usage and capacity.

### 👤 User System

-   Flexible user registration and authentication.
-   Role-based access control (RBAC).
-   Manage user profiles and event history.

---

## 📸 Screenshots

[Insert Grid of Application Screenshots Here]

---

## 🛠️ Installation

### Prerequisites (for local installation)

Ensure you have the following installed:

```bash
- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
```

### Option 1: Local Installation

```bash
# Clone and setup
git clone https://github.com/xhide341/eventsphere.git
cd eventsphere

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env

# Setup database and start server
php artisan migrate:fresh --seed
npm run dev
```

### Option 2: Docker Installation

```bash
# Clone and setup
git clone https://github.com/xhide341/eventsphere.git
cd eventsphere
cp .env.example .env

# Start Docker environment
./vendor/bin/sail up -d

# Install dependencies and setup database
sail composer install
sail npm install
sail artisan migrate:fresh --seed
sail npm run dev
```

> **Note**: Update your `.env` file with appropriate credentials before starting.

---

## 🔗 Additional Resources

-   [Laravel Documentation](https://laravel.com/docs)
-   [Livewire Documentation](https://laravel-livewire.com/docs/installation)
-   [Tailwind CSS Documentation](https://tailwindcss.com/docs)
-   [Filament PHP](https://filamentphp.com/docs)
-   [Docker Documentation](https://www.docker.com/docs)

---

## 🧑‍💻 Author

Developed by:

-   [xhide341](https://github.com/xhide341)
