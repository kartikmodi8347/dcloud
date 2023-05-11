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
	<?php include("header.php"); ?>
     <?php 
     require_once '../config.php';

     function get_file($type)
        {
            global $con;
            $size=0;
            if($type=='image' || $type=='ms' || $type=='extrected' || $type=='pdf' || $type=='other')
            {
                    if ($type == 'image')
                    {
                        $qu = mysqli_query($con,"SELECT * FROM docfile WHERE doc_type='image/png' || doc_type='image/jpg' || doc_type='image/jpeg' || doc_type='image/gif' || doc_type='image/svg' || doc_type='image/ico' || doc_type='image/png' || doc_type='image/bmp' || doc_type='image/ai' ");
                        $data = mysqli_num_rows($qu);
                            $size = $data;
                    }
                    if ($type == 'ms')
                    {
                        $qu = mysqli_query($con,"SELECT * FROM docfile WHERE doc_type='application/vnd.openxmlformats-officedocument.wordprocessingml.document' || doc_type='application/msaccess' || doc_type='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || doc_type='application/vnd.openxmlformats-officedocument.presentationml.presentation' || doc_type='application/vnd.ms-publisher' ");
                        $data = mysqli_num_rows($qu);
                            $size = $data;
                    }
                    if ($type == 'pdf')
                    {
                        $qu = mysqli_query($con,"SELECT * FROM docfile WHERE doc_type='application/pdf' ");
                        $data = mysqli_num_rows($qu);
                            $size = $data;
                    }
                    if ($type == 'extrected')
                    {
                        $qu = mysqli_query($con,"SELECT * FROM docfile WHERE doc_type='application/x-zip-compressed'  || doc_type='application/octet-stream' ");
                        $data = mysqli_num_rows($qu);
                            $size = $data;
                    }
                    if ($type == 'other')
                    {
                        $qu = mysqli_query($con,"SELECT * FROM docfile WHERE doc_type='text/plain' ");
                        $data = mysqli_num_rows($qu);
                            $size = $data;
                        
                    }
            }
            
            return $size;
        }
 function size($type)
        {
            global $con;
            $size=0;
            if($type=='image' || $type=='ms' || $type=='extrected' || $type=='pdf' || $type=='other')
            {
                    if ($type == 'image')
                    {
                        $qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='image/png' || doc_type='image/jpg' || doc_type='image/jpeg' || doc_type='image/gif' || doc_type='image/svg' || doc_type='image/ico' || doc_type='image/png' || doc_type='image/bmp' || doc_type='image/ai' ");
                        $data = mysqli_fetch_assoc($qu);
                            $size = $data['SUM(size)'];
                    }
                    if ($type == 'ms')
                    {
                        $qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='application/vnd.openxmlformats-officedocument.wordprocessingml.document' || doc_type='application/msaccess' || doc_type='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || doc_type='application/vnd.openxmlformats-officedocument.presentationml.presentation' || doc_type='application/vnd.ms-publisher' ");
                        $data = mysqli_fetch_assoc($qu);
                            $size = $data['SUM(size)'];
                    }
                    if ($type == 'pdf')
                    {
                        $qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='application/pdf' ");
                        $data = mysqli_fetch_assoc($qu);
                            $size = $data['SUM(size)'];
                    }
                    if ($type == 'extrected')
                    {
                        $qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='application/x-zip-compressed'  || doc_type='application/octet-stream' ");
                        $data = mysqli_fetch_assoc($qu);
                            $size = $data['SUM(size)'];
                    }
                    if ($type == 'other')
                    {
                        $qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='text/plain' ");
                        $data = mysqli_fetch_assoc($qu);
                            $size = $data['SUM(size)'];
                        
                    }
            }
            else
            {
                $qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='$type' ");
                        $data = mysqli_fetch_assoc($qu);
                            $size = $data['SUM(size)'];
            }
            return $size;
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
                <?php
                require_once '../user/size_conv.php';
                $login_i = mysqli_query($con,"SELECT * FROM login_user WHERE role='User' ");
                $user_num = mysqli_num_rows($login_i);
                if ($user_num == 0) {$user_num = 0;}

                $stored = mysqli_query($con,"SELECT SUM(size) FROM docfile");
                $stored_size = mysqli_fetch_assoc($stored);

                $avilable = avilable($stored_size['SUM(size)']);
                ?>
						<div class="row">         
                        <div class="col-l5 col-s10">
                            <div class="card red dash-card">
                                <div class="card-text-view">
                                    <p style="padding:0 0 10px 0; font-weight: bold;">TOTAL STORAGE USERS</p>
                                    <p><h1><?php echo $user_num; ?></h1></p>
                                </div>
                                <div class="icon"><span class="fa fa-user"></span></div>
                            </div>
                        </div>
                        <div class="col-l5 col-s10">
                            <div class="card orange dash-card">
                                <div class="card-text-view">
                                    <p style="padding:0 0 10px 0; font-weight: bold;">ALLOCATED STORAGE</p>
                                    <p><h1><?php echo $user_num.'GB' ?></h1></p>
                                </div>
                                <div class="icon"><span class="fa fa-server"></span></div>
                            </div>
                        </div>
                        <div class="col-l5 col-s10">
                            <div class="card blue dash-card">
                                <div class="card-text-view">
                                    <p style="padding:0 0 10px 0; font-weight: bold;">USED SPACE</p>
                                    <p><h1><?php echo conv($stored_size['SUM(size)']); ?></h1></p>
                                </div>
                                <div class="icon"><span class="fa fa-upload"></span></div>
                            </div>
                        </div>
                        <div class="col-l5 col-s10">
                            <div class="card green dash-card">
                                <div class="card-text-view">
                                    <p style="padding:0 0 10px 0; font-weight: bold;">FREE SPACE</p>
                                    <p><h1><?php echo conv($avilable); ?></h1></p>
                                </div>
                                <div class="icon"><span class="fa fa-download"></span></div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                  <div class="col-l20">
                    <table style="margin-top:40px" class="simple-table full-on-l" style="width: 100%;">
                      <tr>
                        <th align="left" align="left">File</th>
                        <th width="100px" align="center">Total files</th>
                        <th width="100px" align="center">Size</th>
                      </tr>
                      <tr>
                        <td>Image</td>
                        <td align="center"><?php if(get_file('image')) echo get_file('image'); else echo 0;?></td>
                        <td align="center"><?php if(size('image')) echo conv(size('image')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>PDF</td>
                        <td align="center"><?php if(get_file('pdf')) echo get_file('pdf'); else echo 0;?></td>
                        <td align="center"><?php if(size('pdf')) echo conv(size('application/pdf')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>Microsoft office file</td>
                        <td align="center"><?php if(get_file('ms')) echo get_file('ms'); else echo 0;?></td>
                        <td align="center"><?php if(size('ms')) echo conv(size('ms')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>ZIP / RAR</td>
                        <td align="center"><?php if(get_file('extrected')) echo get_file('extrected'); else echo 0;?></td>
                        <td align="center"><?php if(size('extrected')) echo conv(size('extrected')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>Other Files</td>
                        <td align="center"><?php if(get_file('other')) echo get_file('other'); else echo 0;?></td>
                        <td align="center"><?php if(size('other')) echo conv(size('other')); else echo 0;?></td>
                      </tr>
                    </table>
                  </div>
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
    	/*$('#datas').load("manage_user_backend.php");*/
    	$(document).ready(function(){
    		load_data();
    	});
    	
    	function load_data()
    	{	
    		var readrecord = "readrecord";
    		$.ajax({
    			url:"mng_grp_back.php",
    			type:"POST",
    			data:{ readrecord: 'readrecord' },
    			success:function (data,status) {
    				$('#datas').html(data);
    			}
    		});
    	}

    		function block(uid)
    		{
				$.ajax({
    			url:"mng_grp_back.php",
    			type:"POST",
    			data:{ grp_id_b:uid},
    			success:function (data,status) {
    				load_data();
    			}
    		});    			
    		}
    	
    		function unblock(uid)
    		{
				$.ajax({
    			url:"mng_grp_back.php",
    			type:"POST",
    			data:{ grp_id_ub:uid},
    			success:function (data,status) {
    				load_data();
    			}
    		});    			
    		}

    		function deleteg(uid)
    		{

				$.ajax({
    			url:"mng_grp_back.php",
    			type:"POST",
    			data:{ grp_id_delete:uid },
    			success:function (data,status) {
    				
    				load_data();
    			}
    		});    			
    		}
    </script>
</html>