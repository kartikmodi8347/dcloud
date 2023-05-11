<!DOCTYPE html>
<html>
<head>
	<title>Delete Documents</title>
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

if(dir_path($dir)) 
{
	$dir_path = dir_path($dir);
}           
else
{
	$dir_path = dirinfo($dir); 
}
?>

<body>
<?php require_once("mobile_option.php"); ?>
<?php require_once("header.php"); ?>
<div class="container with-fix">
       <div class="row">
        	<div class="col-l20">
          		<div class="card d-depth-2 circul-x1 full-on-l full-on-s" style="margin-top: 40px !important; ">
					<div class="card-head">Delete Files</div>   
					<div>
						<a href="file_area/<?php echo $_GET['dir'];?>">
              	<button class="white btn-s circul" style="margin-bottom: 4px; margin-right: 4px; width: auto; font-size: 20px; color: #333" ><span class="fa fa-arrow-circle-left"></span></button></a>
						<?php
		
				    	echo '<a href="file_area.php?dir='.$dir.'" style="font-size:14px; line-height:28px; margin-left:8px;">Current Folder : <b>'.dirinfo($dir).'</b></a>';
						$select_q = mysqli_query($con,"SELECT * FROM docfile WHERE dir_id='$dir' ");

						$img_ex = array('image/png','image/jpeg','image/jpg','image/gif','image/svg','image/ico','image/bmp','image/ico','image/bmp','image/ai');
						if(mysqli_num_rows($select_q) > 0)
						{
									echo'<form method="post">
											<center>
												<div style="width:95%">
													<table class="row-border" width="100%">';
									while ($doc = mysqli_fetch_assoc($select_q))
									{
										
										echo '<tr>
												<td width="40px;" align="center">';
												if(in_array($doc['doc_type'],$img_ex))
                              					{
	                                			echo
	                                			
	                                			/*'<span class="fa fa-image orange-text" style="font-size:42px;"></span>';*/
	                                			'<img src="../data/'.$user.'/'.$dir_path.'/'.$doc['doc_path'].'" style="width:auto; height:25px; max-width:25px;"/>';
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

												<input type="checkbox" name="dir_ids[]" value="<?php echo $doc['doc_id']; ?>"/>

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
										$file_num = 0; 
											foreach ($_POST['dir_ids'] as $delid) 
											{
													/*echo $delid;
													echo $_GET['dir'];*/
													$del = mysqli_query($con,"DELETE FROM docfile WHERE doc_id=$delid ");

													$file_num+=1;				
											}
											if($del)
											{
												echo 'Total : <b>'.$file_num.'<b> files deleted';
												echo'<meta http-equiv="refresh" content="0;url=./file_area/'.$_GET['dir'].'"/>';

												/*header("location:../user/);*/		
											}
											else 
											{
												echo 'Folder are not deleted for some reason';
											}	
									}
						}
						else
						{
							echo "<div class='red white-text' style='padding:20px 0 20px 0; text-align:center;'>No document exist in this folder</div>";
						}
						?>					
					</div>       			
                </div>
            </div>
        </div>
</body>
</html>