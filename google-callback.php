<?php
include_once "Database.php";
include_once "google-config.php";
session_start();

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // 1. Exchange Authorization Code for Access Token
    $token_url = "https://oauth2.googleapis.com/token";
    $post_fields = [
        'code' => $code,
        'client_id' => GOOGLE_CLIENT_ID,
        'client_secret' => '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', // Local එකේදී මේක පාවිච්චි කරන්න
        'redirect_uri' => GOOGLE_REDIRECT_URL,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);

    if (isset($data['access_token'])) {
        $access_token = $data['access_token'];

        // 2. Get User Profile Info from Google API
        $user_info_url = "https://www.googleapis.com/oauth2/v2/userinfo?access_token=" . $access_token;
        $user_info_json = file_get_contents($user_info_url);
        $user_info = json_decode($user_info_json, true);

        if (isset($user_info['email'])) {
            $email = $user_info['email'];
            $name = $user_info['name'];
            $google_id = $user_info['id'];

            // 3. Check if user already exists in your database
            // --- SECURE FIX: Prepared Statements for SQL Injection ---
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // User exists, Log them in
                $_SESSION['uname'] = $name;
                header("Location: index.php");
            } else {
                // New user from Google, Register and Log them in
                $stmt_insert = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
                $dummy_pass = password_hash(bin2hex(random_bytes(10)), PASSWORD_BCRYPT);
                $stmt_insert->bind_param("sss", $name, $email, $dummy_pass);
                
                if ($stmt_insert->execute()) {
                    $_SESSION['uname'] = $name;
                    header("Location: index.php");
                }
            }
        }
    } else {
        echo "Google Authentication Failed!";
    }
} else {
    header("Location: login_form.php");
}
?>
