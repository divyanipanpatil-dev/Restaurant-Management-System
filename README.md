# 🍔 Digital Restaurant Management System

A simple web-based **Restaurant Management and Food Ordering System** developed using PHP, MySQL, HTML, CSS, and JavaScript.

The system allows customers to view food items and place orders, while administrators can manage food items and customer orders through an admin panel.

---

## 📌 Features

### 👤 Customer Side

- View restaurant menu
- Food items loaded dynamically from MySQL
- View food name, description, price, and image
- Add food items to cart
- Increase/decrease food quantity
- Remove food from cart
- View total price
- Place an order
- Enter customer name
- Store customer orders in MySQL

### 🔐 Admin Side

- Admin login system
- Secure password authentication
- PHP session-based authentication
- Admin dashboard
- View total food items
- View total orders
- Add new food items
- Upload food images
- Edit existing food items
- Delete food items
- View customer orders
- Delete completed orders
- Logout

---

## 🛠️ Technologies Used

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Server:** Apache
- **Development Environment:** XAMPP
- **Editor:** Visual Studio Code

---

## 📂 Project Structure

```text
digital-restaurant-management-system/
│
├── index.php
├── style.css
├── conn.php
│
├── save_order.php
├── view_orders.php
├── delete_order.php
│
├── image/
│   ├── image1.webp
│   ├── image2.webp
│   ├── image3.webp
│   ├── image5.webp
│   ├── image6.jpg
│   └── image7.jpg
│
├── uploads/
│   └── food/
│       └── uploaded food images
│
├── admin/
│   ├── login.php
│   ├── authenticate.php
│   ├── dashboard.php
│   ├── add_food.php
│   ├── save_food.php
│   ├── manage_food.php
│   ├── edit_food.php
│   ├── update_food.php
│   ├── delete_food.php
│   └── logout.php
│
└── database/
    └── restaurant.sql
```

---

## 💻 Installation

### 1. Install XAMPP

Install XAMPP and start the following services from the XAMPP Control Panel:

```text
Apache
MySQL
```

### 2. Copy the Project

Copy the project folder into:

```text
C:\xampp\htdocs\
```

Example:

```text
C:\xampp\htdocs\digital-restaurant-management-system\
```

### 3. Create the Database

Open:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
restaurant_db
```

Then import:

```text
database/restaurant.sql
```

### 4. Check Database Connection

Open:

```text
conn.php
```

The connection should use:

```php
<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "restaurant_db";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

?>
```

If your MySQL installation has a password, update the `$password` value.

---

## 👤 Creating Admin Account

If `create_admin.php` is included in the project, open:

```text
http://localhost/digital-restaurant-management-system/admin/create_admin.php
```

The default example credentials are:

```text
Username: admin
Password: admin123
```

After successfully creating the admin account, **delete `create_admin.php` for security**.

---

## 🔐 Admin Login

Open:

```text
http://localhost/digital-restaurant-management-system/admin/login.php
```

Log in using your admin username and password.

---

## 📊 Admin Dashboard

After login, the dashboard provides:

```text
Admin Dashboard
│
├── Food Items
│
├── Orders
│
├── Add Food
│
├── Manage Food
│
├── View Orders
│
└── View Restaurant
```

### ➕ Add Food

Use **Add Food** to add a new menu item.

Enter:

- Food name
- Description
- Price
- Food image

The food item is saved in the MySQL `foods` table and the uploaded image is stored in:

```text
uploads/food/
```

### ✏️ Manage Food

Use **Manage Food** to view existing food items.

You can:

- Edit food name
- Edit description
- Edit price
- Change food image
- Delete food items

### 📦 View Orders

Use **View Orders** to see customer orders, including:

- Customer name
- Ordered food items
- Total amount
- Order date/time

Completed orders can be deleted by the administrator.

---

## 🛒 Customer Menu

Open:

```text
http://localhost/digital-restaurant-management-system/index.php
```

Customers can:

- View food items
- Add food to cart
- Change quantity
- Remove items
- View total
- Enter their name
- Place an order

Food items added through the admin panel are displayed automatically on the customer menu.

---

## 🔄 System Flow

### Customer Flow

```text
Customer
   │
   ▼
index.php
   │
   ▼
Food Menu
   │
   ▼
Cart
   │
   ▼
Place Order
   │
   ▼
save_order.php
   │
   ▼
MySQL
   │
   ▼
orders table
```

### Admin Flow

```text
Admin Login
     │
     ▼
Dashboard
     │
     ├── Add Food
     │      │
     │      ▼
     │   Save Food
     │      │
     │      ▼
     │   MySQL
     │
     ├── Manage Food
     │      ├── Edit
     │      └── Delete
     │
     └── View Orders
            │
            └── Delete Completed Orders
```

---

## 🗄️ Database Tables

The system uses three main tables.

### `admins`

Stores administrator accounts.

```text
id
username
password
created_at
```

### `foods`

Stores restaurant menu items.

```text
id
name
description
price
image
created_at
```

### `orders`

Stores customer orders.

```text
id
customer_name
items
total
created_at
```

---

## ⚠️ Important

Always run the project through **XAMPP/localhost**.

Do not open PHP files by double-clicking them.

❌ Incorrect:

```text
file:///C:/xampp/htdocs/...
```

✅ Correct:

```text
http://localhost/digital-restaurant-management-system/
```

Make sure **Apache and MySQL are running** before using the system.

---

## 🔒 Security Notes

- Admin passwords should be stored using PHP `password_hash()`.
- Password verification should use `password_verify()`.
- Admin pages should be protected with PHP sessions.
- Use prepared statements for database queries.
- Validate uploaded image files.
- Delete temporary admin account creation files after use.
- Do not expose database passwords in public repositories.

---

## 🚀 Future Improvements

Possible future features:

- Customer registration and login
- Admin order status
- Pending / Preparing / Completed orders
- Food categories
- Food search
- Food availability status
- Online payment
- Customer order history
- Order invoice/receipt
- Admin profile
- Restaurant settings
- Sales reports
- Daily/monthly revenue reports
- Responsive mobile design

---

## 👨‍💻 Project Information

**Project Name:** Digital Restaurant Management System

**Technologies:**

```text
PHP
MySQL
HTML5
CSS3
JavaScript
XAMPP
```

---

## 📄 License

This project is developed for educational and project purposes.
