 <?php include('include/header.php')?>
 <script src="../javaScript/scriptIndex.js" type="text/javascript"></script> 
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
  <div class="container-fluid">
    <div class="row title" style="background-color: #e3bbed;">
        <span class="pt-6">
          <h1 class="display-4">Welcome to ProjerVer!</h1>
          <p class="lead">This is a cool website to manage tasks.</p>
        </span>
    </div>
    <div class="row pt-3">
      <div class="col-sm pt-5 content text-center" style="background-color: #e0265f;">
        <span class="text">
          Statistical data
        </span>
      </div>
      <div class="col-sm pt-5  text-center content" style="background-color: #e0b25f;">
        <span class="text">
          Statistical data
        </span>
      </div>
    </div>
    <div class="row">
      <div class="col-sm pt-5 text-center content" style="background-color: #5496eb;">
        <span class="text">
          Login
        </span>
      </div>
      <div class="col-sm pt-5 text-center content" style="background-color: #699c73;">
        <span class="text">
          Sign Up today!
        </span>
      </div>
    </div>
    </div>
    <div class="row title">
      <span class="text">
          Contact: <br>
          Email:   projerver@mail.at <br> 
          Phone:   0660 10203040 <br> 
          Address:  Seilerspeergasse 8/6/9
      </span>
    </div>
  </body>
</html>
 