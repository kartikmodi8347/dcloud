<!DOCTYPE html>
<html>
    <title>Home | D Cloud</title>
    <head>

    <?php require_once 'require.php'; ?>

    <style type="text/css">
        body{
            /*background-image: url(../img/pexels-photo-14675.jpeg);
            background-size: cover;*/ 
        }
        .div {
          width: 100%;
          height: 100%;
          background: rgba(0,0,0,0.4);
          position: fixed;
         
          display: none;
          left: 0;
          top: 0;
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

          <!-- Create directory -->
          <?php 
      	  require_once("create_dir.php");

	      if (isset($_POST['creat_d']))
	      {
	      	$dir_path = $user;
	      	$dir_n = $_POST['dir_name'];

	      	if (file_exists('../data/'.$dir_path))
	      	{
	      		 create_dir($dir_n,$user,$dir_path,'root');
	      	}
	      	else
	  		{
	  			mkdir('../data/'.$dir_path);
	  		}    		
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

    <body><!-- blue-grey lighten-5 background-image: linear-gradient(to left bottom, #188ea6, #137d93, #0f6d80, #0b5d6e, #074e5c);--> 
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
          	<div class="card circul-x2 full-on-s" style="background: rgba(0,0,0,0.1);  width: 100%; margin: 20px 10px 0px 10px; margin-top:20px !important; height: auto;" >
          		<div class="row">
          			<div class="col-l15">
          				<div class="card white circul-x2 depth-0 full-on-s" style="width: 100%; margin: 8px">
          					<input type="text" name="" id="search" style="border:none;background: unset; width: 100%; height: 35px; padding-left: 8px;" placeholder="Search Folders"> 
          				</div>
          			</div>
          			<div class="col-l5">
          				<div>
          					<button class="blue white-text btn-s right full-on-s" onclick="return show('tab')" id="create_dir" style="margin-bottom: 8px; margin-right: 8px; width: auto;"><span class="fa fa-folder"></span> New Folder</button>
          				</div>
          			</div>
          		</div>
          	</div>
          	<?php
          	if($dir_error!='')
          	 {
          	 	echo "<div class='card full-on-s red white-text' style='width: 100%; margin-top:20px !important; height: auto; margin: 20px 10px 0px 10px; font-size:14px;' >";
          	 	echo "<p style='padding:8px'>".$dir_error."</p>";
          	 	echo "</div>";
          	 }
          	 ?>
          	<div class="card circul-x2 full-on-s" style="width: 100%; margin-top:20px !important; height: auto; margin: 20px 10px 0px 10px ; min-height: 200px; background: rgba(255,255,255,0.6)" id="result">
          		
           			<?php

	 	 			$root_dir =mysqli_query($con,"SELECT * FROM directory WHERE id='$user' && status='root' ");
	 	 			$root_num = mysqli_num_rows($root_dir);
          require_once("root_dir_upload.php");

	 	 			if ($root_num > 0)
	 	 			{
	 	 				echo '<div style="height:55px; width:100%; text-align:right; border-bottom:1px solid #f4f4f4;">
            <button class="blue lighten-2 white-text btn-s" id="upload" style="margin-bottom: 4px; margin-right: 4px; width: auto;"><span class="fa fa-file"></span> Upload</button>
	 	 				<a href="root_delete.php"><button class="grey-blue grey-text text-darken-2 btn-s"><span class="fa fa-folder"></span>&nbsp;Delete</button></a> 
	 	 				<a href="root_share.php"><button class="grey-blue grey-text text-darken-2 btn-s" style="margin-right:8px;"><span class="fa fa-share"></span>&nbsp;Share</button></div></a>';
	 	 			while ($root = mysqli_fetch_assoc($root_dir)) {
	 	 				echo'
	 	 				<div class="card depth-0" style="width: 85px;">
	 	 					<div class="card-item" style="margin:4px">
		          				<center>
		          					<a href="file_area/'.$root['dir_id'].'">
		          					<img src="../img/folder.png" style="margin-left:16px"/>
		          					<div style="width: 85px;" class="truncate">'.$root['dir_name'].'</div>
		          					</a>
		          				</center>
          					</div>
          				</div>';
	 	 				}

	 	 			}
	 	 			else	
	 	 			{
	 	 				echo'
	 	 				<center>
	 	 				<div class="card-item" style="margin-top:100px;margin-bottom:100px">
	 	 						<p class="grey-text text-darken-2">Create your folder and store your documents</p>
	 	 						<button class="grey-blue grey-text text-darken-2 btn-s" id="create_dir1" style="width: 100px;" ><span class="fa fa-folder"></span> New Folder</button>
	 	 				</div>
	 	 				</center>';
	 	 			}


          $doc = mysqli_query($con,"SELECT * FROM docfile WHERE dir_id='$user' ");

                    $img_ex = array('image/png','image/jpeg','image/jpg','image/gif','image/svg','image/ico','image/bmp','image/ico','image/bmp','image/ai');

                    while ($doc_row = mysqli_fetch_assoc($doc)) 
                    {
                      
                         echo'
                        <div class="card depth-0" style="width: 85px;">
                          <div class="card-item" style="margin:4px">
                            <center> 
                              <a target="blank" href="../data/'.$user.'/'.$doc_row['doc_path'].'">';
                              if(in_array($doc_row['doc_type'],$img_ex))
                              {
                                echo'
                                <img src="../data/'.$user.'/'.$doc_row['doc_path'].'" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/x-zip-compressed')
                              {
                                echo'
                                <img src="../img/6.zip.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';

                              }
                              if($doc_row['doc_type'] == 'application/octet-stream')
                              {
                                echo'
                                <img src="../img/7.rar.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/pdf')
                              {
                                echo'
                                <img src="../img/8.pdf.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                              {
                                echo'
                                <img src="../img/3.word.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/msaccess')
                              {
                                echo'
                                <img src="../img/1.access.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                              {
                                echo'
                                <img src="../img/5.Excel.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/vnd.openxmlformats-officedocument.presentationml.presentation')
                              {
                                echo'
                                <img src="../img/4.Powerpoint.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/vnd.ms-publisher')
                              {
                                echo'
                                <img src="../img/2.publisher.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                          echo'</a>
                            </center>
                          </div>
                        </div>';
                    
                    }


          			 ?>
          			
          			
          	
          </div>
        </div>        
      </div>
       <form method="post" enctype="multipart/form-data">
                  <input type="file" id="file" name="file[]" style="display:none" onchange="this.form.submit();" multiple/>
                </form>
      <!-- create folder popup manu-->
      <div class="div">
        <div class="container">
            <center>
            <div class="full-on-s circul-x1 white card" style="width: 400px; height: 200px; margin-top:100px !important; display: block;">
              <div class="card-head">Create folder</div>
              <div class="card-item" style="padding-bottom: 40px;">
                <form method="post" onsubmit="ck()">
                  <span class="item-head left">Enter Folder name :</span>
                  <input type="text" class="input-text" id="dirname" name="dir_name" required />
                
                  <input type="submit" value="Create" name="creat_d" id="creat_d" class="btn-s left blue white-text"/>&nbsp;<input type="button" value="Cancel" id="cencel_d" class="btn-s left blue white-text"/>
                </form>
                <!-- <p class="right grey-text" style="line-height: 28px; padding-bottom: 80px; "><b>Note :</b> Folder name are must be start with 0-9 , a-z or A-Z</p> -->
              </div>
            </div>
            </center>
        </div>
      </div>

      
    </body>
    
    <script type="text/javascript">
      $("#create_dir").click(function () {
        $(".div").css("display","block");
      });
      $("#create_dir1").click(function () {
        $(".div").css("display","block");
      });
      $("#cencel_d").click(function () {
        $(".div").css("display","none");
      });
       $("#upload").click(function(){
        $("#file").trigger('click');
      });
      var re = '/^[a-zA-Z1-0].*$/';

     	function clicked(){
     		var name = $("#dirname").val();
      		return name.test(/^[a-z0-9_-\s]+$/gi);
      		alert(name);
     }; 	
      	
      	
     $(document).ready(function () {
        $("#search").keyup(function () {
          var search = $("#search").val();
          if($.trim(search.length) == 0)
          {
            /*  $("#result").html('Please enter searching keyword');*/
          }
          else
          {
            $.ajax({
          url: 'folder_search.php',
          type: 'POST',
          data:{'search':search},

          success: function(data,status){
            $('#result').html(data);
          }
        });
            
          }
        })
      });

      
    </script>
    
    </html>