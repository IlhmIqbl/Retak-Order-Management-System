# 👕 Retak Apparel 

A web-based Order Management System (OMS) developed using Laravel to streamline operations for custom clothing businesses.

---

## 📌 Project Overview

This project was developed as part of the **INFO 4302 Web Application Development** course.

The system is designed to help small and medium apparel businesses manage:
- Customer records
- Orders and order items
- Invoice generation
- Sales reporting and analytics

It replaces manual processes such as WhatsApp tracking, spreadsheets, and handwritten notes.

---

## 🚀 Problem Statement

Many small businesses like Retak Apparel face:

- ❌ No centralized system (data scattered)
- ❌ Manual invoice creation (error-prone)
- ❌ No real-time reporting
- ❌ Inefficient order tracking

This system solves these issues through automation and integration.

---

## 🎯 Objectives

- Automate customer and order management
- Generate invoices automatically (PDF)
- Provide dashboard analytics
- Improve workflow efficiency

---

## 🛠️ Tech Stack

- **Framework:** Laravel 10 (PHP)
- **Database:** MySQL
- **Architecture:** MVC (Model-View-Controller)
- **Frontend:** Blade Templates
- **Other Tools:**
  - Eloquent ORM
  - Laravel Authentication
  - PDF Generation

---

## ✨ Features

### 🔐 Authentication
- User login & logout
- Role-based access (Admin / Staff)

### 👥 Customer Management
- Add, update, delete customers
- Search customers
- View customer profile & history

### 📦 Order Management
- Create orders with multiple items
- Assign designers
- Track order status:
  - Pending
  - Processing
  - Completed
  - Cancelled

### 🧾 Invoice System
- Auto-generated invoices
- PDF download & print
- Automatic price calculation

### 📊 Dashboard & Reports
- Total orders
- Completed orders
- Monthly sales
- Business insights

---

## 🖥️ System Screenshots

> (Insert your screenshots inside /screenshots folder)

- Login Page
- Dashboard
- Order Page
- Invoice Page

---

## 📂 Project Documentation

Full report available here:

📄 `docs/Final_Report.pdf`

Includes:
- Problem analysis
- System design (ERD, flow)
- Features & functionality
- Testing & results

---

## ⚙️ Installation Guide

```bash
# Clone repository
git clone https://github.com/yourusername/retak-apparel-oms.git

# Go into project
cd retak-apparel-oms

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env

# Run migrations
php artisan migrate

# Start server
php artisan serve
