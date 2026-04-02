<?php
include "Database.php";
session_start();

// Check if inputs are empty
if($_POST['username'] == '' || $_POST['password'] == ''){
    foreach ($_POST as $key => $value) {
        if($value == '') {
            echo "<li>Please Enter ".$key.".</li>";
        }
    }
    exit();
}

$uname = $_POST['username'];
$password = $_POST['password'];

// --- SECURE FIX: Using Prepared Statements to prevent SQL Injection [OWASP A03:2021] ---
// [cite: 6, 26, 36]
$stmt = $conn->prepare("SELECT count(*) as cntUser FROM user WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $uname, $password); // "ss" means two strings
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$count = $row['cntUser'];

if($count > 0){
    $_SESSION['uname'] = $uname;
    echo 1; // Success response for AJAX/Form
} else {
    echo "<li>Invalid Username or password.</li>";
    exit();
}

$stmt->close();
?>
