<?php

// session_start();
// session_unset();
// session_destroy();

setcookie('userID', "", time() - 3600);
setcookie('userName', "", time() - 3600);
setcookie('userType', "", time() - 3600);

    // ----- TODO -----
    //how to get out to login.php ??
header("location: index.php");
