<?php
include('connect.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; // Change username to email
    $password = $_POST['password'];

    // Simple input sanitization
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Email already taken!";
        exit();
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";
    
    if ($conn->query($sql) === TRUE) {

    } 

    $conn->close(); // Close the database connection
}
?>
