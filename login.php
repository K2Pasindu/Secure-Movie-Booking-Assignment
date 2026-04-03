<?php
include "Database.php";
session_start();

// Check if inputs are empty
if($_POST['username'] == '' || $_POST['password'] == ''){
    foreach ($_POST as $key => $value) {
        if($value == '') {
            // --- SECURE FIX 3: Output Encoding for XSS [OWASP A03:2021] ---
            // htmlspecialchars() පාවිච්චි කරලා key එකේ තියෙන script එකක් run වෙන එක වළක්වනවා
            echo "<li>Please Enter " . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . ".</li>";
        }
    }
    exit();
}

$uname = $_POST['username'];
$password = $_POST['password'];

// --- SECURE FIX 1: Prepared Statements for SQL Injection [OWASP A01:2021] ---
$stmt = $conn->prepare("SELECT password FROM user WHERE username = ?");
$stmt->bind_param("s", $uname);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){
    // --- SECURE FIX 2: Verify Hashed Password [OWASP A07:2021] ---
    if (password_verify($password, $row['password'])) {
        // --- SECURE FIX 3: Protect Session Data from XSS ---
        // Session එකට දාන දත්තත් encode කිරීම ආරක්ෂිතයි
        $_SESSION['uname'] = htmlspecialchars($uname, ENT_QUOTES, 'UTF-8');
        echo 1; 
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
