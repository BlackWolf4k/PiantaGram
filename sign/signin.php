<html>
    <head>
        <link rel = "stylesheet" href = "./sign.css" >
        <title>PiantaGram SignIn</title>
    </head>
    <body class = "signin_body" >
        <div class = "login" >
            <form action = "sign.php" method = "post" class = "sign_form" >
                <a>Username</a><br>
                <input type = "text" name = "username" class = "sign_input" ><br><br>
                <a>Password</a><br>
                <input type = "password" name = "password" class = "sign_input" ><br><br>
                <input type = "submit" value = "Sign In" class = "sign_button" ><br>
                <input type = "hidden" value = "0" name = "signup" >
            </form>
            <div class = "question" >
                <a>Have no account? </a><a href = "./signup.php" >Sign Up</a>
            </div>
        </div>
    </body>
</html>