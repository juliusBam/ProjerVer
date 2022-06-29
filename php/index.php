<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
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
          <p class="lead">This is a cool website to plan tasks.</p>
        </span>
    </div>
    <div class="row">
      <div class="col content" style="background-color: #e0265f;">
        <span class="text-center">
          <p class="lead">Statistcal Data</p>
        </span>
      </div>
      <div class="col content" style="background-color: #e0b25f;">
        <span class="text-center">
          <p class="lead">Statistcal Data</p>
        </span>
      </div>
    </div>
    <div class="row">
      <div class="col content" style="background-color: #5496eb;">
        <span class="text-center">
          <p class="lead">Login</p>
        </span>
      </div>
      <div class="col content" style="background-color: #699c73;">
        <span class="text-center">
          <p class="lead">Sign up today!</p>
        </span>
      </div>
    </div>
    </div>
    <div class="row title">
      <span class="lead pt-3 ms-3">
      Contact: <br>
      Email:   projerver@mail.at <br> 
      Phone:   0660 10203040 <br> 
      Address:  Seilerspeergasse 8/6/9
    </span>
    </div>
  </body>
</html>
 