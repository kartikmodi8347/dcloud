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
     
     <?php 
     require_once '../config.php';

     function get_filenum($type)
		{
			global $con;
			$size=0;
			if($type=='image' || $type=='ms' || $type=='extrected' || $type=='pdf' || $type=='other')
			{
					if ($type == 'image')
					{
						$qu = mysqli_query($con,"SELECT * FROM docfile WHERE doc_type='image/png' || doc_type='image/jpg' || doc_type='image/jpeg' || doc_type='image/gif' || doc_type='image/svg' || doc_type='image/ico' || doc_type='image/png' || doc_type='image/bmp' || doc_type='image/ai' ");
						$data = mysqli_num_rows($qu);
							$size = $data;
					}
					if ($type == 'ms')
					{
						$qu = mysqli_query($con,"SELECT * FROM docfile WHERE doc_type='application/vnd.openxmlformats-officedocument.wordprocessingml.document' || doc_type='application/msaccess' || doc_type='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || doc_type='application/vnd.openxmlformats-officedocument.presentationml.presentation' || doc_type='application/vnd.ms-publisher' ");
						$data = mysqli_num_rows($qu);
							$size = $data;
					}
					if ($type == 'pdf')
					{
						$qu = mysqli_query($con,"SELECT * FROM docfile WHERE doc_type='application/pdf' ");
						$data = mysqli_num_rows($qu);
							$size = $data;
					}
					if ($type == 'extrected')
					{
						$qu = mysqli_query($con,"SELECT * FROM docfile WHERE doc_type='application/x-zip-compressed'  || doc_type='application/octet-stream' ");
						$data = mysqli_num_rows($qu);
							$size = $data;
					}
					if ($type == 'other')
					{
						$qu = mysqli_query($con,"SELECT * FROM docfile WHERE doc_type='text/plain' ");
						$data = mysqli_num_rows($qu);
							$size = $data;
						
					}
			}
			
			return $size;
		}
/*     function get_size($type)
		{
			global $con;
			$size=0;
			if($type=='image' || $type=='ms' || $type=='extrected' || $type=='pdf' || $type=='other')
			{
					if ($type == 'image')
					{
						$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='image/png' || doc_type='image/jpg' || doc_type='image/jpeg' || doc_type='image/gif' || doc_type='image/svg' || doc_type='image/ico' || doc_type='image/png' || doc_type='image/bmp' || doc_type='image/ai' ");
						$data = mysqli_fetch_assoc($qu);
							$size = $data['SUM(size)'];
					}
					if ($type == 'ms')
					{
						$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='application/vnd.openxmlformats-officedocument.wordprocessingml.document' || doc_type='application/msaccess' || doc_type='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || doc_type='application/vnd.openxmlformats-officedocument.presentationml.presentation' || doc_type='application/vnd.ms-publisher' ");
						$data = mysqli_fetch_assoc($qu);
							$size = $data['SUM(size)'];
					}
					if ($type == 'pdf')
					{
						$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='application/pdf' ");
						$data = mysqli_fetch_assoc($qu);
							$size = $data['SUM(size)'];
					}
					if ($type == 'extrected')
					{
						$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='application/x-zip-compressed'  || doc_type='application/octet-stream' ");
						$data = mysqli_fetch_assoc($qu);
							$size = $data['SUM(size)'];
					}
					if ($type == 'other')
					{
						$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='text/plain' ");
						$data = mysqli_fetch_assoc($qu);
							$size = $data['SUM(size)'];
						
					}
			}
			else
			{
				$qu = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE doc_type='$type' ");
						$data = mysqli_fetch_assoc($qu);
							$size = $data['SUM(size)'];
			}
			return $size;
		}*/


     ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
         	  ['Format', 'Totals'],
              ['Image',<?php if(get_filenum('image')) echo get_filenum('image'); else echo 0;?>],
              ['PDF',<?php if(get_filenum('pdf')) echo get_filenum('pdf'); else echo 0;?>],
              ['MS office files',<?php if(get_filenum('ms')) echo get_filenum('ms'); else echo 0;?>],
              ['ZIP / RAR',<?php if(get_filenum('extrected')) echo get_filenum('extrected'); else echo 0;?>],
              ['Other',<?php if(get_filenum('other')) echo get_filenum('other'); else echo 0;?>],
        ]);

        var options = {
          title: 'Total Files',
          width: 900,
          legend: { position: 'none' },
          chart: { title: 'Total Files',
                   subtitle: 'Total number of stored files' },
          bars: 'veritical', // Required for Material Bar Charts horizontal.
          axes: {
            x: {
              0: { side: 'top', label: 'Number of files'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
    </script>

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
							
					<div class="row">
						<div class="col-l20 col-s20">
						<input type="text" class="input-text" id="stext" placeholder="Search username">
             			 <div id="res" style="margin-top:20px; "></div>
             			 <div id="datas" style="margin-top:20px; "></div>
					</div>
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

     	function load_data()
    	{	
    		var readrecord = "readrecord";
    		$.ajax({
    			url:"admin_back.php",
    			type:"POST",
    			data:{readrecord: 'readrecord' },
    			success:function (data,status) {
    				$('#datas').html(data);
    			}
    		});
    	}

    $(document).ready(function () {
    	load_data();
        $("#stext").keyup(function () {
          var search = $("#stext").val();
          if($.trim(search.length) == 0)
          {
              $("#res").html('Please enter searching keyword');
          }
          else
          {
              $.ajax({
          url:"admin_back.php",
          type:"POST",
          data:{ 'search':search},
          success:function (data,status) {
            $("#res").html(data);
            }
          });
            
          }
        })
      });

      function add_m(uid)
        {
        $.ajax({
          url:"admin_back.php",
          type:"post",
          data:{'member_id':uid},
          success:function (data,status) {
            $("#res").html(data);
            load_data();
          }
        });         
        }

         function remove_m(uid)
        {
        $.ajax({
          url:"admin_back.php",
          type:"post",
          data:{'r_member_id':uid},
          success:function (data,status) {
            $("#res").html(data);
            load_data();
          }
        });         
        }

      
    </script>
</html>