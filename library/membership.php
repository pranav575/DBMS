<?php
session_start();
require_once 'access.php'; // Include your database connection

// Create the membership table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS membership (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    membership_plan ENUM('Gold', 'Silver', 'Platinum') NOT NULL,
    membership_end DATE NOT NULL,
    payment_mode ENUM('Credit Card', 'Debit Card', 'PayPal', 'Bank Transfer') DEFAULT NULL
)";
mysqli_query($conn, $sql);

// Registration Handler
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $membership_plan = $_POST['membership_plan'];
    $membership_end = $_POST['membership_end'];
    $payment_mode = $_POST['payment_mode'];

    $sql = "INSERT INTO membership (username, password, membership_plan, membership_end, payment_mode) 
            VALUES ('$username', '$password', '$membership_plan', '$membership_end', '$payment_mode')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Registration successful!";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Membership Registration</title>
    <style>
        body {
            background-image: url('assets/dashboard.jpg'); /* Adjust the path to your background image */
            
            backdrop-filter: blur(8px);
        }
        .table {
            background-color:white;
        }
       
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Register for Membership</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); endif; ?>
    
    <!-- Registration Form -->
    <form method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        
        <div class="form-group">
            <label for="membership_plan">Membership Plan</label>
            <select name="membership_plan" class="form-control" required>
                <option value="Gold">Gold</option>
                <option value="Silver">Silver</option>
                <option value="Platinum">Platinum</option>
            </select>
        </div>

        <div class="form-group">
            <label for="membership_end">Membership End Date</label>
            <input type="date" name="membership_end" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="payment_mode">Payment Mode</label>
            <select name="payment_mode" class="form-control" required>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
                <option value="PayPal">PayPal</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>
        </div>
        
        <button type="submit" name="register" class="btn btn-primary">Register</button>
        <a href="dashboard.php" class="btn btn-info mt-3">Back to Dashboard</a>  
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
