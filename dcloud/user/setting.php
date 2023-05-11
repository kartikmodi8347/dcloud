<!DOCTYPE html>
<html>
    <title>Edit | D Cloud</title>
    <head>

    <?php require_once 'require.php'; ?>

    <meta name="viewport" content="width=device-width, initialscale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        body{
            /*background-image: url(../img/pexels-photo-14675.jpeg);
            background-size: cover;*/ 
        }
      </style>

      <?php
            require_once("../config.php");
            require_once("size_conv.php");

            session_start();
            if (isset($_SESSION['user']))
            {
              $user = $_SESSION['user'];
            }
            else
            {
               header("location:../index.php");
            }

            $reg = mysqli_query($con,"SELECT * FROM user_reg WHERE id=$user ");
            $reg_row = mysqli_fetch_assoc($reg);

            $log = mysqli_query($con,"SELECT * FROM login_user WHERE id=$user");
            $log_row = mysqli_fetch_assoc($log);

           $stor = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE id=$user");
            $size = mysqli_fetch_assoc($stor);

            $avilable = avilable($size['SUM(size)']);

            if (!empty($reg_row['profile_pic']))
            {
                $pro_pic_path = 'profile_pic/'.$user.'/'.$reg_row['profile_pic']; 
            }
            else
            {
                $pro_pic_path = '../img/profile.png';
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
                      $dir ='profile_pic/'.$user;
                      if (!file_exists($dir))
                      {
                        mkdir($dir,0777,true);
                      }
                      move_uploaded_file($propic_tmp,$dir.'/'.$file_name);
                      $pu = mysqli_query($con,"UPDATE `user_reg` SET profile_pic='$file_name' WHERE id='$user' ");
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
          		$update_login = mysqli_query($con,"UPDATE login_user SET email='$email',username='$username' WHERE id=$user ");
          		$update_rg = mysqli_query($con,"UPDATE user_reg SET first_name='$fname',last_name='$lname',phone_num= '$pnumber',Dob=$dob_unix WHERE id=$user ");
          		echo'<meta http-equiv="refresh" content="0">';
          	}

          }
          ?>
          <!-- Google Chart API ---->
          <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
          <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

              var data = google.visualization.arrayToDataTable([
                ['Effort', 'Amount given'],
                ['Avilable', <?php echo $avilable; ?>],
                ['Used', <?php echo $size['SUM(size)']; ?>]
              ]);

              var options = {
                pieHole: 0.4,
                pieSliceTextStyle: {
                  color: 'black',
                },
                legend: 'none'
              };

              var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
              chart.draw(data, options);
            }
          </script>
    </head>

    <body ><!-- blue-grey lighten-5 background-image: linear-gradient(to left bottom, #188ea6, #137d93, #0f6d80, #0b5d6e, #074e5c);--> 
    <!-- For mobile -->
    <?php require_once("mobile_option.php"); ?>


    <!-- Header -->
    <?php require_once("header.php"); ?>

      <div class="with-fix">

        <div class="card d-depth-2 white" style="width: 99%; margin-top: 20px; margin-left: .5%; border-radius: 4px 4px 0 0;">
      <table style="margin: 8px" style="border: none;">
        <tr>
          <th rowspan="2" width="100" style="border-bottom: none !important;"><center><img src="<?php echo $pro_pic_path; ?>" style="height: 72px; width: 72px; border:1px solid #f7f7f7;" class="circul d-depth-1"></center></th>
          <th><?php echo $reg_row['first_name'].' '.$reg_row['last_name']; ?></th>
        </tr>
        <tr>
          <td>
             <div class="option-h x4 hide-on-sm" style="width: 50%;" > 
                <a href="shared_file.php" style="font-size: 15px !important;"><i class="fa fa-cloud-upload" style="margin-right: 10px"></i>Shared File</a>
                <a href="recived_file.php" style="font-size: 15px !important;"><i class="fa fa-cloud-download" style="margin-right: 10px"></i>Received File</a>
               <a href="groups.php" style="font-size: 15px !important;"><i class="fa fa-group" style="margin-right: 10px"></i>Groups</a>
                <a href="setting.php" style="font-size: 15px !important;"><i class="fa fa-edit" style="margin-right: 10px"></i>Setting</a>
            </div>  
          </td>
        </tr>
      </table>
              </div>

        <div class="row" style="margin-left:2%; ">
          <div class="col-l4">
              <div class="card d-depth-2 white hide-on-sm" style="width: 100%; margin-top: 20px;">
                <div class="option-p grey-text text-darken-3">
                  <?php
                  $admin = mysqli_query($con,"SELECT role FROM login_user WHERE id='$user' && role='Admin' ");
                  $admin_check = mysqli_num_rows($admin);
                  if($admin_check == 1)
                  {
                    echo '<a href="" class="blue white-text"><i class="fa fa-user" style="margin-right: 10px"></i>Admin Area</a>';
                  }

                   ?>
                  <a href="home.php"><i class="fa fa-home" style="margin-right: 10px"></i>Home</a>
                  <a href="setting.php"><i class="fa fa-edit" style="margin-right: 10px"></i>Edit Profile</a>
                  <a href="fs_setting.php"><i class="fa fa-cloud-download" style="margin-right: 10px"></i>File and Storage</a>
                  <!-- <a href="grp_setting.php"><i class="fa fa-group" style="margin-right: 10px"></i>Groups Setting</a> -->
                </div>
              </div>

               <div class="card d-depth-2 white" style="width: 100%; margin-top: 20px;">
                <div class="card-item">
                  <?php include 'filesize.php'; ?>
                </div>
              </div>
              
              <div class="card d-depth-2 white hide-on-s" style="width: 100%; margin-top: 20px;">
                <div class="card-item">
                  <b>Storage</b>
                  <center>
                    <div id="donut_single" style="width: 100%; height: 100%;"></div>
                  </center>
                  <div style="font-size: 12px; line-height: 25px;">
                    <span class="blue-text text-darken-3"><b>Avilable</b></span><span class="right"><?php echo conv($avilable) ?> <i class="grey-text" style="font-size: 11px;">(<?php echo $avilable;?> byte)</i></span>
                  </div>
                  <div style="font-size: 12px;">
                    <span class="red-text text-darken-2"><b>Used </b></span><span class="right"><?php echo conv($size['SUM(size)']) ?> <i class="grey-text" style="font-size: 11px;">(<?php echo $size['SUM(size)'];?> byte)</i></span>
                  </div>
                </div>
              </div>
                          
          </div>
          <div class="col-l15" style="margin-bottom: 60px; ">
          	
          	<div class="card circul-x2 full-on-s" style="width: 100%; margin-top:20px !important; height: auto; margin: 20px 10px 0px 10px ; min-height: 200px; background: rgba(255,255,255,0.6)" >
               <div class="card-head">Edit Profile</div>
               <div class="card-item">
                 <form method="post" enctype="multipart/form-data">
                 	<div class="row">
                     <div class="col-l20" style="padding-top: 15px;">
                     	<center>
                     	<img src="<?php echo $pro_pic_path ?>" id="c_pic" class="circul " style="height: 100px; width: 100px; border: 2px solid #f7f7f7">
                     	</center>
                     </div>
                     <div class="col-l20" style="">
                     	<center>
                     		<input type="button" value="Select" id='select_img' class="btn-s blue lighten-4 white-text"/>
                     		<input type="file" id="img" name="img" style="display: none;"  />
                 		</center>
                   </div>
                   <div class="row">
                     <div class="col-l4" style="padding-top: 15px;">First name</div>
                     <div class="col-l16 "><input type="text" name="fname" class="input-text" value="<?php echo $reg_row['first_name']; ?>"></div>
                   </div>
                   <div class="row">
                     <div class="col-l4" style="padding-top: 15px;">Last name</div>
                     <div class="col-l16 "><input type="text" name="lname" class="input-text" value="<?php echo $reg_row['last_name']; ?>"></div>
                   </div>
                   <div class="row">
                     <div class="col-l4" style="padding-top: 15px;">Username</div>
                     <div class="col-l16 "><input type="text" name="username" class="input-text" value="<?php echo $log_row['username']; ?>"></div>
                   </div>
                   <div class="row">
                     <div class="col-l4" style="padding-top: 15px;">Birth date</div>
                     <div class="col-l16 ">
                        <input type="date" name="dob" class="input-text" id="dob" value="<?php echo date('Y-m-d',$reg_row['Dob']);?>" />
                    </div>
                   </div>
                   <div class="row">
                     <div class="col-l4" style="padding-top: 15px;">Email Id</div>
                     <div class="col-l16 "><input type="text" name="email" class="input-text" value="<?php echo $log_row['email']; ?>"></div>
                   </div>
                   <div class="row">
                     <div class="col-l4" style="padding-top: 15px;">Phone number</div>
                     <div class="col-l16 "><input type="text" value="<?php echo $reg_row['phone_num']; ?>" name="number" class="input-text" value=""></div>
                   </div>
                   <div class="row">
                     <div class="col-l20" style="padding-top: 15px;padding-bottom: 10px;"><input type="submit" class="blue white-text btn-s" name="save" value="Save"/></div>
                   </div>
                   <?php echo $error ?>
                 </form>
               </div>             
          </div>
        </div>        
      </div>

      
    </body>
    
    <script type="text/javascript">
      
      $('#select_img').click(function(){
      	$("#img").trigger('click');
      });

     
    </script>
    </html>