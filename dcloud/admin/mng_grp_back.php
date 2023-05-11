<?php
	require_once '../config.php';
	$group = mysqli_query($con,"SELECT * FROM `group` WHERE 1");
	$grp_num = mysqli_num_rows($group);

	$group_block = mysqli_query($con,"SELECT * FROM `group` WHERE status='Block' ");
	$block_num = mysqli_num_rows($group_block);

	$grp_admin= mysqli_query($con,"SELECT * FROM `group_admin`");
	$admin_num = mysqli_num_rows($grp_admin);

	$grp_share= mysqli_query($con,"SELECT * FROM `group_share`");
	$share_num = mysqli_num_rows($grp_share);
?>
						<div class="col-l5 col-s10">
							<div class="card red dash-card">
								<div class="card-text-view">
									<p style="padding:0 0 10px 0; font-weight: bold;">Total Groups</p>
									<p><h1><?php echo $grp_num; ?></h1></p>
								</div>
								<div class="icon"><span class="fa fa-group"></span></div>
							</div>
						</div>
						<div class="col-l5 col-s10">
							<div class="card orange dash-card">
								<div class="card-text-view">
									<p style="padding:0 0 10px 0; font-weight: bold;">Blocked Group</p>
									<p><h1><?php echo $block_num; ?></h1></p>
								</div>
								<div class="icon"><span class="fa fa-ban"></span></div>
							</div>
						</div>
						<div class="col-l5 col-s10">
							<div class="card blue dash-card">
								<div class="card-text-view">
									<p style="padding:0 0 10px 0; font-weight: bold;">Admins</p>
									<p><h1><?php echo $admin_num; ?></h1></p>
								</div>
								<div class="icon"><span class="fa fa-user"></span></div>
							</div>
						</div>
						<div class="col-l5 col-s10">
							<div class="card green dash-card">
								<div class="card-text-view">
									<p style="padding:0 0 10px 0; font-weight: bold;">Total Sharing</p>
									<p><h1><?php echo $share_num; ?></h1></p>
								</div>
								<div class="icon"><span class="fa fa-share"></span></div>
							</div>
						</div>
						<div>
							<?php 
								$i = 1;

								echo'<table class="row-border">';
								echo'<tr>
										<th width="40">Num</th>
										<th width="40">Icon</th>
										<th>Name</th>
										<th width="100">Grp Id</th>
										<th width="50">Type</th>
										<th width="50">Status</th>
										<th width="200"></th>

									</td>';
								while ($group_d = mysqli_fetch_assoc($group)) {
									

									if(empty($group_d['grp_img']))
									{
										$grp_img = '../user/grp_pic/groups.png';
									}
									else
									{
										$grp_img = '../user/grp_pic/'.$group_d['grp_img'];	
									}
								echo'<tr>';
									echo'<td align="center">';
										echo $i;		
									echo'</td>';
									echo'<td align="center">';
										echo '<img src="'.$grp_img.'" style="height:35px; width:35px;" class="circul">';		
									echo'</td>';
									echo'<td align="left">';
										echo $group_d['name'];		
									echo'</td>';
									echo'<td align="left">';
										echo $group_d['group_id'];		
									echo'</td>';
									echo'<td align="left">';
										echo $group_d['group_type'];		
									echo'</td>';
									echo'<td align="left">';
										echo $group_d['status'];		
									echo'</td>';
									echo'<td align="left">';
									
									if ($group_d['status'] == 'Live')
									{
										echo '<button id="block" style="width:60px;" class="btn-s red white-text" onclick="block('.$group_d['group_id'].')">Block</button>';
									}
									if ($group_d['status'] == 'Block')
									{
										echo '<button id="block" style="width:60px;" class="btn-s green white-text" onclick="unblock('.$group_d['group_id'].')">Unblock</button>';
									}	
									echo '<button id="block" style="width:60px;" class="btn-s red white-text" onclick="deleteg('.$group_d['group_id'].')">Delete</button>';	
									echo '<a href="edit_grp.php?grp_id='.$group_d['group_id'].'"><button id="block" style="width:60px;" class="btn-s blue white-text" onclick="edit"><span class="fa fa-edit"></span></button></a>';
									
									echo'</td>';
								echo'</tr>';	
								
								$i++;
								}
								echo'</table>';
							?>
						</div>
<?php
if(isset($_POST['grp_id_b']))
{
	mysqli_query($con,"UPDATE `group` SET status='Block' WHERE group_id='$_POST[grp_id_b]' ");
}
if(isset($_POST['grp_id_ub']))
{
	mysqli_query($con,"UPDATE `group` SET status='Live' WHERE group_id='$_POST[grp_id_ub]' ");
}		
if(isset($_POST['grp_id_delete']))
{
	mysqli_query($con,"DELETE FROM `group` WHERE group_id='$_POST[grp_id_delete]' ");
	mysqli_query($con,"DELETE FROM `group_member` WHERE group_id='$_POST[grp_id_delete]' ");
	mysqli_query($con,"DELETE FROM `group_admin` WHERE group_id='$_POST[grp_id_delete]' ");
	mysqli_query($con,"DELETE FROM `group_share` WHERE group_id='$_POST[grp_id_delete]' ");
}						
?>