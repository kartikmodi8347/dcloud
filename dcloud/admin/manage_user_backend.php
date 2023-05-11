<?php
	require_once '../config.php';
	$login_i = mysqli_query($con,"SELECT * FROM login_user WHERE role='User' ");
	$user_num = mysqli_num_rows($login_i);
	if ($user_num == 0) {$user_num = 0;}
	
	$block_q = mysqli_query($con,"SELECT * FROM login_user WHERE user_status='Block' ");
	$block_num = mysqli_num_rows($block_q);
	if ($block_num == 0) {$block_num = 0;}

	$active_q = mysqli_query($con,"SELECT * FROM login_user WHERE user_status='Live' ");
	$active_num = mysqli_num_rows($active_q);
	if ($active_num == 0) {$active_num = 0;}

	$admin_i = mysqli_query($con,"SELECT * FROM login_user WHERE role='Admin' ");
	$admin_num = mysqli_num_rows($admin_i);
	if ($admin_num == 0) {$admin_num = 0;}
									
								?>
					<div class="row">			
						<div class="col-l5 col-s10">
							<div class="card red dash-card">
								<div class="card-text-view">
									<p style="padding:0 0 10px 0; font-weight: bold;">TOTAL USERS</p>
									<p><h1><?php echo $user_num; ?></h1></p>
								</div>
								<div class="icon"><span class="fa fa-user"></span></div>
							</div>
						</div>
						<div class="col-l5 col-s10">
							<div class="card orange dash-card">
								<div class="card-text-view">
									<p style="padding:0 0 10px 0; font-weight: bold;">BLOCKED</p>
									<p><h1><?php echo $block_num; ?></h1></p>
								</div>
								<div class="icon"><span class="fa fa-folder"></span></div>
							</div>
						</div>
						<div class="col-l5 col-s10">
							<div class="card blue dash-card">
								<div class="card-text-view">
									<p style="padding:0 0 10px 0; font-weight: bold;">ACTIVE</p>
									<p><h1><?php echo $active_num; ?></h1></p>
								</div>
								<div class="icon"><span class="fa fa-file"></span></div>
							</div>
						</div>
						<div class="col-l5 col-s10">
							<div class="card green dash-card">
								<div class="card-text-view">
									<p style="padding:0 0 10px 0; font-weight: bold;">ADMINS</p>
									<p><h1><?php echo $admin_num; ?></h1></p>
								</div>
								<div class="icon"><span class="fa fa-group"></span></div>
							</div>
						</div>
					</div>
<?php
require_once '../config.php';

if(isset($_POST['readrecord']))
{
	
	$login_i = mysqli_query($con,"SELECT * FROM login_user WHERE role='User' ORDER BY reg_time DESC");

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
		<th width="65">Block</th>
		<th width="65">Delete</th>
		<th width="65">Edit</th>
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
									echo'<td>';
										if ($login_d['user_status'] == 'Live')
										{
										echo '<button id="block" style="width:60px;" class="btn-s red white-text" onclick="block('.$login_d['id'].')">Block</button>';
										}
										if ($login_d['user_status'] == 'Block')
										{
										echo '<button id="block" style="width:60px;" class="btn-s green white-text" onclick="unblock('.$login_d['id'].')">Unblock</button>';
										}		
									echo'</td>';
								echo'<td>';
									echo '<button id="block" style="width:60px;" class="btn-s red white-text" onclick="deleteu('.$login_d['id'].')">Delete</button>';		
								echo'</td>';
								
								echo'<td>';
									echo '<a href="edit_user.php?uid='.$login_d['id'].'"><button id="block" style="width:60px;" class="btn-s blue white-text"><span class="fa fa-edit"></span></button></a>';		
								echo'</td>';

								echo'</tr>';
								
								
			
								
								$i++;
				}
								echo'</table>';
}	
if(isset($_POST['user_id_b']))
{
	mysqli_query($con,"UPDATE `login_user` SET user_status='Block' WHERE id='$_POST[user_id_b]' ");
}
if(isset($_POST['user_id_ub']))
{
	mysqli_query($con,"UPDATE `login_user` SET user_status='Live' WHERE id='$_POST[user_id_ub]' ");
}		
if(isset($_POST['user_id_delete']))
{
	mysqli_query($con,"DELETE FROM login_user WHERE id='$_POST[user_id_delete]' ");
}					
?>