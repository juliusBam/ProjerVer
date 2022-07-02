<?php

if(isset($_POST["submit"]))
{


    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];

    // include signup classes
    include "../classes/dbh.classes.php";
    include "../classes/login.classes.php";
    include "../classes/login-contr.classes.php";
    $login = new LoginContr($uid, $pwd);

    // Running error handlers and user signup
    $login->loginUser();

    // Going to back to front page

    //header("location: ../login.php?error=none");
}
