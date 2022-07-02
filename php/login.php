<?php     
session_start();

if (isset($_GET["error"]) && $_GET["error"] == "none"){
    setcookie('userID', $_GET["userID"], time() + 3600);
    setcookie('userName', $_GET["userName"], time() + 3600);
    setcookie('userType', $_GET["fk_roleID"], time() + 3600);

    }
?>
<?php include('../php/include/header.php')?>
<?php include('../php/classes/dbh.classes.php');?>

<header>
    <nav>
        </ul>
    </nav>
</header>

<section class="index-login">
    <div class="wrapper">
        <!-- <div class="index-login-signup">
            <h4>SIGN UP</h4>
            <p>Don't have an account yet? Sign up here!</p>
            <form action="php/includes/signup.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwdrepeat" placeholder="Repeat Password">
                <input type="text" name="email" placeholder="E-mail">
                <br>
                <button type="submit" name="submit">Sign up</button>
                <br><br>
                <p style="color:red;">We are sorry for the inconvenience, unfortunatley due
                   to a technical error, the sign up currently does not work.
                   In case you want to register a new account, please contact our Admin!
                </p>
            </form>
        </div> -->
        <div class="index-login-login">
            <h4>Login</h4>
            <p>Enjoy to be a member!</p>
            <form action="include/login.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <br>
                <button type="submit" name="submit">Login</button>
            </form>
        </div>
    </div>
</section>
    
</body>
</html>