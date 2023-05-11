<?php
require_once("../config.php");
function conv($byte)
{
	if  ($byte >= 1073741824)
	{
		$byte = number_format($byte/1073741824,2).'GB';
	}
	elseif($byte >= 1048576)
	{
		$byte = number_format($byte/1048576,2).'MB';
	}
	elseif($byte >= 1024)
	{
		$byte = number_format($byte/1024,2).'KB';	
	}
	elseif($byte > 1)
	{
		$byte = $byte.'Byte';	
	}
	else
	{
		$byte = '0byte';
	}
	return $byte;
}

function avilable ($byte2)
{
	$avi = 1073741824 - $byte2;
	return $avi;
}

function get_size($user,$type)
{
	global $con;
	$size=0;
	if($type=='image' || $type=='ms' || $type=='extrected' || $type=='pdf' || $type=='other')
	{
			if ($type == 'image')
			{
				$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE id='$user' && (doc_type='image/png' || doc_type='image/jpg' || doc_type='image/jpeg' || doc_type='image/gif' || doc_type='image/svg' || doc_type='image/ico' || doc_type='image/png' || doc_type='image/bmp' || doc_type='image/ai') ");
				$data = mysqli_fetch_assoc($qu);
					$size = $data['SUM(size)'];
			}
			if ($type == 'ms')
			{
				$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE id='$user' && (doc_type='application/vnd.openxmlformats-officedocument.wordprocessingml.document' || doc_type='application/msaccess' || doc_type='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || doc_type='application/vnd.openxmlformats-officedocument.presentationml.presentation' || doc_type='application/vnd.ms-publisher') ");
				$data = mysqli_fetch_assoc($qu);
					$size = $data['SUM(size)'];
			}
			if ($type == 'pdf')
			{
				$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE id='$user' && doc_type='application/pdf' ");
				$data = mysqli_fetch_assoc($qu);
					$size = $data['SUM(size)'];
			}
			if ($type == 'extrected')
			{
				$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE id='$user' && (doc_type='application/x-zip-compressed'  || doc_type='application/octet-stream') ");
				$data = mysqli_fetch_assoc($qu);
					$size = $data['SUM(size)'];
			}
			if ($type == 'other')
			{
				$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE id='$user' && (doc_type='text/plain') ");
				$data = mysqli_fetch_assoc($qu);
					$size = $data['SUM(size)'];
				
			}
	}
	else
	{
		$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE id='$user' && doc_type='$type' ");
				$data = mysqli_fetch_assoc($qu);
					$size = $data['SUM(size)'];
	}
	return $size;
}

function get_filenum($user,$type)
{
	global $con;
	$size=0;
	if($type=='image' || $type=='ms' || $type=='extrected' || $type=='pdf' || $type=='other')
	{
			if ($type == 'image')
			{
				$qu = mysqli_query($con,"SELECT * FROM docfile WHERE id='$user' && (doc_type='image/png' || doc_type='image/jpg' || doc_type='image/jpeg' || doc_type='image/gif' || doc_type='image/svg' || doc_type='image/ico' || doc_type='image/png' || doc_type='image/bmp' || doc_type='image/ai') ");
				$data = mysqli_num_rows($qu);
					$size = $data;
			}
			if ($type == 'ms')
			{
				$qu = mysqli_query($con,"SELECT * FROM docfile WHERE id='$user' && (doc_type='application/vnd.openxmlformats-officedocument.wordprocessingml.document' || doc_type='application/msaccess' || doc_type='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || doc_type='application/vnd.openxmlformats-officedocument.presentationml.presentation' || doc_type='application/vnd.ms-publisher') ");
				$data = mysqli_num_rows($qu);
					$size = $data;
			}
			if ($type == 'pdf')
			{
				$qu = mysqli_query($con,"SELECT * FROM docfile WHERE id='$user' && doc_type='application/pdf' ");
				$data = mysqli_num_rows($qu);
					$size = $data;
			}
			if ($type == 'extrected')
			{
				$qu = mysqli_query($con,"SELECT * FROM docfile WHERE id='$user' && (doc_type='application/x-zip-compressed'  || doc_type='application/octet-stream') ");
				$data = mysqli_num_rows($qu);
					$size = $data;
			}
			if ($type == 'other')
			{
				$qu = mysqli_query($con,"SELECT * FROM docfile WHERE id='$user' && (doc_type='text/plain') ");
				$data = mysqli_num_rows($qu);
					$size = $data;
				
			}
	}
	else
	{
		$qu = mysqli_query($con,"SELECT * FROM docfile WHERE id='$user' && doc_type='$type' ");
				$data = mysqli_num_rows($qu);
					$size = $data;
	}
	return $size;
}
?>