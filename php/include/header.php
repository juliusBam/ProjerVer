<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/myStyle.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>ProjerVer</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand mb-0 h1 mt-2 ms-3">ProjerVer</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <!--<ul class="navbar-nav mt-2">-->
      <ul class="navbar-nav me-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <?php
          if(isset($_COOKIE["userID"])) {
            echo '<li class="nav-item">
                    <a class="nav-link" href="todo.php">Board</a>
                  </li>';
            if (isset($_COOKIE["userType"]) && $_COOKIE["userType"] == "1") {
              echo '<li>
                      <a class="nav-link" href="adminPage.php">Admin Page</a>
                    </li>';
            }
          }
          echo '<li>
                  <a class="nav-link" href="impressum.php">Impressum</a>
                </li> ';
          if (isset($_COOKIE["userID"])) {
            echo '<li><a href="logout.php" class="nav-link">Logout</a></li>';
          } else {
            echo '<li><a href="login.php" class="nav-link">Login</a></li>';
          }
        ?>
      </ul>
      <form class="d-flex">
        <?php
          if(isset($_COOKIE["userName"])) {
            echo '<ul class="navbar-nav me-auto>';
            echo '<li class="nav-item" style="margin-right: 20px;">Logged as: '.$_COOKIE["userName"].'</li>';
            echo '</ul>';
          }
        ?>
      </form>
    </div>
</nav>
