<!DOCTYPE html>
<html>
    <title>Edit | D Cloud</title>
    <head>
    <?php require_once 'require.php'; ?>

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

              var options1 = {
                title:'Document Storage',
                pieHole: 0.4,
                pieSliceTextStyle: {
                  color: 'black',
                },
                legend: 'none',
                height:400
              };

              var chart1 = new google.visualization.PieChart(document.getElementById('donut_single1'));
              chart1.draw(data, options1);
            }

          </script>
          <script type="text/javascript">
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Files', 'Data'],
              ['Image', <?php if (get_size($user,'image')) echo get_size($user,'image'); else echo 0; ?>],
              ['PDF', <?php if(get_size($user,'pdf')) echo get_size($user,'application/pdf'); else echo 0;?>],
              ['MS office files',<?php if(get_size($user,'ms')) echo get_size($user,'ms'); else echo 0;?>],
              ['ZIP / RAR', <?php if(get_size($user,'extrected')) echo get_size($user,'extrected'); else echo 0;?>],
              ['Other', <?php if(get_size($user,'other')) echo get_size($user,'other'); else echo 0;?>],
            ]);
            /**/
            var options = {
              title: 'Document wise storage',
              pieHole: 0.4,
              height:400
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
          }
        </script>
    </head>

    <body ><!-- blue-grey lighten-5 background-image: linear-gradient(to left bottom, #188ea6, #137d93, #0f6d80, #0b5d6e, #074e5c);--> 
    <!-- For mobile -->
              <div class="option-h x4  grey darken-3  full-on-s full-on-m hide-on-l u-depth-2" style="position: fixed; bottom: -1%; z-index: 2000;">
                     <center>
                      <a href="" style="line-height: 44px; font-size: 16px;"><i class="fa fa-home white-text" ></i></a>
                      <a href="" style="line-height: 44px; font-size: 16px;">
                        <i class="fa fa-cloud-upload white-text" ></i>
                      </a>
                      <a href="" style="line-height: 44px; font-size: 16px;"><i class="fa fa-cloud-download white-text" ></i></a>
                      <a href="" style="line-height: 44px; font-size: 16px;"><i class="fa fa-group white-text"></i></a>
                    </center>
              </div>


    <!-- Header -->
    <?php require_once("header.php"); ?>       
      <div class="with-fix"  style="margin-left:2%; ">

         <div class="card d-depth-2 white" style="width: 99%; margin-top: 20px; border-radius: 4px 4px 0 0;">
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

        <div class="row">
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
                  <a href="fs_setting.php"><i class="fa fa-cloud-download" style="margin-right: 10px"></i>Files and Storage</a>
                 <!--  <a href="grp_setting.php"><i class="fa fa-group" style="margin-right: 10px"></i>Groups Setting</a> -->
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
               <div class="card-head">Files And Storage</div>
               <div class="card-item">
                  <div class="row">
                    <div class="col-l10">
                        <center>
                          <div id="donut_single1" style="width: 100%; height: 100%;"></div>
                        </center>
                        <div style="font-size: 12px; line-height: 25px;">
                          <span class="blue-text text-darken-3"><b>Avilable</b></span><span class="right"><?php echo conv($avilable) ?> <i class="grey-text" style="font-size: 11px;">(<?php echo $avilable;?> byte)</i></span>
                        </div>
                        <div style="font-size: 12px;">
                          <span class="red-text text-darken-2"><b>Used </b></span><span class="right"><?php echo conv($size['SUM(size)']) ?> <i class="grey-text" style="font-size: 11px;">(<?php echo $size['SUM(size)'];?> byte)</i></span>
                        </div>
     
                    </div>
                    <div class="col-l10">
                      <div id="donutchart" style="width: 100%; height: 100%;"></div>
                  </div>
                 
               </div>

               <div class="row">
                  <div class="col-l20">
                    <table style="margin-top:40px" class="simple-table full-on-l" style="width: 100%;">
                      <tr>
                        <th align="left" align="left">File</th>
                        <th width="100px" align="center">Number of files</th>
                        <th width="100px" align="center">Size</th>
                      </tr>
                      <tr>
                        <td>Image</td>
                        <td align="center"><?php if(get_filenum($user,'image')) echo get_filenum($user,'image'); else echo 0;?></td>
                        <td align="center"><?php if(get_size($user,'image')) echo conv(get_size($user,'image')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>PDF</td>
                        <td align="center"><?php if(get_filenum($user,'pdf')) echo get_filenum($user,'pdf'); else echo 0;?></td>
                        <td align="center"><?php if(get_size($user,'pdf')) echo conv(get_size($user,'pdf')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>Microsoft office file</td>
                        <td align="center"><?php if(get_filenum($user,'ms')) echo get_filenum($user,'ms'); else echo 0;?></td>
                        <td align="center"><?php if(get_size($user,'ms')) echo conv(get_size($user,'ms')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>ZIP / RAR</td>
                        <td align="center"><?php if(get_filenum($user,'extrected')) echo get_filenum($user,'extrected'); else echo 0;?></td>
                        <td align="center"><?php if(get_size($user,'extrected')) echo conv(get_size($user,'extrected')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>Other Files</td>
                        <td align="center"><?php if(get_filenum($user,'other')) echo get_filenum($user,'other'); else echo 0;?></td>
                        <td align="center"><?php if(get_size($user,'other')) echo conv(get_size($user,'other')); else echo 0;?></td>
                      </tr>
                    </table>
                  </div>
               </div>             
          </div>
        </div>        
      </div>

      
    </body>
    
    </html>