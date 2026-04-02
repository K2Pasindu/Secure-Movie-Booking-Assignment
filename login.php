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

// --- SECURE FIX 1: Prepared Statements for SQL Injection [OWASP A03:2021] ---
// අපි මුලින්ම username එකට අදාළ record එක විතරක් ගමු
$stmt = $conn->prepare("SELECT password FROM user WHERE username = ?");
$stmt->bind_param("s", $uname);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){
    // --- SECURE FIX 2: Verify Hashed Password [OWASP A07:2021] ---
    // Database එකේ තියෙන hash එකයි, user ගහපු plain password එකයි මෙතනදී match කරනවා
    if (password_verify($password, $row['password'])) {
        $_SESSION['uname'] = $uname;
        echo 1; // Success response for AJAX/Form
    } else {
        echo "<li>Invalid Username or password.</li>";
        exit();
    }
} else {
    echo "<li>Invalid Username or password.</li>";
    exit();
}

$stmt->close();
?>
