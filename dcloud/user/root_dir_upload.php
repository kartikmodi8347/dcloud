
<?php
require_once("../config.php");
$time = time();

if(isset($_FILES['file']['name']))
{
	 $path = '../data/'.$user.'/';
	 $dir_id = $user;

	 $filename = $_FILES['file']['name'];
	 $tempname = $_FILES['file']['tmp_name'];
	 $type = $_FILES['file']['type'];
	 $size = $_FILES['file']['size'];

	 $file_ex = array('image/png','image/jpeg','image/jpg','image/gif','image/svg','image/ico','image/bmp','image/ico','image/bmp','image/ai','application/pdf','text/plain','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msaccess','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.openxmlformats-officedocument.presentationml.presentation','application/vnd.ms-publisher','application/x-zip-compressed','application/octet-stream');
	 for ($i=0;$i<=count($tempname)-1;$i++)
	 {
	 	$id = time().rand(0,9); //file id

	 	if(in_array($type[$i],$file_ex))
	 	{
	 		//$dir_id = where : file_are / current directory id
	 		move_uploaded_file($tempname[$i], $path.$filename[$i]);

	 		$insert_q = "INSERT INTO docfile (`id`, `dir_id`, `doc_id`, `doc_path`, `doc_type`, `size`,`time`) VALUES ('$user','$dir_id','$id','$filename[$i]','$type[$i]','$size[$i]','$time')";
	 		$ins_q = mysqli_query($con,$insert_q);
				
	 		if($ins_q)
	 		{
	 			/*echo'<meta http-equiv="refresh" content="0">';*/
	 		}
	 	}
	 	else
	 	{
				$ia[$i] = $filename[$i];
	 	}
	 }
}
if(isset($ia) && $filename)
{
	echo implode(' , ', $ia).' <b>file are not supported.</b>';
} 
?>