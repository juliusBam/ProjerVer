 <?php include('include/header.php')?> 
  <?php 
    if(isset($_GET["site"]))
    {
      switch($_GET["site"])
      {
        case "login": include('login.php'); break;
        case  "signup": include('signup.php'); break;
      }
    }
  ?>
  <div class="contianer">
    <h1>Welcome to Test Index!</h1>
  </div>
  <img src="../img/office_banner.jpg" class="img-fluid" alt="Responsive image" width="460"></img>
  </body>
</html>
 