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
<?php require_once("mobile_option.php"); ?>
<?php require_once("header.php"); ?>
<div class="container with-fix">
       <div class="row">
        	<div class="col-l20">
          		<div class="card d-depth-2 circul-x1 full-on-l full-on-s" style="margin-top: 40px !important; ">
					<div class="card-head">Select  Groups</div>   
					<div>
						<form method="POST">
							
							<div style="margin:3%; width:94%;  border-bottom:1px solid #ccc; line-height:35px;"><b>Select Sharing Type</b></div>
							<div style="margin:3%; width:92%;">
							<div class="row">
								<textarea placeholder="Type a message" name="msg"></textarea>
							</div>

							</div>

							<div style="margin:3%; width:94%;  border-bottom:1px solid #ccc; line-height:35px;">
								<b>Select Group</b>
							</div>
							<center>
								<div style="width:95%">
									<table class="row-border">
						<?php
						
						$error = '';
						if ($error == '')
						{
							
			                $u_group_q = mysqli_query($con,"SELECT * FROM group_admin WHERE admin_id=$user ");
			                $g_num = mysqli_num_rows($u_group_q);
			                if($g_num > 0)
			                {
			                  echo'<table width="100%" style="font-size: 14px;">';
			                  while ($mygroup = mysqli_fetch_assoc($u_group_q)) 
			                  {
			                  	$grp = mysql_real_escape_string($mygroup['group_id']);
			                  	$my_g = mysqli_query($con,"SELECT * FROM `group` WHERE group_id='$grp' AND status='Live' ");
			                  	$your_g = mysqli_fetch_assoc($my_g);
			                      
			                      echo '<tr class="link-row" data-href="group/'.$your_g['group_id'].'">';
			                        echo'<td style="width:80px; text-align:center;"><span class="fa fa-group"></span></td>';
			                        echo'<td>'.$your_g['name'].'</td>';
			                        echo'<td style="width:80px; text-align:center;">';?><input type="checkbox" name="admin_grp[]" value="<?php echo $mygroup['group_id']; ?>"><?php echo'</td>';
			                      echo'</tr>';
			                      
			                  }
			                  echo'</table>';
			                  $group_admin_s = 1;
 			                }
			                else
			                {
			                  $group_admin_s = 0;
			                }

			                $m_group_q = mysqli_query($con,"SELECT * FROM group_member WHERE member_id=$user ");
			                $gm_num = mysqli_num_rows($m_group_q);
			                if($gm_num > 0)
			                {
			                  echo'<table width="100%" style="font-size: 14px;">';
			                  while ($yougroup = mysqli_fetch_assoc($m_group_q)) 
			                  {
			                  	$grp = mysql_real_escape_string($yougroup['group_id']);
			                  	$my_g1 = mysqli_query($con,"SELECT * FROM `group` WHERE group_id='$grp' AND status='Live'");
			                  	$your_g1 = mysqli_fetch_assoc($my_g1);
			                      
			                      echo '<tr class="link-row" data-href="group/'.$your_g1['group_id'].'">';
			                        echo'<td style="width:80px; text-align:center;"><span class="fa fa-group"></span></td>';
			                        echo'<td>'.$your_g1['name'].'</td>';
			                        echo'<td style="width:80px; text-align:center;">';?><input type="checkbox" name="admin_grp[]" value="<?php echo $yougroup['group_id']; ?>"><?php echo'</td>';
			                      echo'</tr>';
			                      
			                  }
			                  echo'</table>';
			                  $member_grp = 1;
			                }
			                else
			                {
			                  $member_grp = 0;
			                } 
			                if(($member_grp==0) AND ($group_admin_s==0))
			                {
			                	echo '<div class="blue lighten-5" style="line-height: 35px; text-align: center;font-size: 14px;">No group</div>';	
			                }
			               
			             
	
			                			$time =time();
			                			if (isset($_POST['msg'])) 
			                			{
			                				$message =  $_POST['msg'];
			                			}
			                			else
			                			{
			                				$message='';
			                			}	                			}
			                			
			                			if (isset($_GET['share_id']))
			                			{
			                				$chk = mysqli_query($con,"SELECT * FROM docfile_share WHERE share_id='$_GET[share_id]' AND id='$user' AND share_type='Group' ");
			                				$chk_row = mysqli_num_rows($chk);
			                				if ($chk_row > 0)
			                				{
			                					$share_id = $_GET['share_id'];
			                				}
			                			}
			                			$share_id = $_GET['share_id'];

										if(!empty($_POST['admin_grp']))
										{
											$file_num = 0;
											//$i = 0; 
												foreach ($_POST['admin_grp'] as $admin_grp) 
												{
													//$select_df[$i] = $doc_files;
													$files=mysqli_query($con,"INSERT INTO group_share (group_id,sender_id,share_id,message,time) VALUES ('$admin_grp','$user','$share_id','$message',$time)");
													//$i++;
												}	
										}
							
							else
							{
								
							}
							if(isset($files))
							{
								header("Location:groups.php");
							}

						
						?>
										</table>
									</div>
								<input type="submit" class="btn-s blue white-text" value="Next >" style="margin-bottom:20px";/>
							</center>
						</form>					
					</div>       			
                </div>
            </div>
        </div>
</body>
</html>



