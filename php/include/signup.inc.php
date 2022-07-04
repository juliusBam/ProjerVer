<?php
//#####################################################
//DEPRECATED FILE, WAS NOT DELETED JUST TO BE SURE
//#####################################################
if(isset($_POST["submit"]))
{

    // Grabbing the data
    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];
    $email = $_POST["email"];

    // Instantiate SignupContr class
    include "../classes/dbh.classes.php";
    include "../classes/signup.classes.php";
    include "../classes/signup-contr.classes.php";
    //$signup = new SignupContr($uid, $pwd, $pwdRepeat, $email);

    // Running error handlers and user signup
    //$signup->signupUser();

    $data = json_decode(file_get_contents('../../json/dummyLogin.json'), true);

    $temp = True;
    for ($x = 0; $x < count($data); $x++) {
        if($uid==$data[$x]["uName"])
        {
            echo "error username is already taken!\n";
            $temp=False;
        }
        else if($email==$data[$x]["email"])
        {
            echo "error email is already used!\n";
            $temp=False;
        }
    }
    if($temp)
    {
        $t=time();

		$new = array(
			 'uName'               =>     $uid,
			 'email'          =>     $email,
			 'pwd'          =>     $pwd,
			 'type'     =>     "guest",
			 'createdOn'     =>   date("Y-m-d  H:i:s",$t),
			 'lastLogin'     =>    ""

		);
        //push new User to data Array
		$data[] = $new;
		$final_data = json_encode($data);
		if(file_put_contents('../../json/dummyLogin.json', $final_data))
        {
            echo "User added successfully\n";
        }
    }


    // Going to back to front page
   // header("location: ../index.php?error=none");
}