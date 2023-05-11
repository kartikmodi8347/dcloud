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
	$user 	= $_SESSION['user'];
	if (isset($_GET['dir']))
	{
		$dir = $_GET['dir'];
	}

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
					<div class="card-head">Delete Folder</div>   
					<div>
					<a href="file_area/<?php echo $_GET['dir'];?>">
              	<button class="white btn-s circul" style="margin-bottom: 4px; margin-right: 4px; width: auto; font-size: 20px; color: #333" ><span class="fa fa-arrow-circle-left"></span></button></a>
						<?php
						   
						    	echo '<span style="font-size:14px; line-height:28px; margin-left:8px;">Current Folder : <a href="file_area.php?dir='.$_GET['dir'].'"><b>'.dirinfo($dir).'</b></a></span>';
								$select_q = mysqli_query($con,"SELECT linked_dir_id FROM dir_tree WHERE dir_id='$dir' ");
								if(mysqli_num_rows($select_q) > 0)
								{
											echo'<form method="post">
													<center>
														<div style="width:95%">
															<table class="row-border">';

											while ($dir = mysqli_fetch_assoc($select_q))
											{
												$subfolder = mysqli_query($con,"SELECT linked_dir_id FROM dir_tree WHERE dir_id='$dir[linked_dir_id]' ");$sub_dir = mysqli_num_rows($subfolder);
												echo '<tr>
														<td width="40px;" align="center"><span class="fa fa-folder-open yellow-text text-darken-3" style="font-size: 21px; margin: 4px;"></span></td>
														<td>'.dirinfo($dir['linked_dir_id']).' <span style="color:#ccc; font-size:12px;">(total items:'.num_of_items($dir['linked_dir_id']).' Sub folder:'.$sub_dir.')</span></td>
														<td align="center">';?>

														<input type="checkbox" name="dir_ids[]" value="<?php echo $dir['linked_dir_id']; ?>"/>

														<?php echo'<td>
													 </tr>';
											}

											
											echo '			</table>
														</div>
														<input type="submit" class="btn-s blue white-text" value="delete" style="margin-bottom:20px";/>
													</center>
												</form>';


											if(!empty($_POST['dir_ids']))
											{
													foreach ($_POST['dir_ids'] as $delid) 
													{
															/*echo $delid;
															echo $_GET['dir'];*/
															/*$del = mysqli_query($con,"DELETE FROM dir_tree WHERE linked_dir_id=$delid ");*/
															$del = del_dir_path($delid);		
															if($del)
															{
																echo '<meta http-equiv="refresh" content="0;url=./file_area/'.$_GET['dir'].'"/>';
																
															}
															else {
																echo "<div class='red white-text' style='padding:20px 0 20px 0; text-align:center;'>Folder are not deleted for some reason</div>";
															}				
													}	
											}
								}
								else
								{
									echo "<div class='red white-text' style='padding:20px 0 20px 0; text-align:center;'>No another folder exist in this folder</div>";
								}
							
						?>					
					</div>       			
                </div>
            </div>
        </div>
</body>
</html>