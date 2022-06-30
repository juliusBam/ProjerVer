<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/myStyle.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <title>ProjerVer</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand mb-0 h1 mt-2 ms-3">ProjerVer</a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mt-2">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="todo.php">Board</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Chat</a>
      </li>
      <li>
        <a class="nav-link" href="adminPage.php">Admin Page</a>
      </li>
      <li>
        <a class="nav-link" href="impressum.php">Impressum</a>
      </li> 
      <li>
        <a class="nav-link" href="login.php">Login</a>
        <?php
                if(isset($_SESSION["userid"]))
                {
            ?>
                <!-- <li><a href="#"><?php 
                //echo $_SESSION["useruid"]; ?></a></li> -->
                <li><a href="logout.inc.php" class="header-login-a">Logout</a></li>
            <?php
                }
                else
                {
            ?>
                <!-- <li><a href="#">SIGN UP</a></li>
                <li><a href="#" class="header-login-a">LOGIN</a></li> -->
            <?php  
                }
            ?>
      </li> 
    </ul>
  </div>
</nav>