 <?php 
               
			echo'<table class="row-border">';
                        $g_admin = mysqli_query($con,"SELECT group_id FROM `group_admin` WHERE `admin_id`='$user'");
                        $admin_num 	= mysqli_num_rows($g_admin);
                        if ($admin_num > 0)
                        {
                            while($gadmin_data = mysqli_fetch_assoc($g_admin))
                            {
                            $grp_ids =$gadmin_data['group_id']; 

                            $group = mysqli_query($con,"SELECT * FROM `group` WHERE group_id='$grp_ids' AND status='Live'");
	                        $grp_num = mysqli_num_rows($group);    
								while ($group_d = mysqli_fetch_assoc($group)) {
									

									if(empty($group_d['grp_img']))
									{
										$grp_img = '../user/grp_pic/groups.png';
									}
									else
									{
										$grp_img = '../user/grp_pic/'.$group_d['grp_img'];	
									}
								echo'<a href="group/'.$group_d['group_id'].'"><tr class="link-row">';
									echo'<td align="center">';
										echo '<img src="'.$grp_img.'" style="height:35px; width:35px;" class="circul">';		
									echo'</td>';
									echo'<td align="left">';
										echo $group_d['name'];		
									echo'</td>';
									echo'<td align="left">';
										echo $group_d['group_type'];		
									echo'</td>';
								echo'</tr></a>';	

								}
                            }
                        }



                        $g_member = mysqli_query($con,"SELECT group_id FROM `group_member` WHERE `member_id`='$user'");
                        $member_num 	= mysqli_num_rows($g_member);
                        if ($member_num > 0)
                        {
                            while($gmember_data = mysqli_fetch_assoc($g_member))
                            {
                            $grp_idsm =$gmember_data['group_id']; 

                            $groupm = mysqli_query($con,"SELECT * FROM `group` WHERE group_id='$grp_idsm' AND status='Live' ");   
								while ($group_md = mysqli_fetch_assoc($groupm)) {
									

									if(empty($group_md['grp_img']))
									{
										$grp_img = '../user/grp_pic/groups.png';
									}
									else
									{
										$grp_img = '../user/grp_pic/'.$group_md['grp_img'];	
									}
								echo'<tr class="link-row" data-href="group/'.$group_md['group_id'].'">';
									echo'<td align="center">';
										echo '<img src="'.$grp_img.'" style="height:35px; width:35px;" class="circul">';		
									echo'</td>';
									echo'<td align="left">';
										echo $group_md['name'];		
									echo'</td>';
									echo'<td align="left">';
										echo $group_md['group_type'];		
									echo'</td>';
								echo'</tr>';	

								}
                            }
                        }
				echo'</table>';
?>