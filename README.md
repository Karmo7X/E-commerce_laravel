<h1 align="center">🛍️ Laravel E-commerce API</h1>

<p align="center">
A clean, modular, and modern <strong>RESTful E-commerce API</strong> built with <code>Laravel</code> & <code>JWT Authentication</code>. Perfect foundation for building your next full-stack online store.
</p>

---

## 📌 Overview

Welcome to the backend of your future online store! This Laravel-powered API gives you everything you need to manage:

- 🧑 User Authentication (with JWT)
- 🏷️ Product & Category CRUD
- 🛍️ Brand Management
- 📦 Order Placement
- 🌍 Location-based filtering (Regions, Cities, Districts)

---

## 🚀 Quick Start

```bash
# 1. Clone the repo
git clone https://github.com/Karmo7X/E-commerce_laravel.git
cd E-commerce_laravel

# 2. Install dependencies
composer install

# 3. Configure environment
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# 4. Setup your database
php artisan migrate

# 5. Run the server
php artisan serve
