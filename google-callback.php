<?php
include_once "Database.php";
include_once "google-config.php";
session_start();

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // 1. Exchange Code for Token
    $token_url = "https://oauth2.googleapis.com/token";
    $post_fields = [
        'code'          => $code,
        'client_id'     => '327020739042-g1fug6qc0qn684vj234q8sjf59pm46v0.apps.googleusercontent.com',
        'client_secret' => 'REDACTED_FOR_SECURITY', 
        'redirect_uri'  => GOOGLE_REDIRECT_URL,
        'grant_type'    => 'authorization_code'
    ];

    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);

    if (isset($data['access_token'])) {
        $access_token = $data['access_token'];

        // 2. Get User Info
        $user_info_url = "https://www.googleapis.com/oauth2/v2/userinfo?access_token=" . $access_token;
        $ch_info = curl_init($user_info_url);
        curl_setopt($ch_info, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_info, CURLOPT_SSL_VERIFYPEER, false);
        $user_info_json = curl_exec($ch_info);
        $user_info = json_decode($user_info_json, true);

        if (isset($user_info['email'])) {
            $email = $user_info['email'];
            $name  = $user_info['name'];

            // 3. Check if user exists
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $_SESSION['uname'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                // New user registration
                // Google login කරන අයට password එකක් නැති නිසා random එකක් හදනවා
                $hashed_pass = password_hash(bin2hex(random_bytes(10)), PASSWORD_BCRYPT);
                
                // අනිත් columns වලට හිස් අගයන් (empty strings) දෙනවා Database එකේ NULL support නැත්නම්
                $stmt_insert = $conn->prepare("INSERT INTO user (username, email, mobile, city, password, image) VALUES (?, ?, 0, '', ?, '')");
                $stmt_insert->bind_param("sss", $name, $email, $hashed_pass);
                
                if ($stmt_insert->execute()) {
                    $_SESSION['uname'] = $name;
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Database Error: " . $stmt_insert->error;
                }
            }
        }
    } else {
        echo "Authentication Failed!";
    }
}
?>
