
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gamecenter Login</title>
    <link rel="stylesheet" href="public/stylesheets/login.css">
</head>
<body>

<div id="login-page">

<div class="start-form">
<form id="login">
    <h1>Log in</h1>
        <input name="login-name" placeholder="Name">
        <div class="error-message" id="ErrorLoginName"></div>
        <input name="login-password" placeholder="Password" type="password">
        <div class="error-message" id="ErrorLoginPassword"></div>
        <button>Log in</button>
        <h3> Don't have a user? </h3>
        <p onclick="displaySignup()">Click here to <span>sign in</span></p>
    </form>
</div>

<div class="start-form">
    <form id="signup">
        <h1>Sign up</h1>
        <input name="signup-name" type="text" placeholder="Name">
        <div class="error-message" id="ErrorSignupName"></div>
        <input name="signup-mail" type="text" placeholder="Mail">
        <div class="error-message" id="ErrorSignupMail"></div>
        <input name="signup-password" placeholder="Password" type="password">
        <div class="error-message" id="ErrorSignupPassword"></div>
        <button>Sign up</button>
        <h3> Already a user? </h3>
        <p onclick="displayLogin()">Click here to <span>log in</span></p>
    </form>
</div>
<div id="background-image"></div>
</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/login.js"></script>
<script src="js/signup.js"></script>
<script>
    function displayLogin(){
        $('#signup').hide();
        $('#login').show();
    }
    function displaySignup(){
        $('#signup').show();
        $('#login').hide();
    }

</script>
</body>
</html>