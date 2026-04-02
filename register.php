<?php
include_once "Database.php";
session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['number'];
    $city = $_POST['city'];
    $password = $_POST['password'];
    $filename = $_FILES['image']['name'];

    // --- SECURE FIX 1: Password Hashing [OWASP A07:2021] ---
    // Passwords plain text store karanne nathuwa hash karanawa
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $location = 'admin/image/' . $filename;
    $file_extension = strtolower(pathinfo($location, PATHINFO_EXTENSION));
    $image_ext = array('jpg', 'png', 'jpeg', 'gif');

    $response = 0;
    if (in_array($file_extension, $image_ext)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $location)) {
            $response = $location;
        }
    }

    // --- SECURE FIX 2: Prepared Statements for SQL Injection [OWASP A03:2021] ---
    $stmt = $conn->prepare("INSERT INTO user (username, email, mobile, city, password, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $email, $mobile, $city, $hashed_password, $filename);

    if ($stmt->execute()) {
        echo "<script>alert('Registration Successful!'); window.location = 'login_form.php';</script>";
    } else {
        echo "Error: Registration failed.";
    }
    
    $stmt->close();
}
?>
