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
  </body>
</html>
 