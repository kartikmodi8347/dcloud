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
          title: 'My Daily Activities'
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

      <div class="with-fix">
        <div class="row" style="margin-left:2%; ">
          <div class="col-l4">
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

              <div class="card d-depth-2 white" style="width: 100%; ">
                <div class="card-item">
                  <?php include 'filesize.php'; ?>
                </div>
              </div>
          </div>
          <div class="col-l15" style="margin-bottom: 60px; ">
          	
          	
          	<div class="card circul-x2 full-on-s" style="width: 100%; margin-top:20px !important; height: auto; margin: 20px 10px 0px 10px ; min-height: 200px; background: rgba(255,255,255,0.6)" >
              <div class="card-head">Groups</div>
              <center>
              	<a href="create_grp.php">
                <button class="btn-l grey-blue grey-text text-darken-2" style="width: 98%;"><span class="fa fa-group"></span> Create Group</button>
            </a>
              </center>
              <div style="padding: 15px; overflow-x: auto;">

             <?php include'group_list.php';?>
           
              <!--  <?php 
                $g_admin = mysqli_query($con,"SELECT * FROM `group_admin` WHERE WHERE `admin_id`='$user' ");
                $admin_num 	= mysqli_num_rows($g_admin);
                if ($admin_num > 0)
                {
                    while($gadmin_data = mysqli_fetch_assoc($g_admin))
                    {
                        $grp_ids = mysql_real_escape_string($gadmin_data['group_id']);
                        $my_group = mysqli_query($con,"SELECT * FROM `group` WHERE `group_id`='$grp_ids' ");
                        $myg_data = mysqli_fetch_assoc($my_group);

                        echo  $myg_data['group_name'];
                    }
                }
              ?> -->
             </div>
          	
          </div>
        </div>        
      </div>
      
      
    </body>

    <script type="text/javascript">
      $(document).ready(function ($) {
        $(".link-row").click(function(){
          window.location = $(this).data("href");
        });      
      });
    </script>

    
    </html>