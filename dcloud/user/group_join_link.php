<!DOCTYPE html>
<html>
    <title>Shared Files | D Cloud</title>
    <head>
    <?php require_once 'require.php'; ?>

    <style type="text/css">
        body{
            /*background-image: url(../img/pexels-photo-14675.jpeg);
            background-size: cover;*/ 
        }
        .link-row:hover {
          background-color: #f7f7f7;
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

    <body> 
    <!-- For mobile -->

    <?php require_once("mobile_option.php"); ?>


    <!-- Header -->
    <?php require_once("header.php"); ?>

      <?php
        if (isset($_GET['grp_id']))
        {
            $q = mysqli_query($con,"SELECT * FROM `group` WHERE `group_id`='$_GET[grp_id]' ");
            $row_num = mysqli_num_rows($q);
            if ($row_num > 0)
            {
              $row = mysqli_fetch_assoc($q);
              if ($row['group_type']=='private')
              {
                echo'<meta http-equiv="refresh" content="0;url=home.php/"/>';
              }
            }
            else
            {
                echo'<meta http-equiv="refresh" content="0;url=home.php/"/>'; 
            }          
        }
        else
        {
          echo'<meta http-equiv="refresh" content="0;url=home.php/"/>';
        }
      ?> 
        <!-- Group img -->
       <?php
        if(!empty($row['grp_img']))
        {
          $grp_img='grp_pic/'.$row['grp_img'];
        }
        else
        {
          $grp_img='grp_pic/groups.png';          
        }
        ?>
     <div class="container with-fix">
        <center>
        <div class="card depth-2" class="full-on-s" style="margin-top: 15%; width: 300px; padding: 8px;">
          <table style="border: 0px;">
            <tr>
              <td style="width: 80px; height: 80px;"><img src="<?php echo $grp_img;?>" class="circul" style="height: 80px; width: 80px;" /></td>
              <td>
                <p style="font-size: 18px; color: #333;"><?php echo $row['name']; ?></p>
                <p style="font-size: 12px; color: #ccc;"><?php echo $row['decs']; ?></p>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <span style="font-size: 14px; color: #ccc;">Share this link for joining the group</span>
                <a style="font-size: 14px; color: #333; font-weight: bold;" href="join_group/<?php echo $_GET['grp_id']; ?>">http://documentcloud.ml/user/join_group/<?php echo $_GET['grp_id']; ?></a></td>
            </tr>
          </table>
          
        </div>
        </center>
      </div>
      
      
    </body>

    </html>