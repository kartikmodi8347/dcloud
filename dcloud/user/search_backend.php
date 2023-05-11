<?php
require_once("../config.php");

if(isset($_POST['search']))
{

	//$text = mysql_real_escape_string($_POST['search']);
	$text = $_POST['search'];
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
					<td width="80px" vlign="top"><button class="btn-s blue white-text" onclick="follow('.$data['id'].')">Follow</button></td>
				</tr>
			</table>';

	}
}


if(isset($_POST['user_id']))
{
 session_start();
 $user = $_SESSION['user'];
 $to = $_POST['user_id'];
 mysqli_query($con,"INSERT INTO follow VALUES ('$user','$to')");	
}
?>
