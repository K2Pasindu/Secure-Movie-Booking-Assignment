<?php
// --- OAuth 2.0 Configuration [Assignment Requirement 11 & 12] ---
// Documentation: https://developers.google.com/identity/protocols/oauth2

// IMPORTANT: Client Secret is redacted for security to prevent exposure in public repository.
// In a production environment, use Environment Variables (.env) to store these secrets.

define('GOOGLE_CLIENT_ID', '327020739042-g1fug6qc0qn684vj234q8sjf59pm46v0.apps.googleusercontent.com'); 

// SECURE PRACTICE: Placeholders used for sensitive data in version control
define('GOOGLE_CLIENT_SECRET', 'REDACTED_FOR_SECURITY_PURPOSES'); 

define('GOOGLE_REDIRECT_URL', 'http://localhost/online-movie-booking-main/google-callback.php');

// Generate Google Login URL
$google_auth_url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    'client_id' => GOOGLE_CLIENT_ID,
    'redirect_uri' => GOOGLE_REDIRECT_URL,
    'response_type' => 'code',
    'scope' => 'openid email profile',
    'access_type' => 'online'
]);
?>
