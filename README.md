# 🛒 Xero Office - Advanced E-Commerce Platform

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white)

A modern, full-featured E-commerce platform built from scratch to provide a seamless shopping experience for customers and a powerful, data-driven management system for administrators. The project includes a highly interactive UI with comprehensive business logic handling orders, inventory, and analytics.

---

## ✨ Comprehensive Feature List

### 👨‍💼 1. Advanced Admin Dashboard (SaaS-Inspired UI)
* **Real-Time Analytics Engine:** Dynamic line charts (powered by Chart.js) visualizing sales data. Includes a custom-built time filter (Today, This Week, This Month, This Year) that dynamically recalculates all dashboard KPIs and updates the chart via the backend controller.
* **Smart Inventory Management:** 
  * Interactive Notification Bell in the header with a bouncing badge for low-stock alerts.
  * Hoverable dropdown menu showing the top 5 depleted products.
  * Dedicated "Low Stock" management page for restocking decisions.
* **Order Processing & Tracking:** Update order statuses (Pending, Processing, Shipped, Delivered) with visual color-coded badges.
* **Data Export:** One-click Excel export for all orders using `Laravel-Excel`.
* **Top Sellers & Recent Activity:** Real-time tracking of best-selling products and recent customer orders.
* **Full CRUD Operations:** Manage Products, Categories, Orders, and Customers easily.

### 🛍️ 2. Customer Storefront
* **Product Catalog:** Browse products seamlessly with a clean, responsive layout.
* **Shopping Cart & Checkout:** Smooth end-to-end checkout process recording order details and related product pivot data.
* **Interactive Reviews & Ratings:** 
  * Customers can leave 1-5 star ratings using a custom-built interactive CSS star UI.
  * Display of previous customer reviews with calculation of total reviews per product.
* **Automated Email Notifications:** Professionally designed HTML/CSS email templates sent automatically to customers upon order status changes (e.g., "Order Shipped" alerts with dynamic customer names and order totals).

### 🎨 3. UI/UX & Frontend Excellence
* **Native Dark/Light Mode:** Full system integration. The UI seamlessly transitions between themes without refreshing, including complex components like data tables, charts, and dropdowns.
* **RTL Support:** Fully optimized for Arabic language layout (Right-to-Left) ensuring perfect typography and alignment using `Tajawal` font.
* **Premium Micro-interactions:** Glassmorphism effects (backdrop-blur), smooth hover transitions, pulse animations for alerts, and custom scrollbars.

---

## 🛠️ Tech Stack & Architecture

* **Backend:** Laravel 11.x, PHP 8.x
* **Frontend:** Blade Templates, Tailwind CSS (Utility-first framework), JavaScript (ES6)
* **Database:** MySQL with Eloquent ORM & Pivot tables
* **Packages/Tools:** 
  * `maatwebsite/excel` (For spreadsheet exports)
  * `Chart.js` (For data visualization)
* **Architecture:** MVC (Model-View-Controller), Service-oriented logic for dashboard metrics, Mailables for SMTP email handling.

---

Follow these steps to run the project locally on your machine:

**Clone the repository & Setup:**
```bash
git clone [https://github.com/omararafa295-cmd/xero-office-ecommerce.git](https://github.com/omararafa295-cmd/xero-office-ecommerce.git)
cd xero-office-ecommerce

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve

   Visit http://localhost:8000 in your browser.
