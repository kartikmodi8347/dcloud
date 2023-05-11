<?php
require_once("config.php");
$error = "";

if(isset($_POST['login']))
{
	$eid = htmlentities($_POST['username']);
	$pass = htmlentities($_POST['password']);

	if ($error=='')
	{
		if($eid=='')
		{
			$error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>Enter your email id / username</div>";
		}
		else
		{
			$ec = mysqli_query($con,"SELECT id FROM login_user WHERE username='$eid' || email='$eid' "); 
			$ecnum = mysqli_num_rows($ec);
			if ($ecnum == 0)
			{
				$error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>Account does not exist</div>";
			}
	 	}
	}
	if ($error=='')
	{
		if($pass=='')	
		{
			$error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>Enter password</div>";
		}
		else
		{
			$new_pass = sha1(md5($pass));

			$pc = mysqli_query($con,"SELECT id,user_status FROM login_user WHERE (username = '$eid' || email = '$eid') && (pass='$new_pass')"); 
			$pcnum = mysqli_num_rows($pc);

			if ($pcnum == 0)
			{
				$error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>Incurrect password</div>";			
			}
			else
			{
				$user_row = mysqli_fetch_assoc($pc);
				if ($user_row['user_status']=='Block')
				{
					$error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>Sorry ! your account is blocked by admin</div>";
				}
				else
				{
					session_start();
					$_SESSION['user'] = $user_row['id'];

					$sq = mysqli_query($con,"SELECT * FROM sec_q WHERE id='$user_row[id]' ");
					$sq_num = mysqli_num_rows($sq);
					if($sq_num == 1)
					{
						header("location:./user/home.php");
					}
					else
					{
						header("location:seq_q.php");	
					}
				}
			}
		}

	}
}
?>