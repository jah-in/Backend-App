# 📚 LibTrack Library Tracking System

A backend REST API built with **Laravel** and **MongoDB** for managing library books, students, and book borrowing and returning transactions.

LibTrack provides secure **admin authentication** and API endpoints for managing library resources. The project follows the **MVC (Model-View-Controller)** architectural pattern and includes interactive API documentation using **Swagger / OpenAPI**.

---

## 📌 Project Overview

The **LibTrack Library Tracking System** is a backend application designed to help manage basic library operations.

The system allows administrators to:

* Manage books
* Manage students
* Borrow books
* Return books
* Monitor active borrowings
* View borrowing records
* Access dashboard information
* Secure API endpoints through authentication

The project uses **MongoDB** as its database and **Laravel Sanctum** for authentication.

---

# ✨ Features

## 🔐 Admin Authentication

The system provides authentication features for administrators.

Available features:

* Admin Registration
* Admin Login
* Admin Logout
* Admin Profile
* Protected API Routes using Laravel Sanctum

---

## 📚 Book Management

Administrators can manage books in the library.

Features include:

* Add a new book
* View all books
* View a single book
* Update book information
* Delete a book

Book information includes:

* Title
* Author
* ISBN
* Category
* Quantity
* Available Quantity
* Description

---

## 🎓 Student Management

Administrators can manage student records.

Features include:

* Add a student
* View all students
* View a single student
* Update student information
* Delete a student

Student information includes:

* Student ID
* Name
* Email
* Course
* Year Level

---

## 📖 Book Borrowing

The system allows administrators to record book borrowing transactions.

When borrowing a book:

1. The system checks if the book exists.
2. The system checks if the student exists.
3. The system checks if the book is available.
4. A borrowing record is created.
5. Student information is automatically retrieved.
6. The available quantity of the book is reduced.

Borrowing information includes:

* Book ID
* Student ID
* Borrower Name
* Borrower ID
* Borrow Date
* Due Date
* Return Date
* Status

---

## 🔄 Book Returning

The system allows administrators to return borrowed books.

When a book is returned:

1. The system checks if the borrowing record exists.
2. The system checks if the book was already returned.
3. The book's available quantity is increased.
4. The borrowing status is updated to `returned`.
5. The return date is recorded.

---

## 📊 Borrowing Management

Administrators can:

* View all borrowing records
* View active borrowings
* View a specific borrowing record
* Return borrowed books

---

## 📈 Dashboard

The system includes an admin dashboard endpoint for retrieving library-related information and statistics.

---

# 🛠️ Technologies Used

| Technology        | Purpose                      |
| ----------------- | ---------------------------- |
| PHP               | Backend Programming Language |
| Laravel           | Backend Framework            |
| MongoDB           | Database                     |
| Laravel Sanctum   | API Authentication           |
| Swagger / OpenAPI | API Documentation            |
| Composer          | PHP Dependency Management    |
| Git               | Version Control              |
| GitHub            | Project Repository           |

---

# 🏗️ Architecture

The project follows the **MVC (Model-View-Controller)** architecture.

```text
Client / Swagger
       │
       ▼
     Routes
       │
       ▼
  Controllers
       │
       ▼
    Models
       │
       ▼
    MongoDB
```

---

# 📂 MVC Structure

## Models

Models handle the application's data and communicate with MongoDB.

Location:

```text
app/Models/
```

Models used:

```text
Book.php
Borrowing.php
Student.php
User.php
PersonalAccessToken.php
```

---

## Controllers

Controllers handle API requests and application logic.

Location:

```text
app/Http/Controllers/
```

Controllers used:

```text
AuthController.php
BookController.php
BorrowingController.php
StudentController.php
DashboardController.php
SwaggerController.php
```

---

## Routes

API routes define the available endpoints of the application.

Location:

```text
routes/api.php
```

---

# 🗄️ Database

The project uses **MongoDB** as its primary database.

Main collections include:

```text
users
books
students
borrowings
```

---

# 🔑 Environment Configuration

The application uses Laravel's `.env` file for environment configuration.

Example configuration:

```env
APP_NAME=LibTrack
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mongodb

MONGODB_URI=mongodb://127.0.0.1:27017
MONGODB_DATABASE=libtrack
```

