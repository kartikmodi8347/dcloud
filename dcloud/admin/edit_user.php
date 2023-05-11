<!DOCTYPE html>
<html>
<head>
	<title>Admin Area</title>
	<!--Import Google Font-->
    <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet"> 

    <!--Import Master-Css-->
    <link href="../master-css/css/master-css.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include("header.php");

    if(isset($_GET['uid'])) {

      $reg = mysqli_query($con,"SELECT * FROM user_reg WHERE id='$_GET[uid]' ");
      $reg_row = mysqli_fetch_assoc($reg);  
      $log = mysqli_query($con,"SELECT * FROM login_user WHERE id='$_GET[uid]'");
      $log_row = mysqli_fetch_assoc($log);

      if (empty($reg_row['profile_pic']))
        {
          $user_pic = '../img/profile.png';  
        }
        else
        {
          $user_pic = '../user/profile_pic/'.$_GET['uid'].'/'.$reg_row['profile_pic']; 
        }
    }
    else 
    {
      echo'<meta http-equiv="refresh" content="0;url=../index.php"/>';   
    } 
    ?>

 <?php
          $error = "";
          if(isset($_POST['save']))
          {
            if($_FILES['img']['name'] !== '')
            {
            $propic = $_FILES['img']['name'];
            $propic_type=$_FILES['img']['type'];
            $propic_tmp =$_FILES['img']['tmp_name'];
            $propic_size = $_FILES['img']['size'];

                if($propic_type == 'image/png' || $propic_type == 'image/jpg' || $propic_type == 'image/jpeg')
                {
                  if ($propic_size > 100)
                  {
                      $file_name = rand(0,100).$propic;
                      $dir ='../user/profile_pic/'.$_GET['uid'];
                      if (!file_exists($dir))
                      {
                        mkdir($dir,0777,true);
                      }
                      move_uploaded_file($propic_tmp,$dir.'/'.$file_name);
                      $pu = mysqli_query($con,"UPDATE `user_reg` SET profile_pic='$file_name' WHERE id='$_GET[uid]' ");
                  }
                  else
                  {
                     $error = 'Maximum size ** is required';/****/
                  } 
                }
                else
                {
                    $error = 'Envalid profile picture';             
                }
            } 

            if (isset($_POST['fname']))
            {
                $fname = $_POST['fname'];
            }
            else
            {
                $error = "First name can't be blank";
            }

            if (isset($_POST['lname']))
            {
                $lname = $_POST['lname'];
            }
            else
            {
                $error = "Last name can't be blank";
            }

            if (isset($_POST['email']))
            {
                $email = $_POST['email'];

                if ($_POST['email'] !== $log_row['email'])
                {
                    $email_check = mysqli_query($con,"SELECT email FROM login_user WHERE email='$email' ");
                    $email_row = mysqli_num_rows($email_check);
                    if ($email_row == 1)
                    {
                        $error = "This email id aldredy exist";
                    }
                }
            }
            else
            {
                $error = "Email id can't be blank";
            }

            if (isset($_POST['username']))
            {
                $username= $_POST['username'];

                if ($_POST['username'] !== $log_row['username'])
                {
                    $un_check = mysqli_query($con,"SELECT username FROM login_user WHERE username='$username' ");
                    $un_row = mysqli_num_rows($un_check);
                    if ($un_row == 1)
                    {
                        $error = "This user name aldredy exist";
                    }
                }
            }
            else
            {
                $error = "user name can't be blank";
            }
            if($_POST['dob'])
            {
              $dob = $_POST['dob'];
              $year = substr($dob,0,4);
              $month= substr($dob,5,2);
              $day = substr($dob,8,2);
              $dob_unix = mktime(0,0,0,$month,$day,$year);
            }
            else
            {
              $dob_unix = $reg_row['Dob'];
            }
            $pnumber = $_POST['number'];

            if ($error == "")
            {
                $update_login = mysqli_query($con,"UPDATE login_user SET email='$email',username='$username' WHERE id='$_GET[uid]' ");
                $update_rg = mysqli_query($con,"UPDATE user_reg SET first_name='$fname',last_name='$lname',phone_num= '$pnumber',Dob=$dob_unix WHERE id='$_GET[uid]' ");
                echo'<meta http-equiv="refresh" content="0">';
            }

          }
          ?>    

	<table class="main with-fix">
		<tr>
			<td class="hide-on-s side" valign="top">
				<center>
					<?php include_once 'side_manu.php'; ?>
					
				</center>
			</td>
			<td valign="top">
				<div style="width: 94%; margin-left: 3%; margin-top: 2%;">
			         
                     <div class="card circul-x2 full-on-s" style="width: 100%; margin-top:20px !important; height: auto; margin: 20px 10px 0px 10px ; min-height: 200px; background: rgba(255,255,255,0.6)" >
               <div class="card-head">Edit Profile</div>
               <div class="card-item">
                 <form method="post" enctype="multipart/form-data">
                    <div class="row">
                     <div class="col-l20" style="padding-top: 15px;">
                        <center>
                        <img src="<?php echo $user_pic; ?>" id="c_pic" class="circul " style="height: 100px; width: 100px; border: 2px solid #f7f7f7">
                        </center>
                     </div>
                     <div class="col-l20" style="">
                        <center>
                            <input type="button" value="Select" id='select_img' class="btn-s blue lighten-4 white-text"/>
                            <input type="file" id="img" name="img" style="display: none;"  />
                        </center>
                   </div>

                   <table>
                       <tr>
                           <td width="100">First name</td>
                           <td><input type="text" name="fname" class="input-text" value="<?php echo $reg_row['first_name']; ?>"></td>
                       </tr>
                       <tr>
                           <td>Last name</td>
                           <td><input type="text" name="lname" class="input-text" value="<?php echo $reg_row['last_name']; ?>"></td>
                       </tr>
                       <tr>
                           <td>Username</td>
                           <td><input type="text" name="username" class="input-text" value="<?php echo $log_row['username']; ?>"></td>
                       </tr>
                       <tr>
                           <td>Birth date</td>
                           <td> <input type="date" name="dob" class="input-text" id="dob" value="<?php echo date('Y-m-d',$reg_row['Dob']);?>" /></td>
                       </tr>
                       <tr>
                           <td>Email Id</td>
                           <td><input type="text" value="<?php echo $log_row['email']; ?>" name="email" class="input-text" value=""></td>
                       </tr>
                       <tr>
                           <td>Phone number</td>
                           <td><input type="text" value="<?php echo $reg_row['phone_num']; ?>" name="number" class="input-text" value=""></td>
                       </tr>
                   </table>

                   <div class="row">
                     <div class="col-l20" style="padding-top: 15px;padding-bottom: 10px;"><input type="submit" class="blue white-text btn-s" name="save" value="Save"/></div>
                   </div>
                  <?php echo $error ?> 
                 </form>
               </div>             
          </div>

				</div>
			</td>
		</tr>
		<!-- <tr>
			<td colspan="2" height="80">Hello</td>
		</tr> -->
	</table>
</body>
<script src="../jquery.js"></script>
              
    <!--Import master-css script file-->
    <script type="text/javascript" src="../master-css/script/master-css.js"></script>
     <script type="text/javascript">
      
      $('#select_img').click(function(){
        $("#img").trigger('click');
      });

     
    </script>
</html>