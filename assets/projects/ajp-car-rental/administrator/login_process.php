<?php
session_start();

// Include the credentials file
require_once 'login_creds.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check the username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $validUsername && $password === $validPassword) {
        // Set a session variable to indicate that the user is logged in
        $_SESSION['loggedin'] = true;

        // Redirect to indextable.php
        header('Location: index_table.php');
        exit();
    } else {
        // Invalid credentials
        echo 'Invalid username or password.';
    }
}
