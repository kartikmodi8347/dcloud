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
	if (isset($_GET['sid']))
	{
		$sid = $_GET['sid'];
		$chk = mysqli_query($con,"SELECT share_type FROM share_privacy WHERE share_id='$sid' AND share_type='Public'");
		$chk_row = mysqli_num_rows($chk);
		if ($chk_row == 0)
		{
			$error = "<div class='red white-text' style='padding:20px 0 20px 0; text-align:center;'>Incurrrect shared id</div>";
		}
		else
		{
			$error ="";
		}


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
					<div class="card-head">Public shared link</div>   
					<div>
						<div style="border: 1px solid #f7f7f7; border-radius: 8px;" id="pass">
							<?php
							if($error == "")
							{
							?>
										<div style="padding: 10px; font-size: 14px; color: #999">
											<b style="color: #333; line-height: 35px;">What is Public shared link ?</b>

											<p>Public shared link is a one type of link that you can share this link of your publicly shared documents, and user can visit this link and access the documents.</p>				
										</div>
										<div style="padding: 10px; font-size: 14px;">
											<b style="color: #333; line-height: 35px;">Share this link :</b>
											<a target="blank" class="blue-text" href="share_view/0/<?php echo $sid;?>">https://localhost/dclud/user/share_view/0/<?php echo $sid;?></a>
										</div>
									</div>
							<?php 
							}
							else
							{
								echo $error;
							} 
							?>				
					</div>       			
                </div>
            </div>
        </div>
        
</body>
</html>
