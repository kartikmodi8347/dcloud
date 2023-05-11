<?php
require_once("config.php");

$error = "";

if (isset($_POST['sub']))
{

    if (empty($_POST['fname']))
    {
        $error ="Enter first name";
    }
    elseif (empty($_POST['lname']))
    {
        $error ="Enter last name";
    }
    elseif (empty($_POST['email']))
    {
        $error ="Enter email id";
    }
    elseif (empty($_POST['password']))
    {
        $error ="Enter password";
    }
    elseif (empty($_POST['dob']))
    {
        $error ="Select date of birth";
    }
    elseif (empty($_POST['gen']))
    {
        $error ="Select gender";
    }

    if($error == '') 
    {
        $first_name = htmlentities($_POST['fname']);
        $last_name = htmlentities($_POST['lname']);
        $email = htmlentities($_POST['email']);
        $pass = htmlentities($_POST['password']);
        $dob = $_POST['dob'];
        $gen = $_POST['gen'];

        $id = time().rand(0,9);
            
        $year = substr($dob,0,4);
        $month= substr($dob,5,2);
        $day = substr($dob,8,2);
        $dob_unix = mktime(0,0,0,$month,$day,$year);

        $full = $first_name.$last_name;
        $rep_full = str_replace(" ","",$full);
                $redy_name = strtolower($rep_full);
                $query = mysqli_query($con,"Select COUNT(id) as user_account FROM login_user WHERE username like '%".$redy_name."%'");
                $result = mysqli_fetch_array($query);

                $countu = $result['user_account'];
                if (!empty($countu))
                {
                    $username = $redy_name.$countu;
                }
                else {
                    $username = $redy_name;
                }

        $pass_new = sha1(md5($pass));
        $login_q = "INSERT INTO login_user (id,username,email,pass) VALUES ('$id', '$username', '$email', '$pass_new')";
        $run_login = mysqli_query($con,$login_q);

        $reg = "INSERT INTO user_reg (id,first_name,last_name,Dob) values('$id','$first_name','$last_name',$dob_unix)";
        $run_reg = mysqli_query($con,$reg);

        if (($run_login) && ($run_reg))
        {
            session_start();
            $_SESSION['user'] = $id;
            header('location:seq_q.php');

        }
        else
        {
            echo mysqli_error($run_login);
        }
    }
}
?>