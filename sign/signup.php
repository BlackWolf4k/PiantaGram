<html>
    <head>
        <link rel = "stylesheet" href = "./sign.css" >
        <title>PiantaGram SignUp</title>
    </head>
    <body class = "signin_body" >
        <div class = "login" >
            <form action = "sign.php" method = "post" class = "sign_form" >
                <a>Email</a><br>
                <input type = "text" name = "email" class = "sign_input" ><br><br>
                <a>Username</a><br>
                <input type = "text" name = "username" class = "sign_input" ><br><br>
                <a>Password</a><br>
                <input type = "password" name = "password" class = "sign_input" ><br><br>
                <input type = "submit" value = "Sign Up" class = "sign_button" ><br>
                <input type = "hidden" value = "1" name = "signup" >
            </form>
            <div class = "question" >
                <a>Already have an account? </a><a href = "./signin.php" >Sign In</a>
            </div>
        </div>
    </body>
</html>