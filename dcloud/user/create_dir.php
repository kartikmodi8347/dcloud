<?php
require_once("../config.php");
$dir_error = '';
function create_dir($dir_name,$dir_user,$dir_path,$dir_type,$parent_dir='')
{
	global $con;
	global $dir_error;

	$time = time();
	$final_path = '../data/'.$dir_path.'/'.$dir_name;
	if(file_exists($final_path))
	{
		$dir_error = 'This Folder are aldredy exist in this location, try another name';		
	}
	elseif (mkdir($final_path,0777,true)) 
	{
		//create index file
		$myfile = fopen($final_path.'/index.php',"w") or die("not open");
		$txt = "
		<?php echo'<meta http-equiv=refresh content=0;url=http://documentcloud.ml/>'; ?>
		";
		fwrite($myfile, $txt);
		fclose($myfile);


		$dir_id = time().rand(0,9);
 		$dir_index = mysqli_query($con,"INSERT INTO `directory`(`id`, `dir_id`, `dir_name`, `status`, `time`) VALUES ('$dir_user','$dir_id','$dir_name','$dir_type','$time')");

		if (isset($parent_dir))
		{
			$p_dir = mysqli_query($con,"INSERT INTO dir_tree (dir_id,linked_dir_id) VALUES ($parent_dir,$dir_id)");
		}

		if($dir_index)
		{
			 echo'<meta http-equiv="refresh" content="0">';
		}
		else
		{
			echo mysql_error($dir_error);
		}
	}
	else
	{
		$dir_error = 'Enter a valid Folder name';
	}
}
?>