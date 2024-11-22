CREATE DATABASE library_db;
USE library_db;


CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,  -- Store hashed passwords
    role ENUM('admin', 'member') NOT NULL,  -- Differentiate between admin and members
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    genre VARCHAR(100),
    publication_year YEAR,
    status ENUM('available', 'issued') DEFAULT 'available',  -- Availability of the book
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE members (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contact_number VARCHAR(15),
    address TEXT,
    join_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    member_id INT NOT NULL,
    issue_date DATE NOT NULL,
    return_date DATE,  -- Null if not returned yet
    status ENUM('issued', 'returned') DEFAULT 'issued',
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES members(member_id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE overdue_fees (
    fee_id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT NOT NULL,
    days_overdue INT NOT NULL,
    fee_amount DECIMAL(8, 2) NOT NULL,
    status ENUM('paid', 'unpaid') DEFAULT 'unpaid',
    FOREIGN KEY (transaction_id) REFERENCES transactions(transaction_id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);





