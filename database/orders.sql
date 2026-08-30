CREATE DATABASE Restaueant_db;

USE Restaueant_db;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,

    customer_name VARCHAR(100) NOT NULL,

    items TEXT NOT NULL,

    total DECIMAL(10,2) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);