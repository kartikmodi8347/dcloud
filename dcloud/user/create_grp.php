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

          <!-- Google Chart API ---->
          <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
          <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

              var data = google.visualization.arrayToDataTable([
                ['Effort', 'Amount given'],
                ['Avilable', <?php echo $avilable; ?>],
                ['Used', <?php echo $size['SUM[size]']; ?>]
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

    <body > 
    <!-- For mobile -->

    <?php require_once("mobile_option.php"); ?>


    <!-- Header -->
    <?php require_once("header.php"); ?>

      <div class="container with-fix">
        <div class="row">
          <div class="col-l5">
              <div class="card d-depth-2 white" style="width: 100%; margin-top: 20px; border-radius: 4px 4px 0 0;">
                <div class="blue lighten-1" style="height: 80px;border-radius: 4px 4px 0 0; width: 100%;"></div>
                <center>
                  <img src="<?php echo $pro_pic_path; ?>" style="height: 60px; width: 60px; margin-top: -30px; background: #FFF; border:1px solid #f7f7f7;" class="circul d-depth-1">
                  <div style="line-height: 25px; font-size: 14px; color: #333"><b><?php echo $reg_row['first_name'].' '.$reg_row['last_name']; ?></b></div>

                  

                </center>
              </div>
              <?php include 'left_manu.php'; ?>
              
              <div class="card d-depth-2 white" style="width: 100%; margin-top: 20px;">
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
              <div class="card-head">Create A New Group</div>
              
              <div style="padding: 15px; overflow-x: auto;">
                <form method="post" id="form" enctype="multipart/form-data">

                <input type="text" class="input-text" name="grp_name" placeholder="Group Name" required s/>
                <p style="font-size: 12px; margin-top: 20px; color: #999">&nbsp;Description</p>
                <textarea id="dec" name="desc" style="width: 96%; height: 80px; border-bottom-color:#ccc !important; border: 1px solid #f4f4f4;"></textarea>
                <p><span id="charnum" style="font-size: 12px; width: 96%;"></span></p>
                <p style="font-size: 12px; margin-top: 20px; color: #999">&nbsp;Select group image</p>
                <input type="button" value="Select" id='select_img' class="btn-s blue lighten-4 white-text"/>
                        <input type="file" id="img" name="img" style="display: none;"  />

                <br><br><br><br>
                <p style="line-height: 45px; font-size: 14px;">
                  &nbsp;Group Type :
                  <span style="color: #999">&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="type" checked="checked" id="type1" value="private" /> Private
                  &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="type" id="type2" value="public" /> Public</span>
                </p>

                <div style="border: 1px solid #f7f7f7; border-radius: 8px; display: block;" id="private">
                    <div style="padding: 10px; font-size: 14px; color: #999">
                    What is private group ?
                    : only admin can allow to add a group members on private group
                    </div>
                </div>
                <div style="border: 1px solid #f7f7f7; border-radius: 8px; display:none;" id="public">
                    <div style="padding: 10px; font-size: 14px; color: #999">
                    What is public group ?
                    : admin can ganarate a group joining invitation link, and user can join a group via link 
                    </div>
                </div>

                <p style="line-height: 45px; font-size: 14px;">
                  &nbsp;Allow Sharing :
                  <span style="color: #999">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="sa" id="admin" value="admin" /> Only Admin
                  &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sa" checked="checked" id="both" value="both" /> Both Admin And Member</span>
                </p>

                <div style="border: 1px solid #f7f7f7; border-radius: 8px; display: none;" id="adminmsg">
                    <div style="padding: 10px; font-size: 14px; color: #999">
                    Only admin can share a documents on group
                    </div>
                </div>
                <div style="border: 1px solid #f7f7f7; border-radius: 8px; display:block;" id="bothmsg">
                    <div style="padding: 10px; font-size: 14px; color: #999">
                    Admin and member both can share a documents on group
                    </div>
                </div>
                <br>
                <input type="submit" name="b" class="btn-s blue white-text" value="Create">

                </form>
             </div>
          	
          </div>
        </div>        
      </div>
      
      <?php 
      if(isset($_POST['b']))
      {
        $name = htmlentities($_POST['grp_name']);
        $dec = htmlentities($_POST['desc']);
        $type = $_POST['type'];
        $sa = $_POST['sa'];

        $grp_id = time().rand(0,9);
        $time = time();

         if($_FILES['img']['name'] !== '')
            {
            $propic = $_FILES['img']['name'];
            $propic_type=$_FILES['img']['type'];
            $propic_tmp =$_FILES['img']['tmp_name'];
            $propic_size = $_FILES['img']['size'];

                if($propic_type == 'image/png' || $propic_type == 'image/jpg' || $propic_type == 'image/jpeg')
                {
                  if ($propic_size > 0)
                  {
                      $file_name = rand(0,100).$propic;
                      move_uploaded_file($propic_tmp,'grp_pic/'.$file_name);
                      $create = mysqli_query($con,"INSERT INTO `group`(`id`, `group_id`, `name`, `decs`, `group_type`, `share_allow`,`grp_img`, `time`) VALUES ('$user','$grp_id','$name','$dec','$type','$sa','$file_name',$time)");
                      $admin = mysqli_query($con,"INSERT INTO group_admin (group_id,admin_id,time) VALUES ('$grp_id','$user','$time')");
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
            else
            {
               $create = mysqli_query($con,"INSERT INTO `group`(`id`, `group_id`, `name`, `decs`, `group_type`, `share_allow`, `time`) VALUES ('$user','$grp_id','$name','$dec','$type','$sa',$time)");
                      $admin = mysqli_query($con,"INSERT INTO group_admin (group_id,admin_id,time) VALUES ('$grp_id','$user','$time')");
            }

       
       /* $create2 = mysqli_query($con,"INSERT INTO  group_admin VALUES ('$grp_id','$user','',$time)");
*/
        if($create AND $admin)
        {
          echo '<meta http-equiv="refresh" content="0;url=add_member/'.$grp_id.'"/>';
        }
      }
      ?>
      
    </body>

    <script type="text/javascript">
        $('#select_img').click(function(){
        $("#img").trigger('click');
      });
      $(document).ready(function ($) {
        
        $("#type1").click(function () {
          $("#private").css("display","block");
          $("#public").css("display","none");
        });

        $("#type2").click(function () {
          $("#private").css("display","none");
          $("#public").css("display","block");
        });



        $("#admin").click(function () {
          $("#adminmsg").css("display","block");
          $("#bothmsg").css("display","none");
        });

        $("#both").click(function () {
          $("#adminmsg").css("display","none");
          $("#bothmsg").css("display","block");
        });
      });

      $("#dec").keyup(function(){
        var max = 150;
        var len = $(this).val().length;
        if (len >= max)
        {
          $("#charnum").css('color','red');
          $(this).css('border-bottom-color','red');          
          $("#charnum").text('You have reached the limit');
          $("#form").submit(function(e){
            return false;
          });
        }
        else
        {
          var char = max-len;
          $("#charnum").text(char+' Letter remin');

          $("#charnum").css('color','');
          $(this).css('border-bottom-color','');
        }
      });
    </script>

    
    </html>