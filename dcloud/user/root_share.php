<!DOCTYPE html>
<html>
<head>
	<title></title>
	 
	 <?php require_once 'require.php'; ?>

</head>
<?php
require_once("../config.php");
require_once("dir_info.php");
session_start();
if (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
}
else{
	header('location:../index.php');
} 


$reg = mysqli_query($con,"SELECT * FROM user_reg WHERE id=$user ");
$reg_row = mysqli_fetch_assoc($reg);
    if (!empty($reg_row['profile_pic']))
            {
                $pro_pic_path = 'profile_pic/'.$user.'/'.$reg_row['profile_pic']; 
            }
            else
            {
                $pro_pic_path = '../img/profile.png';
            }

?>
<body>
<?php require_once("mobile_option.php"); ?>
<?php require_once("header.php"); ?>
<div class="container with-fix">
       <div class="row">
        	<div class="col-l20">
          		<div class="card d-depth-2 circul-x1 full-on-l full-on-s" style="margin-top: 40px !important; ">
					<div class="card-head">Share Files</div>   
					<div>
						<a href="home.php">
              				<button class="white btn-s circul" style="margin-bottom: 4px; margin-right: 4px; width: auto; font-size: 20px; color: #333" ><span class="fa fa-arrow-circle-left"></span></button></a>
					<?php echo '<p style="font-size:14px; line-height:28px; margin-left:8px;">Root Folder</p>'; ?>
						<form method="POST">
							<div style="margin:3%; width:94%; line-height:35px;"><input type="text" name="share_title" placeholder="Title" class="input-text" /></div>

							<div style="margin:3%; width:94%;  border-bottom:1px solid #ccc; line-height:35px;"><b>Select Sharing Type</b></div>
							<div style="margin:3%; width:92%;">
							<div class="row">
								<div class="col-l20 col-s20" style="padding:10px; 0 10px 0; margin-bottom:60px;">
									<input type="radio" value="Public" name="sharep" checked="checked"/> Share to publicly &nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" value="Private" name="sharep"/> Share to user &nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" value="Group" name="sharep"/> Share to Group &nbsp;&nbsp;&nbsp;&nbsp;
									<!-- <input type="radio" value="Group" name="sharep"/> Share to group &nbsp;&nbsp;&nbsp;&nbsp; -->
									<div id="email_box" style="margin:3%; width:94%; line-height:35px; display: none;"><input type="email" name="email_id" placeholder="Enter registered Email Id" class="input-text" />
								</div>
							</div>

							</div>

							<div style="margin:3%; width:94%;  border-bottom:1px solid #ccc; line-height:35px;">
								<b>Select Files</b>
								<div style="float: right; margin-right: 4.5%;">
									<input type="checkbox" id="select_all" style="display: block;" />
									<input type="checkbox" id="unselect_all" style="display: none;"/>
								</div>
							</div>
							<center>
								<div style="width:95%">
									<table class="row-border">
						<?php
						
						$error ='';
						if ($error == '')
						{
							$share_id = time().rand(0,9);
							$times = time();
							if(isset($_POST['sharep']))
							{
								$share_p = $_POST['sharep'];
							}

							$select_q = mysqli_query($con,"SELECT * FROM directory WHERE id='$user' AND status='root' ");

							if(mysqli_num_rows($select_q) > 0)
							{
										
										while ($dir = mysqli_fetch_assoc($select_q))
										{
											$subfolder = mysqli_query($con,"SELECT linked_dir_id FROM dir_tree WHERE dir_id='$dir[dir_id]' ");$sub_dir = mysqli_num_rows($subfolder);
											echo '<tr>
													<td width="40px;" align="center"><span class="fa fa-folder-open yellow-text text-darken-3" style="font-size: 21px; margin: 4px;"></span></td>
													<td>'.dirinfo($dir['dir_id']).' <span style="color:#ccc; font-size:12px;">(total items:'.num_of_items($dir['dir_id']).' Sub folder:'.$sub_dir.')</span></td>
													<td align="center">';?>

													<input type="checkbox" id="folder" name="dir_ids[]" value="<?php echo $dir['dir_id']; ?>"/>

													<?php echo'<td>
												</tr>';
										}

							
							}
							else
							{
								echo "<div class='red white-text' style='padding:20px 0 20px 0; text-align:center;'>No another folder exist in this folder</div>";
							}

							$select_file = mysqli_query($con,"SELECT * FROM docfile WHERE dir_id='$user' ");

							$img_ex = array('image/png','image/jpeg','image/jpg','image/gif','image/svg','image/ico','image/bmp','image/ico','image/bmp','image/ai');
	
							if(mysqli_num_rows($select_file) > 0)
							{
										while ($doc = mysqli_fetch_assoc($select_file))
										{
											
											echo '<tr>
													<td width="40px;" align="center">';
													if(in_array($doc['doc_type'],$img_ex))
													{
													echo'<img src="../data/'.$user.'/'.$doc['doc_path'].'" style="width:auto; height:25px; max-width:25px;"/>';
													}
													if($doc['doc_type'] == 'application/x-zip-compressed')
													{
													echo'<img src="../img/6.zip.png" style="width:auto; height:45px; max-width:55px;"/>';
													}
													if($doc['doc_type'] == 'application/octet-stream')
													{
													echo'<img src="../img/7.rar.png" style="width:auto; height:45px; max-width:55px;"/>';
													}
													if($doc['doc_type'] == 'application/pdf')
													{
													echo'<img src="../img/8.pdf.png" style="width:auto; height:45px; max-width:55px;"/>';
													}
													if($doc['doc_type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
													{
													echo'<img src="../img/3.word.png" style="width:auto; height:45px; max-width:55px;"/>';
													}
													if($doc['doc_type'] == 'application/msaccess')
													{
													echo'<img src="../img/1.access.png" style="width:auto; height:45px; max-width:55px;"/>';
													}
													if($doc['doc_type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
													{
													echo'<img src="../img/5.Excel.png" style="width:auto; height:45px; max-width:55px;"/>';
													}
													if($doc['doc_type'] == 'application/vnd.openxmlformats-officedocument.presentationml.presentation')
													{
													echo'<img src="../img/4.Powerpoint.png" style="width:auto; height:45px; max-width:55px;"/>';
													}
													if($doc['doc_type'] == 'application/vnd.ms-publisher')
													{
													echo'<img src="../img/2.publisher.png" style="width:auto; height:45px; max-width:55px;"/>';
													}
													
												echo'</td>
													<td>'.$doc['doc_path'].'</td>
													<td align="center">';?>

													<input type="checkbox" name="file_ids[]" id="files" value="<?php echo $doc['doc_id']; ?>"/>

													<?php echo'<td>
												</tr>';
										}
	

							}

							if (isset($_POST['submit'])) {
										
										if(!empty($_POST['dir_ids']))
										{
											//$i = 0;
												foreach ($_POST['dir_ids'] as $dir_selected) 
												{
														//$select_d[$i] = $dir_selected;
														$folder=mysqli_query($con,"INSERT INTO docfile_share (id,share_id,dir_id,share_type,time) VALUES ('$user','$share_id','$dir_selected','$share_p',$times)");
														//$i++;
												}

										}
										else
										{
											echo "<div class='red white-text' style='padding:20px 0 20px 0; text-align:center;'>Select Folders</div>";
										}

										if(!empty($_POST['file_ids']))
										{
											$file_num = 0;
												foreach ($_POST['file_ids'] as $doc_files) 
												{
													$files=mysqli_query($con,"INSERT INTO docfile_share (id,share_id,doc_id,share_type,time) VALUES ('$user','$share_id','$doc_files','$share_p',$times)");
												}	
										}
									}

							if(isset($folder) || isset($files))
							{
								if (!empty($_POST['share_title']))
								{
									$share_title = htmlentities($_POST['share_title']);
								}
								else
								{
									$share_title="Untitled";
								}

								mysqli_query($con,"INSERT INTO share_privacy (id,share_id,share_title,share_type,time) VALUES ('$user','$share_id','$share_title','$share_p',$times)");
								if ($share_p =='Private')
								{	
									if(isset($_POST['email_id']))
									{
										$sel_q = mysqli_query($con,"SELECT id FROM login_user WHERE email='$_POST[email_id]' ");
										if (mysqli_num_rows($sel_q) > 0)
										{
											$sel_row = mysqli_fetch_assoc($sel_q);
											$share_to = $sel_row['id'];
											mysqli_query($con,"INSERT INTO share_to (id,share_id,share_user,time) VALUES ('$user','$share_id','$share_to',$times)");
											echo '<meta http-equiv="refresh" content="0;url=public_share/'.$share_id.'"/>';
	 									}
	 									else
	 									{
	 										echo "<div class='red white-text' style='padding:20px 0 20px 0; text-align:center;'>Wrong email id</div>";
	 									}
										
									}
									else
									{
										echo "<div class='red white-text' style='padding:20px 0 20px 0; text-align:center;'>Enter a registered email id</div>";
									}


								}

  							    if ($share_p =='Public')
								{
									echo '<meta http-equiv="refresh" content="0;url=public_share/'.$share_id.'"/>';
								}
								if ($share_p =='Group')
								{
									echo '<meta http-equiv="refresh" content="0;url=group_share/'.$share_id.'"/>';
								}
								
							}

						}
						?>
										</table>
									</div>
								<input type="submit" class="btn-s blue white-text" value="Next >" name="submit" style="margin-bottom:20px";/>
							</center>
						</form>					
					</div>       			
                </div>
            </div>
        </div>
</body>
</html>

<script type="text/javascript">
	$("#select_all").click(function () {
		$("#unselect_all").css("display","block");
		$("#select_all").css("display","none");
		$('input[id=unselect_all]').attr('checked',true);

		$('input[id=folder]').attr('checked',true);
		$('input[id=files]').attr('checked',true);
	});
	$("#unselect_all").click(function () {
		$("#select_all").css("display","block");
		$("#unselect_all").css("display","none");
		$('input[id=select_all]').attr('checked',false);

		$('input[id=folder]').attr('checked',false);
		$('input[id=files]').attr('checked',false);
	});
</script>
<script type="text/javascript">
	$("input[name='sharep']").click(function () {
		if($("input[name='sharep']:checked").val() == 'Public')
		{
			$("#email_box").css("display","none");
		}
		if($("input[name='sharep']:checked").val() == 'Private')
		{
			$("#email_box").css("display","block");
		}
	});
</script>

 -->