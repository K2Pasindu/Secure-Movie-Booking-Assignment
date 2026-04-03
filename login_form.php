<?php include_once "google-config.php"; ?>
<html>
<head>
    <title>Login Page - Movie Booking System</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="site.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .loginholder {
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
        }
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            background-color: #ffffff;
            color: #757575 !important;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            margin-top: 15px;
            border: 1px solid #dadce0;
            transition: background-color .3s;
        }
        .google-btn:hover {
            background-color: #f8f9fa;
            text-decoration: none;
            box-shadow: 0 1px 2px 0 rgba(60,64,67,0.302), 0 1px 3px 1px rgba(60,64,67,0.149);
        }
        .google-icon {
            width: 18px;
            height: 18px;
            margin-right: 10px;
        }
        input.inputbox {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error-text {
            color: red;
            font-size: 12px;
            margin-top: 2px;
        }
    </style>
</head>
<body>
<div class="parent-container">
    <table width="100%" height="100%">
        <tr>
            <td align="center" valign="middle">
                <div class="loginholder" style="background-color:white; width: 350px;">
                    <table width="100%" class="table-condensed">
                        <tr>
                            <td align="center">
                                <a href="./index.php"><img src="img/logo.png" alt="Logo" width="180px"></a>
                            </td>
                        </tr>
                        <tr>
                            <td><br><b>User Id:</b></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="inputbox" id="username" placeholder="Enter Username"/>
                                <div id="nameerror" class="error-text"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Password:</b></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" class="inputbox" id="password" placeholder="Enter Password"/>
                                <div id="passerror" class="error-text"></div>
                                <div id="msg" class="error-text"></div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center"><br />
                                <button class="btn btn-primary w-100" id="login" style="background-color: #2b3e50; border: none;">LOGIN</button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="center">
                                <a href="<?php echo $google_auth_url; ?>" class="google-btn">
                                    <svg class="google-icon" viewBox="0 0 48 48">
                                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24s.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                                    </svg>
                                    Sign in with Google
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td align="left"><br />
                                <span class="forgetpassword"><a href="forget_password.php" style="text-decoration:none; font-size:12px;"> Forget your Password?</a></span>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="register_form.php" style="text-decoration:none; font-size:12px;">Register now</a></td>
                        </tr>
                        <tr>
                            <td><hr style="border-top: 1px solid #ccc; margin: 15px 0;"/></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#login").click(function(){
            var username = $("#username").val().trim();
            var password = $("#password").val().trim();

            $("#nameerror, #passerror, #msg").html(""); // Clear previous errors

            if(username == "") {
                $("#nameerror").html("! Require Name.");
                return false;
            }
            if(password == "") {
                $("#passerror").html("! Require Password.");
                return false;
            }

            $.ajax({
                url: 'login.php',
                type: 'post',
                data: {username: username, password: password},
                success: function(response){
                    if(response == 1) {
                        window.location = "index.php";
                    } else {
                        // SECURE FIX: Prevent script execution from response
                        $("#msg").html(response);
                    }
                }
            });
        });
    });
</script>
</body>
</html>
