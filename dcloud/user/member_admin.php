
<?php
 require_once("../config.php");
 $grp_id = $_POST['ids'];
   $admins = mysqli_query($con,"SELECT * FROM group_admin WHERE group_id='$grp_id' ");
   $admin_num  = mysqli_num_rows($admins);
   
   $members = mysqli_query($con,"SELECT * FROM group_member WHERE group_id='$grp_id' ");
   $num_m = mysqli_num_rows($members);
if ($_POST['type']=='member')
{
    echo '<div class="card-head">Members <span style="color: #ccc; float: right; margin-right: 10px;">'.$num_m.'</span></div>
          <div class="card-item" style="max-height: 250px; overflow-y:auto;" >';
    
    while($member_row = mysqli_fetch_assoc($members))
              {
                
                $adq = mysqli_query($con,"SELECT * FROM user_reg WHERE id='$member_row[member_id]' "); 
                $m_info = mysqli_fetch_assoc($adq);
                $login_mq = mysqli_query($con,"SELECT username FROM login_user WHERE id='$member_row[member_id]' "); 
                $login_mrow = mysqli_fetch_assoc($login_mq);

              if (!empty($m_info['profile_pic']))
              {
                  $m_pic_path = 'profile_pic/'.$member_row['member_id'].'/'.$m_info['profile_pic']; 
              }
              else
              {
                  $m_pic_path = '../img/profile.png';
              }


                echo'<table style="border:0; width:100%;">
                  <tr>
                    <td width="50" align="center"><img class="circul" src="'.$m_pic_path.'" style="height:45px; width:45px;"/></td>
                    <td vlign="top" align="left">
                    <p><b>'.$m_info['first_name'].' '.$m_info['last_name'].'</b></p>
                    <p style="font-size:12px; color:#ccc;">'.$login_mrow['username'].'</p>
                    </td>
                  </tr>
                </table>';
              }
     echo'</div>';         
}

if ($_POST['type']=='admin')
{
   echo '<div class="card-head">Admin <span style="color: #ccc; float: right; margin-right: 10px;">'.$admin_num.'</span></div>
          <div class="card-item" style="max-height: 250px; overflow-y:auto;" >';
          
    while($admin_row = mysqli_fetch_assoc($admins))
              {
                
                $adq = mysqli_query($con,"SELECT * FROM user_reg WHERE id='$admin_row[admin_id]' "); 
                $ad_info = mysqli_fetch_assoc($adq);
                $login_uq = mysqli_query($con,"SELECT username FROM login_user WHERE id='$admin_row[admin_id]' "); 
                $login_urow = mysqli_fetch_assoc($login_uq);

              if (!empty($ad_info['profile_pic']))
              {
                  $ad_pic_path = 'profile_pic/'.$admin_row['admin_id'].'/'.$ad_info['profile_pic']; 
              }
              else
              {
                  $ad_pic_path = '../img/profile.png';
              }


                echo'<table style="border:0; width:100%;">
                  <tr>
                    <td width="50" align="center"><img class="circul" src="'.$ad_pic_path.'" style="height:45px; width:45px;"/></td>
                    <td vlign="top" align="left">
                    <p><b>'.$ad_info['first_name'].' '.$ad_info['last_name'].'</b></p>
                    <p style="font-size:12px; color:#ccc;">'.$login_urow['username'].'</p>
                    </td>
                  </tr>
                </table>';
              }
       echo'</div>';       
}
?>