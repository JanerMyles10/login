<?php
session_start(); // Start a session to store logged-in user's info
include('connect.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging to check if POST data is received
    print_r($_POST);

    // Retrieve and sanitize input
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Sanitize user input
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Check if user exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Fetch the row as $user
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, create session
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            
            // Redirect to a protected page (e.g., dashboard)
            header("Location: dashboard.php"); // Ensure this page exists
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No such user found!";
    }
    
    $conn->close(); // Close the database connection
}
?>
