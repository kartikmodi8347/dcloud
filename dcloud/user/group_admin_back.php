<?php
require_once("../config.php");
session_start();
$user = $_SESSION['user'];

$acheck_q = mysqli_query($con,"SELECT admin_id FROM group_admin WHERE admin_id='$user' ");
$acheck_row = mysqli_num_rows($acheck_q);

if($acheck_row == 0)
{
	echo '<meta http-equiv="refresh" content="0;url=home.php/"/>';
}

if(isset($_POST['search']))
{

	$text = mysql_real_escape_string($_POST['search']);
	$query = mysqli_query($con,"SELECT * FROM `login_user` WHERE `username` LIKE '%$text%' ");


	while ($data = mysqli_fetch_assoc($query)) {

		$name = mysqli_query($con,"SELECT first_name,last_name,profile_pic FROM user_reg WHERE id='$data[id]' ");
		$name_row = mysqli_fetch_assoc($name);

		  if (!empty($name_row['profile_pic']))
              {
                  $pic_path = 'profile_pic/'.$data['id'].'/'.$name_row['profile_pic']; 
              }
              else
              {
                  $pic_path = '../img/profile.png';
              }


		echo'<table>
				<tr>
					<td style="height: 50px; width: 50px;"><img src="'.$pic_path.'" class="circul" style="height: 45px; width: 45px;" /></td>
					<td>
						<table border="0">
						<tr>
							<td style="height:10px; line-height:10px;"><span style="font-size:14px; color:#333;"><b>'.$name_row['first_name'].' '.$name_row['last_name'].'</b><span></td>
						</tr>
						<tr>
							<td style="height:10px; line-height:10px;" vlign="top"><span style="font-size:12px; color:#ccc;">'.$data['username'].'</span></td>
						</tr>
						</table>						

					</td>
					<td width="80px" vlign="top">';
					$acheck = mysqli_query($con,"SELECT admin_id FROM group_admin WHERE admin_id='$data[id]' AND group_id='$_GET[grp_id]'");
					$acheck_n = mysqli_num_rows($acheck);

					if ($data['id'] == $_SESSION['user'])
					{

					}
					else if($acheck_n > 0)
					{
						echo'<button class="btn-s blue white-text" onclick="remove_m('.$data['id'].')">- Remove</button>';
					}
					else
					{
						echo'<button class="btn-s blue white-text" onclick="add_m('.$data['id'].')">+ Add</button>';
					}
					echo'</td>
				</tr>
			</table>';

	}
}


if(isset($_POST['member_id']))
{
 
 $member = $_POST['member_id'];
 $g_id = $_GET['grp_id'];
 $time = time();

 $acheck = mysqli_query($con,"SELECT admin_id FROM group_admin WHERE admin_id='$member' AND group_id='$g_id'");
 $acheck_n = mysqli_num_rows($acheck);
 
 $mcheck = mysqli_query($con,"SELECT member_id FROM group_member WHERE member_id='$member' AND group_id='$_GET[grp_id]'");
 $mcheck_n = mysqli_num_rows($mcheck);

 if ($acheck_n == 0)
 {
 	if ($mcheck_n == 1)
 	{
 		mysqli_query($con,"DELETE FROM `group_member` WHERE member_id='$member' ");
 		mysqli_query($con,"INSERT INTO `group_admin` VALUES ('$g_id','$member','$user','$time')");
 	}
 	else
 	{
 		mysqli_query($con,"INSERT INTO `group_admin` VALUES ('$g_id','$member','$user','$time')");	
 	}
 }				

 	
 echo '<meta http-equiv="refresh" content="0;url=add_member/'.$g_id.'"/>';
}

if(isset($_POST['remove_id']))
{
 
 $member = $_POST['remove_id'];
 $g_id = $_GET['grp_id'];
 $time = time();

 mysqli_query($con,"DELETE FROM `group_admin` WHERE group_id='$g_id' AND admin_id='$member' ");
 mysqli_query($con,"INSERT INTO `group_member` VALUES ('$g_id','$member','Admin','$user','$time') ");
 echo '<meta http-equiv="refresh" content="0;url=add_admin/'.$g_id.'"/>';
}
?>
