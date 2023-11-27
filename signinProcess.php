<?php
session_start();

// Database connection credentials
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session and redirect to dashboard or home page
            $_SESSION['username'] = $username;
            header("Location: dashboard.php"); // Redirect to your dashboard page
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User does not exist!";
    }
}

$conn->close();
?>
