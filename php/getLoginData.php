<?php
   // if (isset($_POST["uid"]) && isset($_POST["pwd"])) {

        //session start in dummy login!
        session_start();
        //$insertedId = $_POST["uid"];
        //$insertedPwd = $_POST["pwd"];

        $insertedId = $_GET["uid"];
        $insertedPwd = $_GET["pwd"];

        //checks for json file
        $content = file_get_contents('../json/dummyLogin.json');

        $contentJSON = json_decode($content, true);

        foreach($contentJSON as $field => $value) {
            if ($value["uName"] == $insertedId) {
                if ($value["pwd"] == $insertedPwd)
                    //set session usw.
                    $_SESSION["uName"] = $insertedId;
                    $_SESSION["uType"] = $value["type"];
                    //echo $value["type"];
                    //echo "logged";
                    //header("Location: index.php?action=loginSucc");
                    die;
            }
        }
        //header("Location: index.php?acion=loginFail");
        die;

        //prepared stmt --> to implement when db is ready

   /* } else {
        header("Location: index.php?action=badRequest);
    }*/
?>