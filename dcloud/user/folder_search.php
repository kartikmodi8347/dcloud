<?php
require_once("../config.php");
require_once("dir_info.php");
session_start();
$user = $_SESSION['user'];

$acheck_q = mysqli_query($con,"SELECT admin_id FROM group_admin WHERE admin_id='$user' ");
$acheck_row = mysqli_num_rows($acheck_q);

if($acheck_row == 0)
{
	//echo '<meta http-equiv="refresh" content="0;url=home.php/"/>';
}

if(isset($_POST['search']))
{

	//$text = mysql_real_escape_string($_POST['search']);
	$text = $_POST['search'];
	$query = mysqli_query($con,"SELECT * FROM `directory` WHERE `dir_name` LIKE '%$text%' AND id='$user' ");

	echo '<table class="row-border" style="margin-top:8px;">';
	while ($data = mysqli_fetch_assoc($query)) {
		$subfolder = mysqli_query($con,"SELECT linked_dir_id FROM dir_tree WHERE dir_id='$data[dir_id]' ");
		$sub_dir = mysqli_num_rows($subfolder);
	echo'
		<tr>
			<td align="center" width="60"><span class="fa fa-folder fa-2x yellow-text text-darken-3" ></span></td>
			<td align="left"><a href="file_area/'.$data['dir_id'].'"><b>'.$data['dir_name'].'</b><span style="color:#ccc; font-size:12px;"> (total items:'.num_of_items($data['dir_id']).' Sub folder:'.$sub_dir.')</span></a>
			<p><span style="color:#ccc; font-size:12px;">'.dir_path($data['dir_id']).'</span></p>
			</td>
		</tr>';

	}
	echo '</table>';
}


if(isset($_POST['member_id']))
{
 
 $member = $_POST['member_id'];
 $g_id = $_GET['grp_id'];
 $time = time();
 mysqli_query($con,"INSERT INTO `group_member` VALUES ('$g_id','$member','Admin','$user','$time')");	
 echo '<meta http-equiv="refresh" content="0;url=add_member/'.$g_id.'"/>';
}
?>
