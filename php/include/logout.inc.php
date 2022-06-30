<?php

session_start();
session_unset();
session_destroy();

    // ----- TODO -----
    //how to get out to login.php ??
header("location: ../login.php?error=none");