> ⚠️ The `.env` file should not be uploaded to GitHub because it may contain sensitive configuration information.

Use `.env.example` as a template:

```bash
cp .env.example .env
```

For Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Then update your MongoDB configuration.

---

# 🚀 Installation

## 1. Clone the Repository

```bash
git clone https://github.com/YOUR-USERNAME/libtrack-system.git
```

Move into the project folder:

```bash
cd libtrack-system
```

---

## 2. Install PHP Dependencies

```bash
composer install
```

---

## 3. Create Environment File

Copy the example environment file.

Linux / macOS:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

---

## 4. Generate Application Key

```bash
php artisan key:generate
```

---

## 5. Configure MongoDB

Open the `.env` file and configure MongoDB.

Example:

```env
DB_CONNECTION=mongodb

MONGODB_URI=mongodb://127.0.0.1:27017
MONGODB_DATABASE=libtrack
```

Make sure your MongoDB server is running.

---

## 6. Run the Application

```bash
php artisan serve
```

The application should be available at:

```text
http://127.0.0.1:8000
```

---

# 📖 API Documentation

The project uses **Swagger / OpenAPI** for API documentation.

Generate the Swagger documentation:

```bash
php artisan l5-swagger:generate
```

Open the Swagger documentation:

```text
http://127.0.0.1:8000/docs
```

Swagger allows developers to:

* View available API endpoints
* View request parameters
* View request bodies
* View API responses
* Test API endpoints

---

# 🔐 Authentication

The API uses **Laravel Sanctum** for authentication.

## Register Admin

```text
POST /api/admin/register
```

---

## Login Admin

```text
POST /api/admin/login
```

After logging in, the system provides an authentication token.

Use the token when accessing protected routes.

Example:

```text
Authorization: Bearer YOUR_TOKEN
```

---

## Logout Admin

```text
POST /api/admin/logout
```

---

## Admin Profile

```text
GET /api/admin/profile
```

---

# 📚 API Routes

The project contains more than **20 API routes**.

## 🔐 Authentication Routes

| Method | Endpoint              | Description       |
| ------ | --------------------- | ----------------- |
| POST   | `/api/admin/register` | Register an admin |
| POST   | `/api/admin/login`    | Login admin       |
| POST   | `/api/admin/logout`   | Logout admin      |
| GET    | `/api/admin/profile`  | Get admin profile |

---

# 📚 Book Routes

| Method | Endpoint                | Description   |
| ------ | ----------------------- | ------------- |
| GET    | `/api/admin/books`      | Get all books |
| POST   | `/api/admin/books`      | Add a book    |
| GET    | `/api/admin/books/{id}` | Get a book    |
| PUT    | `/api/admin/books/{id}` | Update a book |
| DELETE | `/api/admin/books/{id}` | Delete a book |

---

# 🎓 Student Routes

| Method | Endpoint                   | Description      |
| ------ | -------------------------- | ---------------- |
| GET    | `/api/admin/students`      | Get all students |
| POST   | `/api/admin/students`      | Add a student    |
| GET    | `/api/admin/students/{id}` | Get a student    |
| PUT    | `/api/admin/students/{id}` | Update a student |
| DELETE | `/api/admin/students/{id}` | Delete a student |

---

# 📖 Borrowing Routes

| Method | Endpoint                            | Description           |
| ------ | ----------------------------------- | --------------------- |
| GET    | `/api/admin/borrowings`             | Get all borrowings    |
| POST   | `/api/admin/borrowings`             | Borrow a book         |
| GET    | `/api/admin/borrowings/active`      | Get active borrowings |
| GET    | `/api/admin/borrowings/{id}`        | Get borrowing record  |
| PUT    | `/api/admin/borrowings/{id}/return` | Return a book         |

---

# 📊 Dashboard Route

| Method | Endpoint               | Description               |
| ------ | ---------------------- | ------------------------- |
| GET    | `/api/admin/dashboard` | Get dashboard information |

---

# 🔒 Protected Routes

Most management routes require authentication.

Protected routes include:

```text
Books
Students
Borrowings
Dashboard
Admin Profile
Admin Logout
```

The API uses:

```text
auth:sanctum
```

