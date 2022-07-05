<?php

// delete cookies, if the user wants to logout
setcookie('userID', "", time() - 3600);
setcookie('userName', "", time() - 3600);
setcookie('userType', "", time() - 3600);

// if the user clicks on the submit button, the user will be directed to the index page
header("location: index.php");
