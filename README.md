# Restaurant Management System

A simple web-based Restaurant Management System project.

## About the Project

This project displays a restaurant menu where users can see food items, prices, and descriptions. Users can also add food items to the cart and place orders.

The project uses HTML and CSS for the front end and PHP with a database for handling orders.

## Features

- View restaurant menu
- Display food images
- Show food name, price, and description
- Add items to cart
- Save orders
- View orders
- Delete orders
- Store order information in a database

## Technologies Used

- HTML
- CSS
- PHP
- MySQL

## Project Structure

```text
Restaurant-Management-System/
│
├── backend/
│   ├── conn.php
│   ├── save_order.php
│   ├── view_orders.php
│   └── delete_order.php
│
├── database/
│   └── orders.sql
│
├── image/
│   ├── image1.webp
│   ├── image2.webp
│   ├── image3.webp
│   ├── image4.webp
│   ├── image5.webp
│   └── image6.webp
│
├── index.html
├── style.css
└── README.md
```

## How to Run

1. Download or clone this project.
2. Install XAMPP or another PHP and MySQL server.
3. Copy the project folder into the `htdocs` folder.
4. Start **Apache** and **MySQL** in XAMPP.
5. Open phpMyAdmin.
6. Import the `database/orders.sql` file into MySQL.
7. Check the database connection details in `backend/conn.php`.
8. Open the project in your browser.

Example:

```text
http://localhost/Restaurant-Management-System/
```

## Purpose

This project was created to demonstrate a simple restaurant ordering system using front-end, PHP, and database technologies.

