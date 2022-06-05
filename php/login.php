<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Project</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="myStyle.css">
</head>
<body>

<header>
    <nav>
        <div>
            <h3>ProjerVer</h3>
            <ul class="menu-main">
                <li><a href="login.php">HOME</a></li>
                <li><a href="#">LOREM</a></li>
                <li><a href="#">IPSUM</a></li>
                <li><a href="#">DOLOR SIT AMET</a></li>
            </ul>
        </div>
        <ul class="menu-member">
            <?php
                if(isset($_SESSION["userid"]))
                {
            ?>
                <li><a href="#"><?php echo $_SESSION["useruid"]; ?></a></li>
                <li><a href="includes/logout.inc.php" class="header-login-a">LOGOUT</a></li>
            <?php
                }
                else
                {
            ?>
                <li><a href="#">SIGN UP</a></li>
                <li><a href="#" class="header-login-a">LOGIN</a></li>
            <?php  
                }
            ?>
        </ul>
    </nav>
</header>

<section class="index-login">
    <div class="wrapper">
        <div class="index-login-signup">
            <h4>SIGN UP</h4>
            <p>Don't have an account yet? Sign up here!</p>
            <form action="includes/signup.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwdrepeat" placeholder="Repeat Password">
                <input type="text" name="email" placeholder="E-mail">
                <br>
                <button type="submit" name="submit">SIGN UP</button>
            </form>
        </div>
        <div class="index-login-login">
            <h4>LOGIN</h4>
            <p>Enjoy to be a member!</p>
            <form action="includes/login.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <br>
                <button type="submit" name="submit">LOGIN</button>
            </form>
        </div>
    </div>
</section>
    
</body>
</html>