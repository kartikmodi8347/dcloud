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
					<div class="card-head">Select Group</div>   
					<div>
						
						<form method="POST">

							<div style="margin:3%; width:94%;  border-bottom:1px solid #ccc; line-height:35px;">
								<b>Select Groups</b>
							</div>
							<center>
								<div style="width:95%">
									<table class="row-border">
						<?php
						if ($_GET['share_id'])
						{
							$chk_share = mysqli_query($con,"SELECT * FROM docfile_share WHERE share_id='$_GET[share_id]' ");
							if ($chk_share)
							{
								$share_id = $_GET['share_id'];
							}
						}
						$error ='';
						if ($error == '')
						{
							$times = time();

							$select_q = mysqli_query($con,"SELECT group_id FROM group_admin WHERE admin_id='$user' ");

							if(mysqli_num_rows($select_q) > 0)
							{
										
										while ($group_admin = mysqli_fetch_assoc($select_q))

										{
										$grp_id = $group_admin['group_id'];
										$group_q1 = mysqli_query($con,"SELECT * FROM `group` WHERE group_id='$grp_id' AND status='Live'");

											if(mysqli_num_rows($group_q1) > 0)
											{
												$group = mysqli_fetch_assoc($group_q1);
	                                            if(empty($group['grp_img']))
	                                            {
	                                                $grp_img = 'grp_pic/groups.png';
	                                            }
	                                            else
	                                            {
	                                                $grp_img = 'grp_pic/'.$group['grp_img'];	
	                                            }
												echo '<tr>
														<td width="40px;" align="center">
	                                                        <img src="'.$grp_img.'" class="circul" style="height:40px; width:40px;"/>                                                    
	                                                    </td>
														<td>'.$group['name'].'</td>
														<td align="center" width="100">';?>

														<input type="checkbox" id="folder" name="grp_ids[]" value="<?php echo $group['group_id']; ?>"/>

														<?php echo'</td>
													</tr>';
												}
										}

										
										if(!empty($_POST['grp_ids']))
										{
											//$i = 0;
												foreach ($_POST['grp_ids'] as $grp_selected) 
												{
														
														$group_share=mysqli_query($con,"INSERT INTO group_share (group_id,sender_id,share_id,time) VALUES ('$grp_selected','$user','$share_id',$times)");
														
												}
												echo '<meta http-equiv="refresh" content="0;url=./groups.php"/>';

										}
							}

                            $select_qm = mysqli_query($con,"SELECT group_id FROM group_member WHERE member_id='$user' ");

							if(mysqli_num_rows($select_qm) > 0)
							{
										
										while ($group_member = mysqli_fetch_assoc($select_qm))

										{
										$grp_id = $group_member['group_id'];
										$group_q2 = mysqli_query($con,"SELECT * FROM `group` WHERE group_id='$grp_id' AND status='Live'");
										if(mysqli_num_rows($group_q2) > 0)
											{
											$group = mysqli_fetch_assoc($group_q2);
	                                            if(empty($group['grp_img']))
	                                            {
	                                                $grp_img = 'grp_pic/groups.png';
	                                            }
	                                            else
	                                            {
	                                                $grp_img = 'grp_pic/'.$group['grp_img'];	
	                                            }
												echo '<tr>
														<td width="40px;" align="center">
	                                                        <img src="'.$grp_img.'" class="circul" style="height:40px; width:40px;"/>                                                    
	                                                    </td>
														<td>'.$group['name'].'</td>
														<td align="center" width="100">';?>

														<input type="checkbox" id="folder" name="grp_ids[]" value="<?php echo $group['group_id']; ?>"/>

														<?php echo'</td>
													</tr>';
											}
										}

										
										if(!empty($_POST['grp_ids']))
										{
											//$i = 0;
												foreach ($_POST['grp_ids'] as $grp_selected) 
												{
														
														$group_share=mysqli_query($con,"INSERT INTO group_share (group_id,sender_id,share_id,time) VALUES ('$grp_selected','$user','$share_id',$times)");
														
												}
												echo '<meta http-equiv="refresh" content="0;url=./groups.php"/>';

										}
							}
							

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


