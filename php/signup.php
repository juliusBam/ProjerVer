<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/myStyle.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    
    <script src="javaScript/functionsSignup"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <title>ProjerVer</title>
    </head>
    <body>
        <div class="container pt-3 w-50">
        <div class="index-login-signup">
            <h4 class="text-center">Sign Up</h4>
            <form action="includes/signup.inc.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label text-left">Username</label>
                    <input type="text" id="userame" class="form-control" name="uid" placeholder="Please enter a Username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password"  id="password" class="form-control" name="pwd" placeholder="Please enter a Password">
                </div>
                <div class="mb-3">
                    <label for="passwordRepetition" class="form-label">Repeat Passoword</label>
                    <input type="password"  id="passwordRepetition" class="form-control" name="pwdrepeat" placeholder="Please repeat the Password">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email"  id="email" class="form-control" name="email" placeholder="email@example.com">
                </div>
                <div class="mb-3">
                    <button type="submit"   id="btnSumbit" onclick="" class="form-control btn btn-outline-success" name="submit">Sign up!</button>
                </div>

            </form>
        </div>
        </div>
    </body>
</html>
