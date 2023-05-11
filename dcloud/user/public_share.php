<!DOCTYPE html>
<html>
<head>
	<title></title>

	 <?php require_once 'require.php'; ?>
</head>
<?php
require_once("../config.php");
require_once("dir_info.php");
session_start();
if (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	if (isset($_GET['dir']))
	{
		$dir = $_GET['dir'];
	}

}
else{
	header('location:../index.php');
} 

//directory owner varification

$reg = mysqli_query($con,"SELECT * FROM user_reg WHERE id=$user ");
$reg_row = mysqli_fetch_assoc($reg);
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
<?php require_once("header.php"); ?>
<div class="container with-fix">
       <div class="row">
        	<div class="col-l20">
          		<div class="card d-depth-2 circul-x1 full-on-l full-on-s" style="margin-top: 40px !important; ">
					<div class="card-head">Share Files</div>   
					<div>
						<form method="POST">
							<div style="margin:3%; width:94%;  border-bottom:1px solid #ccc; line-height:35px;"><b>Select Privacy Option</b></div>
							<div style="margin:3%; width:92%;">
							<div class="row">
								<div class="col-l20 col-s20" style="padding:10px; margin-bottom:20px;">
									<input type="radio" value="none" name="sharep" checked="checked"/> None &nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" value="Password" name="sharep"/> Password Protection &nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" value="Time" name="sharep"/> Periodic Time &nbsp;&nbsp;&nbsp;&nbsp;
								</div>
								<div class="col-l20 col-s20" style="padding:10px; margin-bottom:60px;">
									<div style="border: 1px solid #f7f7f7; border-radius: 8px;" id="none">
										<div style="padding: 10px; font-size: 14px; color: #999">
										any protection is not set at this time
										</div>
									</div>

									<div style="border: 1px solid #f7f7f7; border-radius: 8px; display: none;" id="pass">
										<div style="padding: 10px; font-size: 14px; color: #999">
										Set a password for your shared document for denil the unauthorized access				
										</div>
										<div style="padding: 10px;">
											<input type="password" name="password" class="input-text" placeholder="Enter Password"/>
										</div>
									</div>

									<div style="border: 1px solid #f7f7f7; border-radius: 8px; display: none;" id="time">
										<div style="padding: 10px; font-size: 14px; color: #999">
										Set a time period for active the shared document, whenewer your selected time period is comple, shared document is automatically unvisible.
										</div>
										<div style="padding: 10px;">
											<span style="font-size: 14px; color: #333;"><b>Starting time</b></span>
											<input type="date" name="start_date" class="input-text" min="<?php echo date('Y-m-d',time()); ?>" value="<?php echo date('Y-m-d',time()); ?>" />
											<input type="time" name="start_time" class="input-text" value="<?php echo date('H:i',time()); ?>" />
										</div>
										<div style="padding: 10px;">
											<span style="font-size: 14px; color: #333;"><b>Ending time</b></span>
											<input type="date" name="end_date" class="input-text" min="<?php echo date('Y-m-d',time()); ?>" value="<?php echo date('Y-m-d',time()); ?>"/>
											<input type="time" name="end_time" class="input-text" value="<?php echo (date('H',time())+2).':'.date('i',time()); ?>" />
										</div>
									</div>
								</div>
							</div>
							</div>

							<!-- <div style="margin:3%; width:94%;  border-bottom:1px solid #ccc; line-height:35px;">
								<b>Select Files</b>
							</div> -->
							<center>
								<div style="width:95%">
									
								</div>
								<input type="submit" class="btn-s blue white-text" name="save" value="Share Now" style="margin-bottom:20px";/>
							</center>
						</form>					
					</div>       			
                </div>
            </div>
        </div>
        <?php 
        	if(isset($_POST['save']))
        	{
        		if($_POST['sharep']=='none')
        		{
        			$okk = mysqli_query($con,"UPDATE share_privacy SET privacy='none' WHERE share_id='$_GET[sid]' && id='$user' ");
        		}
        		if($_POST['sharep']=='Password')
        		{
        			$real_p = sha1(md5($_POST['password']));
        			$okk = mysqli_query($con,"UPDATE share_privacy SET privacy='Password',password='$real_p' WHERE share_id='$_GET[sid]' && id='$user' ");
        		}
        		if($_POST['sharep']=='Time')
        		{
        			$years = substr($_POST['start_date'],0,4);
        			$months= substr($_POST['start_date'],5,2);
        			$days = substr($_POST['start_date'],8,2);

        			$hours = substr($_POST['start_time'],0,2);
        			$mins = substr($_POST['start_time'],3,2);
        			
        			$start_unix = mktime($hours,$mins,0,$months,$days,$years);

        			$yeare = substr($_POST['end_date'],0,4);
        			$monthe= substr($_POST['end_date'],5,2);
        			$daye = substr($_POST['end_date'],8,2);
        			
        			$houre = substr($_POST['end_time'],0,2);
        			$mine = substr($_POST['end_time'],3,2);
        			
        			$end_unix = mktime($houre,$mine,0,$monthe,$daye,$yeare);
        			$okk = mysqli_query($con,"UPDATE share_privacy SET privacy='Time',starting_time='$start_unix',ending_time='$end_unix' WHERE share_id='$_GET[sid]' && id='$user' ");

        		} 
        		if (isset($okk))
        		{
        			$chk = mysqli_query($con,"SELECT share_type FROM share_privacy WHERE share_id='$_GET[sid]' AND share_type='Public'");
					$chk_row = mysqli_num_rows($chk);
					if ($chk_row == 1)
					{
        				echo '<meta http-equiv="refresh" content="0;url=./share_link/'.$_GET['sid'].'"/>';
        			}
        			else
        			{
        				echo '<meta http-equiv="refresh" content="0;url=./shared_file.php"/>';	
        			}

        		}
        		
        	}
        ?>
</body>
</html>
<script type="text/javascript">
	$("input[name='sharep']").click(function () {
		if($("input[name='sharep']:checked").val() == 'none')
		{
			$("#none").css("display","block");
			$("#pass").css("display","none");
			$("#time").css("display","none");
		}
		if($("input[name='sharep']:checked").val() == 'Password')
		{
			$("#none").css("display","none");
			$("#pass").css("display","block");
			$("#time").css("display","none");
		}
		if($("input[name='sharep']:checked").val() == 'Time')
		{
			$("#none").css("display","none");
			$("#pass").css("display","none");
			$("#time").css("display","block");
		}
	});
</script>
