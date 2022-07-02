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

<section class="index-login">
    <div class="wrapper">
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
