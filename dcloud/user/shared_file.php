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

            /*$stor = mysqli_query($con,"SELECT used FROM storage WHERE id=$user");
            $size = mysqli_fetch_assoc($stor);*/
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
          title: 'My Daily Activities'
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
              <div class="card-head">Shared Files</div>
              <div style="padding: 15px; overflow-x: auto;">
              <table width="100%" style="font-size: 14px;">
                <tr>
                  <th>Title</th>
                  <th width="100">Sharing</th>
                  <th width="100">Protection</th>
                  <th width="150">Date-Time</th>
                </tr>
                <?php 
                $shared_q = mysqli_query($con,"SELECT * FROM share_privacy WHERE id='$user' ");
                $s_num = mysqli_num_rows($shared_q);
                if($s_num > 0)
                {
                  while ($shared_row = mysqli_fetch_assoc($shared_q)) 
                  {
                      
                      echo '<tr class="link-row" data-href="share_view/0/'.$shared_row['share_id'].'">';
                        echo'<td>'.$shared_row['share_title'].'</td>';
                        echo'<td>'.$shared_row['share_type'].'</td>';
                        echo'<td>'.$shared_row['privacy'].'</td>';
                        echo'<td>'.date('d M Y h:i a',$shared_row['time']).'</td>';
                      echo'</tr>';
                      
                  }
                }
                else
                {
                  echo '<div class="blue lighten-5" style="line-height: 35px; text-align: center;font-size: 14px;">You have not shared file yet</div>';
                } 
                ?>
                
              </table>
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