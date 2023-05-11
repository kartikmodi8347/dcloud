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
	<?php
	if(isset($_GET['grp_id']))
	{
		$group  = mysqli_query($con,"SELECT * FROM `group` WHERE group_id='$_GET[grp_id]' ");
		$grp_num = mysqli_num_rows($group);

		if ($grp_num == 0)
		{
			echo '<meta http-equiv="refresh" content="0;url=../index.php"/>';
		}
		else
		{
			$group_row = mysqli_fetch_assoc($group);
			if(empty($group_row['grp_img']))
			{
				$grp_img = '../user/grp_pic/groups.png';
			}
			else
			{
				$grp_img = '../user/grp_pic/'.$group_row['grp_img'];	
			}
		}
	}
	?>

	 <?php 
      if(isset($_POST['b']))
      {
        $name = htmlentities($_POST['grp_name']);
        $dec = htmlentities($_POST['desc']);
        $type = $_POST['type'];
        $sa = $_POST['sa'];

         if($_FILES['img']['name'] !== '')
            {
            $propic = $_FILES['img']['name'];
            $propic_type=$_FILES['img']['type'];
            $propic_tmp =$_FILES['img']['tmp_name'];
            $propic_size = $_FILES['img']['size'];

                if($propic_type == 'image/png' || $propic_type == 'image/jpg' || $propic_type == 'image/jpeg')
                {
                  if ($propic_size > 0)
                  {
                      $file_name = rand(0,100).$propic;
                      move_uploaded_file($propic_tmp,'../user/grp_pic/'.$file_name);
                      $create = mysqli_query($con,"UPDATE `group` SET `name`='$name',`decs`='$dec',`grp_img`='$file_name',share_allow='$sa',group_type='$type' WHERE group_id='$_GET[grp_id]' ");
                  }
                  else
                  {
                     $error = 'Maximum size ** is required';/****/
                  } 
                }
                else
                {
                    $error = 'Envalid profile picture';             
                }
            } 
            else
            {
              $create = mysqli_query($con,"UPDATE `group` SET `name`='$name',`decs`='$dec',share_allow='$sa',group_type='$type' WHERE group_id='$_GET[grp_id]'");
            }

       
       /* $create2 = mysqli_query($con,"INSERT INTO  group_admin VALUES ('$grp_id','$user','',$time)");
*/
        if($create AND $admin)
        {
          echo '<meta http-equiv="refresh" content="0;url=manag_grp.php"/>';
        }
      }
      ?>
	<table class="main with-fix">
		<tr>
			<td class="hide-on-s side" valign="top">
				<center>
					<?php include_once 'side_manu.php'; ?>
					
				</center>
			</td>
			<td valign="top">
				<div style="width: 94%; margin-left: 3%; margin-top: 2%;">
						<div id="datas">
							
							<div class="card circul-x2 full-on-s" style="width: 100%; margin-top:20px !important; height: auto; margin: 20px 10px 0px 10px ; min-height: 200px; background: rgba(255,255,255,0.6)" >
              <div class="card-head">Edit Group</div>
              
              <div style="padding: 15px; overflow-x: auto;">
                <form method="post" id="form" enctype="multipart/form-data">
                <img src="<?php echo $grp_img; ?>" class="circul" style="height: 100px; width: 100px;" /><br>	
                <input type="button" value="Select icon" id='select_img' class="btn-s blue lighten-4 white-text"/>
                        <input type="file" id="img" name="img" style="display: none;"  />
                	
                <p style="font-size: 12px; margin-top: 20px; color: #999">&nbsp;Group Name</p>
                <input type="text" class="input-text" name="grp_name" value="<?php echo $group_row['name'];?>" placeholder="Group Name" required/>
                <p style="font-size: 12px; margin-top: 20px; color: #999">&nbsp;Description</p>
                <textarea id="dec" name="desc" style="width: 96%; height: 80px; border-bottom-color:#ccc !important; border: 1px solid #f4f4f4;"><?php echo $group_row['decs'];?></textarea>
                <p><span id="charnum" style="font-size: 12px; width: 96%;"></span></p>
                

                <br><br>
                <p style="line-height: 45px; font-size: 14px;">
                  &nbsp;Group Type :
                 <span style="color: #999">&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="type" id="type1" value="private" <?php if($group_row['group_type']=='private') echo 'checked="checked" '; ?> /> Private
                  &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="type" id="type2" value="public" <?php if($group_row['group_type']=='Public') echo 'checked="checked" '; ?>/> Public</span>
                </p>

                <div style="border: 1px solid #f7f7f7; border-radius: 8px; display: block;" id="private">
                    <div style="padding: 10px; font-size: 14px; color: #999">
                    What is private group ?
                    : only admin can allow to add a group members on private group
                    </div>
                </div>
                <div style="border: 1px solid #f7f7f7; border-radius: 8px; display:none;" id="public">
                    <div style="padding: 10px; font-size: 14px; color: #999">
                    What is public group ?
                    : admin can ganarate a group joining invitation link, and user can join a group via link 
                    </div>
                </div>

                <p style="line-height: 45px; font-size: 14px;">
                  &nbsp;Allow Sharing :
                   <span style="color: #999">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="sa" id="admin" value="admin" <?php if($group_row['share_allow']=='admin') echo 'checked="checked" '; ?>/> Only Admin
                  &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sa" id="both" value="both" <?php if($group_row['share_allow']=='both') echo 'checked="checked" '; ?>/> Both Admin And Member</span>
                </p>

                <div style="border: 1px solid #f7f7f7; border-radius: 8px; display: none;" id="adminmsg">
                    <div style="padding: 10px; font-size: 14px; color: #999">
                    Only admin can share a documents on group
                    </div>
                </div>
                <div style="border: 1px solid #f7f7f7; border-radius: 8px; display:block;" id="bothmsg">
                    <div style="padding: 10px; font-size: 14px; color: #999">
                    Admin and member both can share a documents on group
                    </div>
                </div>
                <br>
                <input type="submit" name="b" class="btn-s blue white-text" value="Save">

                </form>
             </div>
          	
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
        $('#select_img').click(function(){
        $("#img").trigger('click');
      });
      $(document).ready(function ($) {
        
        $("#type1").click(function () {
          $("#private").css("display","block");
          $("#public").css("display","none");
        });

        $("#type2").click(function () {
          $("#private").css("display","none");
          $("#public").css("display","block");
        });



        $("#admin").click(function () {
          $("#adminmsg").css("display","block");
          $("#bothmsg").css("display","none");
        });

        $("#both").click(function () {
          $("#adminmsg").css("display","none");
          $("#bothmsg").css("display","block");
        });
      });

      $("#dec").keyup(function(){
        var max = 150;
        var len = $(this).val().length;
        if (len >= max)
        {
          $("#charnum").css('color','red');
          $(this).css('border-bottom-color','red');          
          $("#charnum").text('You have reached the limit');
          $("#form").submit(function(e){
            return false;
          });
        }
        else
        {
          var char = max-len;
          $("#charnum").text(char+' Letter remin');

          $("#charnum").css('color','');
          $(this).css('border-bottom-color','');
        }
      });
    </script>
</html>