# 📚 LibTrack Library Tracking System

A backend REST API built with **Laravel** and **MongoDB** for managing library books, students, and book borrowing and returning transactions.

LibTrack provides secure **admin authentication** and API endpoints for managing library resources. The project follows the **MVC (Model-View-Controller)** architectural pattern and includes interactive API documentation using **Swagger / OpenAPI**.



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



# ✨ Features

## 🔐 Admin Authentication

The system provides authentication features for administrators.

Available features:

* Admin Registration
* Admin Login
* Admin Logout
* Admin Profile
* Protected API Routes using Laravel Sanctum


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



## 🔄 Book Returning

The system allows administrators to return borrowed books.

When a book is returned:

1. The system checks if the borrowing record exists.
2. The system checks if the book was already returned.
3. The book's available quantity is increased.
4. The borrowing status is updated to `returned`.
5. The return date is recorded.


## 📊 Borrowing Management

Administrators can:

* View all borrowing records
* View active borrowings
* View a specific borrowing record
* Return borrowed books



## 📈 Dashboard

The system includes an admin dashboard endpoint for retrieving library-related information and statistics.



# 🛠️ Technologies Used

| Technology        | Purpose                      |
| ----------------- | ---------------------------- |
| PHP               | Backend Programming Language |
| Laravel           | Backend Framework            |
| MongoDB           | Database                     |
| Laravel Sanctum   | API Authentication           |
| L5 Swagger UI     | API Documentation            |
| Composer          | PHP Dependency Management    |
| Git               | Version Control              |
| GitHub            | Project Repository           |



# 🏗️ Architecture

The project follows the **MVC (Model-View-Controller)** architecture.

text
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


# 👨‍💻 Developer

**Jain J. Alawi**

Bachelor of Science in Information Technology



# 📄 License

This project was created for educational purposes.



# 🙏 Acknowledgments

This project was developed using:

* Laravel
* MongoDB
* Laravel Sanctum
* Swagger 
* Composer
* Git
* GitHub



## ⭐ LibTrack Library Tracking System

A Laravel and MongoDB-based backend API for managing books, students, and library borrowing transactions.


The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
