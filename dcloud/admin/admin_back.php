<?php
require_once("../config.php");
session_start();
$user = $_SESSION['user'];

$acheck_q = mysqli_query($con,"SELECT * FROM login_user WHERE id='$user' AND role='Admin' ");
$acheck_row = mysqli_num_rows($acheck_q);

if($acheck_row == 0)
{
	echo '<meta http-equiv="refresh" content="0;url=../index.php/"/>';
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
                  $pic_path = '../user/profile_pic/'.$data['id'].'/'.$name_row['profile_pic']; 
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
					$mcheck = mysqli_query($con,"SELECT id FROM login_user WHERE id='$data[id]' AND role='Admin' ");
					$mcheck_n = mysqli_num_rows($mcheck);

					if ($data['id'] == $_SESSION['user'] AND $mcheck_n > 0)
					{
						/*echo'<button class="btn-s blue white-text" onclick="add_r('.$data['id'].')">+ Add</button>';*/	
					}
					elseif ($data['id'] !== $_SESSION['user'] AND $mcheck_n == 0)
					{
						echo'<button class="btn-s blue white-text" onclick="add_m('.$data['id'].')">+ Add</button>';	
					}
					else
					{
						echo'<button class="btn-s blue white-text" onclick="remove_m('.$data['id'].')">- Remove</button>';
					}
					echo'</td>
				</tr>
			</table>';

	}
}


if(isset($_POST['member_id']))
{
 
 $member = $_POST['member_id'];
 mysqli_query($con,"UPDATE `login_user` SET role='Admin' WHERE id='$_POST[member_id]' ");	
 echo '<meta http-equiv="refresh" content="0;url=add_admin.php/"/>';
}
if(isset($_POST['r_member_id']))
{
 
 $member = $_POST['r_member_id'];
 mysqli_query($con,"UPDATE `login_user` SET role='User' WHERE id='$_POST[r_member_id]' ");	
 echo '<meta http-equiv="refresh" content="0;url=add_admin.php/"/>';
}
?>


<?php
if(isset($_POST['readrecord']))
{
$login_i = mysqli_query($con,"SELECT * FROM login_user WHERE role='Admin' ORDER BY reg_time DESC");

	$i = 1;

	echo'<table class="row-border">';
	echo'<tr>
		<th width="40px">Num</th>
		<th width="40px">Profile</th>
		<th>User Id</th>
		<th>User Name</th>
		<th>Full Name</th>
		<th>Status</th>
		<th>Last Update</th>
		<th width="65">Remove</th>
		</tr>';
		
			while ($login_d = mysqli_fetch_assoc($login_i)) {
									
				$user_q = mysqli_query($con,"SELECT * FROM user_reg WHERE id='$login_d[id]'");
				$user_d = mysqli_fetch_assoc($user_q);

					if ($user_d['profile_pic']== "")
					{
					  $pro_pic = '../img/profile.png';  
					}
					else
					{
					  $pro_pic = '../user/profile_pic/'.$user_d['id'].'/'.$user_d['profile_pic']; 
					}
								echo'<tr>';
									echo'<td style="width:20px;">';
										echo $i;		
									echo'</td>';
									echo'<td style="width:40px;">';
										echo '<img src="'.$pro_pic.'" style="height:35px; width:35px;" class="circul">';		
									echo'</td>';
									echo'<td>';
										echo $user_d['id'];		
									echo'</td>';
									echo'<td>';
										echo $login_d['username'];		
									echo'</td>';
									echo'<td>';
										echo $user_d['first_name'].' '.$user_d['last_name'];		
									echo'</td>';
									echo'<td>';
										echo $login_d['user_status'];		
									echo'</td>';
									echo'<td>';
										echo $login_d['reg_time'];		
									echo'</td>';

								if ($login_d['id'] == $_SESSION['user'])
								{

								}
								else
								{
								echo'<td>';
									echo '<button id="block" style="width:60px;" class="btn-s red white-text" onclick="remove_m('.$login_d['id'].')">Remove</button>';		
								echo'</td>';
								}
							
								echo'</tr>';
								
								
			
								
								$i++;
				}
								echo'</table>';
}								
?>