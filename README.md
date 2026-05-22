# 🛒 Vegmart — Laravel 12 E-Grocery (Ecommerce) — Frontend + backend + Admin Panel

![Laravel](https://img.shields.io/badge/Laravel-12-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php)
![Status](https://img.shields.io/badge/Status-Active-brightgreen?style=for-the-badge)

> **Note:** This is a Laravel 12 based ecommerce project (frontend + backend + admin panel). The repository already contains a 

---

## 📚 Table of Contents
- [About](#about)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Admin Login Instructions](#admin-login-instructions)
- [Quickstart — Run Locally](#quickstart--run-locally)
- [Project Structure](#project-structure)
- [Assets, Uploads & Storage](#assets--uploads)
- [Deployment Notes](#deployment-notes)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [Contact](#contact)

---

## About
**Vegmart**  is an e-grocery web application built with **Laravel 12**. It allows selling groceries — fruits, vegetables, meat, bread, milk, etc. — and includes an **admin control panel** (accessible via authentication) to manage categories, subcategories and products.

---

## Features

**🛒 Storefront (User Side)**
- Browse & search products
- Category-based shopping
- Responsive UI
- Product detail pages
- User login & registration
- Profile page

**🛠️ Admin Panel**
- Secure Admin Authentication
- Category & Sub-category Management
- Product Management (Add/Edit/Delete)
- Admin Dashboard Overview

> **🔐 Admin role must be manually assigned in database (instructions below)**

---

## Tech Stack
- **Backend**: **Laravel 12** (PHP)
- **DB**: MySQL (configurable in `.env`)
- **Frontend**: Blade templates, CSS, JS (mix / Vite depending on project setup)
- **Integrations:** Laravel Socialite (Google Login), Payment Gateway API
- **Dev Tools**: Composer, NPM, Git

---
## Admin Login Instructions

1. Register a new user on the website
2. Open your database → users table
3. Find your registered user
4. Change column type from ```Customer``` to ```Admin```
5. Login again — admin panel will be accessible

---

## Quickstart — Run Locally
> **Before you start:** ensure PHP, Composer, Node.js, and a database server are installed.

```bash
# 1. Clone
git clone https://github.com/DhruvBamania/vegmart-laravel-12.git
cd vegemart-laravel-12

# 2. Dependencies
composer install
npm install

# 3. Environment
cp .env.example .env
# Edit .env: set set DB connection details, Google Client ID/Secret, and Payment API keys.

# 4. App key, migrations, storage
php artisan key:generate
php artisan migrate --seed      # --seed optional if seeds exist
php artisan storage:link

# 5. Build assets
npm run dev         # or npm run build for production

# 6. Serve
php artisan serve
# Open: http://127.0.0.1:8000
```
---

## Project Structure

```bash
laravel-ecommerce/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── CartController.php
│   │   │   ├── DiscountController.php
│   │   │   ├── OrderController.php
│   │   │   └── PageController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── address.php
│   │   ├── cart.php
│   │   ├── category.php
│   │   ├── contact.php
│   │   ├── discount.php
│   │   ├── order.php
│   │   ├── order_items.php
│   │   ├── product.php
│   │   └── user.php
│   └── Providers/
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   ├── admin/              # resources for admin panel: css, js, vendor assets
│   ├── theme/              # resources for main website (css/js)
│   ├── uploads/
│   │   ├── products/       # uploaded product images
│   │   └── profile_images/ # uploaded user profile images
│   └── index.php
│
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── layout/
│   │   │   │   └── app.blade.php
│   │   │   ├── partials/
│   │   │   │   ├── footer.blade.php
│   │   │   │   └── navbar.blade.php
│   │   │   ├── adminProfile.blade.php
│   │   │   ├── contact.blade.php
│   │   │   ├── customers.blade.php
│   │   │   ├── discounts.blade.php
│   │   │   ├── index.blade.php
│   │   │   ├── order.blade.php
│   │   │   └── products.blade.php
│   │   ├── emails/
│   │   │   └── order-cancelled.blade.php
│   │   │   └── order-confirmation.blade.php
│   │   │   └── order-status.blade.php
│   │   │   └── otp.blade.php
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── pages/
│   │   │   ├── 404.blade.php
│   │   │   ├── cart.blade.php
│   │   │   ├── checkout.blade.php
│   │   │   ├── contact.blade.php
│   │   │   ├── home.blade.php
│   │   │   ├── login.blade.php
│   │   │   ├── order-details.blade.php
│   │   │   ├── order-success.blade.php
│   │   │   ├── otp-verify.blade.php
│   │   │   ├── profile.blade.php
│   │   │   ├── register.blade.php
│   │   │   ├── shop.blade.php
│   │   │   ├── view-orders.blade.php
│   │   └── partials/
│   │       ├── footer.blade.php
│   │       └── nav.blade.php
│
├── routes/
│   ├── web.php
│   └── api.php
│
├── storage/
├── tests/
├── .env.example
├── composer.json
├── package.json
├── vite.config.js (or webpack.mix.js)
└── README.md

```
---

## Assets & Uploads

- Product and profile images are stored under ```public/uploads/products``` and ```public/uploads/profile_images```.
- For development, include placeholder images in ```public/uploads/``` if desired — avoid committing real user data.
- Run ```php artisan storage:link``` to serve storage files through ```public/storage```.

---

## Screenshots

### Home Page
<img width="1366" height="653" alt="Screenshot (45)" src="https://github.com/user-attachments/assets/ff563720-0f31-48f8-94da-a342555f8ea2" />

### Product Page
<img width="1366" height="649" alt="Screenshot (46)" src="https://github.com/user-attachments/assets/1f06bbad-3056-4541-a39f-3954d3481d6b" />

### Cart Page
<img width="1366" height="645" alt="Screenshot (47)" src="https://github.com/user-attachments/assets/67aba309-1bc1-41cf-87ea-217069fd3ba6" />

### Admin Dashboard
<img width="1366" height="633" alt="Screenshot (48)" src="https://github.com/user-attachments/assets/31d06d7d-3863-4ef3-9ba2-dd245ed8a48e" />


---

## Deployment Notes

- Recommended production options: Laravel Forge, DigitalOcean droplet, or any shared host that supports PHP 8+ and Composer.
- Set up queue, scheduler, and caching as needed for production performance.
- Configure ```.env``` values for production (```APP_ENV=production```, ```APP_DEBUG=false```, DB credentials, mail provider, payment gateway keys).
- Create backups of ```storage``` and database before major updates.

---

## Contributing

1. Fork the repository
2. Create a branch: ```git checkout -b feature/your-feature```
3. Commit your changes: ```git commit -m "Add feature"```
4. Push: ```git push origin feature/your-feature```
5. Create a Pull Request

---

## Contact

**Author: Dhruv Bamania**  
📧 Email: [dhruvbamania02@gmail.com]  
🔗 GitHub: [https://github.com/DhruvBamania]  
💼 LinkedIn: [www.linkedin.com/in/dhruvbamania]  

---

## License

This project is open-sourced software licensed under the MIT license.
