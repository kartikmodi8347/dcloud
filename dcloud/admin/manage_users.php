<!DOCTYPE html>
<html>
<head>
	<title>Admin Area</title>
	<!--Import Google Font-->
    <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet"> 

    <!--Import Master-Css-->
    <link href="../master-css/css/master-css.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include("header.php"); ?>

	<table class="main with-fix">
		<tr>
			<td class="hide-on-s side" valign="top">
				<center>
					<?php include_once 'side_manu.php'; ?>
					
				</center>
			</td>
			<td valign="top">
				<div style="width: 94%; margin-left: 3%; margin-top: 2%;">
							<div style="display: none;">
								<?php
									require_once '../config.php';
									$login_i = mysqli_query($con,"SELECT * FROM login_user WHERE role='User' ");
									$user_num = mysqli_num_rows($users);
									if ($user_num == 0) {$user_num = 0;}

									
								?>
							</div>
				
						<div id="datas">
							
						</div>
					</div>
				</div>
			</td>
		</tr>
		<!-- <tr>
			<td colspan="2" height="80">Hello</td>
		</tr> -->
	</table>
</body>
<script src="../jquery.js"></script>
              
    <!--Import master-css script file-->
    <script type="text/javascript" src="../master-css/script/master-css.js"></script>
    <script type="text/javascript">
    	/*$('#datas').load("manage_user_backend.php");*/
    	$(document).ready(function(){
    		load_data();
    	});
    	
    	function load_data()
    	{	
    		var readrecord = "readrecord";
    		$.ajax({
    			url:"manage_user_backend.php",
    			type:"POST",
    			data:{ readrecord: 'readrecord' },
    			success:function (data,status) {
    				$('#datas').html(data);
    			}
    		});
    	}

    		function block(uid)
    		{
				$.ajax({
    			url:"manage_user_backend.php",
    			type:"POST",
    			data:{ user_id_b:uid },
    			success:function (data,status) {
    				load_data();
    			}
    		});    			
    		}
    	
    		function unblock(uid)
    		{
				$.ajax({
    			url:"manage_user_backend.php",
    			type:"POST",
    			data:{ user_id_ub:uid },
    			success:function (data,status) {
    				load_data();
    			}
    		});    			
    		}

    		function deleteu(uid)
    		{

				$.ajax({
    			url:"manage_user_backend.php",
    			type:"POST",
    			data:{ user_id_delete:uid },
    			success:function (data,status) {
    				
    				load_data();
    			}
    		});    			
    		}
    </script>
</html>