middleware to protect these routes.

---

# 🧪 Example API Flow

## Step 1: Register an Admin

```text
POST /api/admin/register
```

---

## Step 2: Login

```text
POST /api/admin/login
```

Copy the authentication token.

---

## Step 3: Authorize Swagger

Add the token:

```text
Bearer YOUR_TOKEN
```

---

## Step 4: Add a Book

```text
POST /api/admin/books
```

Example:

```json
{
    "title": "Introduction to Networking",
    "author": "John Smith",
    "isbn": "9781234567890",
    "category": "Networking",
    "quantity": 10,
    "available_quantity": 10,
    "description": "Basic networking concepts and principles."
}
```

---

## Step 5: Add a Student

```text
POST /api/admin/students
```

Example:

```json
{
    "student_id": "2023-00123",
    "name": "Juan Dela Cruz",
    "email": "juan@example.com",
    "course": "BSIT",
    "year_level": 3
}
```

---

## Step 6: Borrow a Book

```text
POST /api/admin/borrowings
```

Example:

```json
{
    "book_id": "BOOK_ID_HERE",
    "student_id": "STUDENT_ID_HERE",
    "due_date": "2026-09-20"
}
```

The system automatically retrieves:

```text
Student Name
Student ID Number
```

from the student record.

The available quantity of the book is also reduced.

---

## Step 7: View Active Borrowings

```text
GET /api/admin/borrowings/active
```

---

## Step 8: Return a Book

```text
PUT /api/admin/borrowings/{id}/return
```

The system will:

```text
Increase Book Available Quantity
Update Return Date
Update Status to Returned
```

---

# 📁 Project Structure

```text
libtrack-system
│
├── app
│   ├── Http
│   │   └── Controllers
│   │       ├── AuthController.php
│   │       ├── BookController.php
│   │       ├── BorrowingController.php
│   │       ├── DashboardController.php
│   │       ├── StudentController.php
│   │       └── SwaggerController.php
│   │
│   └── Models
│       ├── Book.php
│       ├── Borrowing.php
│       ├── Student.php
│       └── User.php
│
├── config
│   ├── auth.php
│   ├── database.php
│   ├── l5-swagger.php
│   └── sanctum.php
│
├── database
│   ├── migrations
│   └── seeders
│
├── routes
│   ├── api.php
│   └── web.php
│
├── storage
│   └── api-docs
│
├── .env.example
├── composer.json
└── README.md
```

---

# 📋 Project Requirements

This project was developed to meet the following requirements:

| Requirement                                | Status      |
| ------------------------------------------ | ----------- |
| Create a backend application using Laravel | ✅ Completed |
| Admin Authentication                       | ✅ Completed |
| Admin Dashboard                            | ✅ Completed |
| At least 20 Routes                         | ✅ Completed |
| API Documentation                          | ✅ Completed |
| MongoDB Database                           | ✅ Completed |
| MVC Structure                              | ✅ Completed |
| `.env` Configuration                       | ✅ Completed |

---

# 🎯 Key Concepts Demonstrated

This project demonstrates:

* RESTful API Development
* Laravel Framework
* MVC Architecture
* MongoDB Integration
* API Authentication
* Laravel Sanctum
* CRUD Operations
* API Documentation
* Swagger / OpenAPI
* Environment Configuration
* Route Protection
* Git Version Control
* GitHub Repository Management

---

# 🔮 Future Improvements

Possible future improvements include:

* Search and filter books
* Book categories management
* Student borrowing history
* Overdue book monitoring
* Due date notifications
* Fine management
* Pagination
* Advanced dashboard statistics
* Admin role management
* Activity logs
* Frontend Admin Dashboard
* Book cover image upload
* Email notifications

---

# 👨‍💻 Developer

**Jain J. Alawi**

Bachelor of Science in Information Technology

---

# 📄 License

This project was created for educational purposes.

---

# 🙏 Acknowledgments

This project was developed using:

* Laravel
* MongoDB
* Laravel Sanctum
* Swagger / OpenAPI
* Composer
* Git
* GitHub

---

## ⭐ LibTrack Library Tracking System

A Laravel and MongoDB-based backend API for managing books, students, and library borrowing transactions.


The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
