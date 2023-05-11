<style type="text/css">
	.me-main {
		border-radius: 8px; background-color: #f7f7f7; border:1px solid #ccc; min-height: 40px;
	}
	.me-name {padding-left: 8px; font-size: 12px; color: #f7f7f7;}
	.me-msg {padding:0 8px 0 8px; font-size: 14px; color: #f7f7f7}

	.you-main {
		border-radius: 8px; background-color: #f7f7f7; border:1px solid #ccc; min-height: 40px;
	}
	.you-name {padding-left: 8px; font-size: 12px;}
	.you-msg {padding:0 8px 0 8px; font-size: 14px;}

	.docfile {
		margin: 4px; padding:0 4px 0 4px; border-radius: 8px; font-size: 12px; background-color: #f7f7f7; border: 1px solid #ccc; color: #666
	}
	

	.pro-pic {
		height: 40px !important; width: 40px !important; border: 2px solid #f7f7f7
	}
</style>
<?php
 require_once("../config.php");
 session_start();
 $me = $_SESSION['user'];
 $group_id = $_GET['grp_id'];

$query = mysqli_query($con,"SELECT * FROM group_share where group_id='$group_id' ");

$user = mysqli_query($con,"SELECT * FROM user_reg,login_user where login_user.id='$me' AND user_reg.id='$me'");
$user_row = mysqli_fetch_assoc($user);

              if (!empty($user_row['profile_pic']))
              {
                  $pro_pic_path = 'profile_pic/'.$me.'/'.$user_row['profile_pic']; 
              }
              else
              {
                  $pro_pic_path = '../img/profile.png';
              }
while ($msg = mysqli_fetch_assoc($query)) {
	if ($msg['sender_id'] == $me)
	{

		echo'<table style="width: 88%; border: 0; float: right;">
              <tr>
                <td>
                  <div class="blue lighten-1 me-main">
                    <p class="me-name"><b>'.$user_row['first_name'].' '.$user_row['first_name'].'</b> ('.$user_row['username'].')<span class="right" style="font-size:11px;">'.date('d M Y h:i a',$msg['time']).'&nbsp;</span></p>
                    <!-- share link box -->';
          	if($msg['share_id'] !== "")
          		{
                 $doc1 = mysqli_query($con,"SELECT `share_title` FROM `share_privacy` WHERE `share_id`='$msg[share_id]' ");
                $doc_q1 = mysqli_fetch_assoc($doc1);
                if ($doc_q1['share_title'] == "")
                {
                  $doctitle1 = "Document";
                }
                else
                {
                  $doctitle1 = $doc_q1['share_title'];
                } 
                echo'<a href="share_view/0/'.$msg['share_id'].'"><div class="docfile">
                      <span class="fa fa-share"></span>
                      <b>'.$doctitle1.'</b>
                    </div></a>';
                }
        echo'       <!-- message box -->
                    <p class="me-msg">'.$msg['message'].'</p>
                  </div>
                </td>
                <td width="55" align="center" valign="top"><img src="'.$pro_pic_path.'" class="circul pro-pic" /></td>
              </tr>
            </table>';
		
	}
	else
	{
		$sender = mysqli_query($con,"SELECT * FROM user_reg,login_user where login_user.id='$msg[sender_id]' AND user_reg.id='$msg[sender_id]'");
		$sender_row = mysqli_fetch_assoc($sender);

		 if (!empty($sender_row['profile_pic']))
              {
                  $pro_pic_path2 = 'profile_pic/'.$msg['sender_id'].'/'.$sender_row['profile_pic']; 
              }
              else
              {
                  $pro_pic_path2 = '../img/profile.png';
              }
		echo'<table style="width: 88%; border: 0; float: left;">
              <tr>
              	<td width="55" align="center" valign="top"><img src="'.$pro_pic_path2.'" class="circul pro-pic" /></td>
                <td>
                  <div class="you-main">
                    <p class="you-name"><b>'.$sender_row['first_name'].' '.$sender_row['first_name'].'</b> ('.$sender_row['username'].')<span class="right" style="font-size:11px;">'.date('d M Y h:i a',$msg['time']).'&nbsp;</span></p>
                    <!-- share link box -->';
          	if($msg['share_id'] !== "")
          		{
                $doc2 = mysqli_query($con,"SELECT `share_title` FROM `share_privacy` WHERE `share_id`='$msg[share_id]' ");
                $doc_q2 = mysqli_fetch_assoc($doc2);
                if ($doc_q2['share_title'] == "")
                {
                  $doctitle2 = "Document";
                }
                else
                {
                  $doctitle2 = $doc_q2['share_title'];
                } 
                echo'<a href="share_view/0/'.$msg['share_id'].'"><div class="docfile">
                      <span class="fa fa-share"></span>
                      <b>'.$doctitle2.'</b>
                    </div></a>';
                }
        echo'       <!-- message box -->
                    <p class="you-msg">'.$msg['message'].'</p>
                  </div>
                </td>
                
              </tr>
            </table>';	
	}
}

if(isset($_POST['msg_text']))
{
	$msg = htmlentities($_POST['msg_text']);
	$time  = time();
	echo 'okk';
	mysqli_query($con,"INSERT INTO `group_share`(`group_id`, `sender_id`,`message`, `time`) VALUES ('$group_id','$me','$msg',$time)");
}
?>