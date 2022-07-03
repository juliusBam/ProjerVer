<?php    
// set cookies with userID, userName and userType
if (isset($_GET["error"]) && $_GET["error"] == "none"){
    session_start();
    setcookie('userID', $_GET["userID"], time() + 3600);
    setcookie('userName', $_GET["userName"], time() + 3600);
    setcookie('userType', $_GET["fk_roleID"], time() + 3600);
    header("location: index.php");
    }
?>
<?php include('../php/include/header.php')?>
<?php include('../php/classes/dbh.classes.php');?>

<section class="index-login">
    <div class="wrapper">
        <div class="index-login-login">
            <h4>Login</h4>
            <p>Enjoy to be a member!</p>
            <?php
                 if(isset($_GET["error"]) && $_GET["error"] == "stmtfailed") {
                    echo '<small class="text-danger>Error with the data retrieval</small>';
                 } else if(isset($_GET["error"]) && $_GET["error"] == "emptyinput") {
                    echo '<small class="text-danger>Please fill all the fields</small>';
                 }
            ?>
            <form action="include/login.inc.php" method="post">
                <?php 
                    if(isset($_GET["error"]) && $_GET["error"] == "usernotfound") {
                        echo '<small class="text-danger>Wrong user</small>';
                    }
                ?>
                <input type="text" name="uid" placeholder="Username" required>
                <?php
                    if(isset($_GET["error"]) && $_GET["error"] == "wrongpassword") {
                        echo '<small class="text-danger">Wrong password</small>';
                    }
                        
                ?>
                <input type="password" name="pwd" placeholder="Password" required>
                <br>
                <button type="submit" name="submit">Login</button>
            </form>
        </div>
    </div>
</section>
    
</body>
</html>
