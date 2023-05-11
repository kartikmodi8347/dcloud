<!DOCTYPE html>
<html>
    <title>Share View</title>
    <head>
   
    <?php require 'require.php'; ?>

    <style type="text/css">
        body{
            /*background-image: url(../img/pexels-photo-14675.jpeg);
            background-size: cover;*/ 
        }
       .dirlink {
          font-size: 14px;
          color: #333;
        }
        .dirlink:hover {
          color:#ccc;
        }
        .div {
          width: 100%;
          height: 100%;
          background: rgba(0,0,0,0.4);
          position: fixed;
         
          /*display: none;*/
          left: 0;
          top: 0;}


        
      </style>
    </head>

    <body>
      <?php
      		$error = "";
            require_once("../config.php");
            require_once("size_conv.php");
            require_once("dir_info.php");
            
            if(isset($_GET['grp_id']))
            {
              $grp_id = $_GET['grp_id'];
              $group_iq = mysqli_query($con,"SELECT * FROM `group` WHERE `group_id`='$grp_id' ");
              $grp_row = mysqli_fetch_assoc($group_iq);
            }
            else
            {
              header("Location:../user/groups.php");
            }

            session_start();
            if (isset($_SESSION['user']))
            {
              
              $user = $_SESSION['user'];

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


              $check1 = mysqli_query($con,"SELECT `group_id` FROM `group_admin` WHERE `admin_id`='$user' && group_id='$grp_id' ");
              $check1_row = mysqli_num_rows($check1);
              $check2 = mysqli_query($con,"SELECT * FROM group_member  WHERE `member_id`='$user' && group_id='$grp_id' ");
              $check2_row = mysqli_num_rows($check2);



              if (($check1_row==0) AND ($check2_row==0))
              {
                  header("Location:home.php");
              }
            }
            else
            {
              header("Location:../index.php");
            }


            

           

          ?>
          <!-- Create directory -->
          
        <?php
        if(!empty($grp_row['grp_img']))
        {
          $grp_img='grp_pic/'.$grp_row['grp_img'];
        }
        else
        {
          $grp_img='grp_pic/groups.png';          
        }
        ?>
    <?php require_once("header.php"); ?>
      <div class="with-fix">
           <div class="row">
            <div style="width: 99%; margin-left: .5%;">
                <div class="card depth-0" style="width: 100%; margin-top: 20px; border-radius: 4px 4px 0 0;">
                  <div class="indigo accent-2" style="height: 60px;border-radius: 4px 4px 0 0; width: 100%;" id="user_head">
                  </div>
                  <img src="<?php echo $grp_img;?>" style="height: 60px; width: 60px; margin-top:  -30px; background: #FFF; border:1px solid #f7f7f7; margin-left: 40px;" class="circul d-depth-1">                
                    <div style="line-height: 25px; font-size: 14px; color: #fff; margin: -60px 0 0 110px;"><b>
                      <?php echo $grp_row['name']; ?> 
                      <?php if($check1_row == 1)
                      {
                        echo'<a href="group_edit.php?grp_id='.$grp_id.'"><button class="btn-s right">Edit</button>'; 
                         
                      }
                      if ($grp_row['group_type']=='Public')
                        {
                          echo 11;
                          echo '<a href="group_join_link.php?grp_id='.$grp_id.'"><button class="btn-s right">Invite link</button></a>';
                        } 
                      ?>
                    </b></div>

                </div>
                            
            </div>
          </div>

      <div class="row" style="margin-left:2%; ">
        <div class="col-l4 hide-on-s">
          <?php 
          $admins = mysqli_query($con,"SELECT * FROM group_admin WHERE group_id='$grp_id' ");
              $admins_n = mysqli_num_rows($admins);
              ?>
          <div class="card d-depth-2 circul-x1 full-on-l full-on-s" style="margin-top: 40px !important; ">            
            <div class="card-head">Admin <span style="color: #ccc; float: right; margin-right: 10px;"><?php echo $admins_n; ?></span></div>
            <div class="card-item" style="max-height: 200px; overflow-y:auto;">
              <?php

              while($admin_row = mysqli_fetch_assoc($admins))
              {
                
                $adq = mysqli_query($con,"SELECT * FROM user_reg WHERE id='$admin_row[admin_id]' "); 
                $ad_info = mysqli_fetch_assoc($adq);
                $login_uq = mysqli_query($con,"SELECT username FROM login_user WHERE id='$admin_row[admin_id]' "); 
                $login_urow = mysqli_fetch_assoc($login_uq);

              if (!empty($ad_info['profile_pic']))
              {
                  $ad_pic_path = 'profile_pic/'.$admin_row['admin_id'].'/'.$ad_info['profile_pic']; 
              }
              else
              {
                  $ad_pic_path = '../img/profile.png';
              }


                echo'<table style="border:0; width:100%;">
                  <tr>
                    <td width="50" align="center"><img class="circul" src="'.$ad_pic_path.'" style="height:45px; width:45px;"/></td>
                    <td vlign="top" align="left">
                    <p><b>'.$ad_info['first_name'].' '.$ad_info['last_name'].'</b></p>
                    <p style="font-size:12px; color:#ccc;">'.$login_urow['username'].'</p>
                    </td>
                  </tr>
                </table>';
              }

               ?>
        
            </div>
            <?php
            if ($check1_row == 1)
            {
            echo '<div class="card-footer">
              <a href="add_admin/'.$grp_id.'"><button class="btn-s btn-full indigo white-text"><span class="fa fa-group"></span> Add Admin</button></a>
            </div>';  
          }
            ?>     
          </div>
          <?php 
          $members = mysqli_query($con,"SELECT * FROM group_member WHERE group_id='$grp_id' ");
              $num_m = mysqli_num_rows($members);
          ?>
          <div class="card d-depth-2 circul-x1 full-on-l full-on-s" style="margin-top: 10px !important; ">            
            <div class="card-head">Members <span style="color: #ccc; float: right; margin-right: 10px;"><?php echo $num_m; ?></span></div>
            <div class="card-item" style="max-height: 250px; overflow-y:auto;">
              <?php

              while($member_row = mysqli_fetch_assoc($members))
              {
                
                $adq = mysqli_query($con,"SELECT * FROM user_reg WHERE id='$member_row[member_id]' "); 
                $m_info = mysqli_fetch_assoc($adq);
                $login_mq = mysqli_query($con,"SELECT username FROM login_user WHERE id='$member_row[member_id]' "); 
                $login_mrow = mysqli_fetch_assoc($login_mq);

              if (!empty($m_info['profile_pic']))
              {
                  $m_pic_path = 'profile_pic/'.$member_row['member_id'].'/'.$m_info['profile_pic']; 
              }
              else
              {
                  $m_pic_path = '../img/profile.png';
              }


                echo'<table style="border:0; width:100%;">
                  <tr>
                    <td width="50" align="center"><img class="circul" src="'.$m_pic_path.'" style="height:45px; width:45px;"/></td>
                    <td vlign="top" align="left">
                    <p><b>'.$m_info['first_name'].' '.$m_info['last_name'].'</b></p>
                    <p style="font-size:12px; color:#ccc;">'.$login_mrow['username'].'</p>
                    </td>
                  </tr>
                </table>';
              }

               ?>
            </div>
            <?php
            if ($check1_row == 1)
            {
            echo '<div class="card-footer">
              <a href="add_member/'.$grp_id.'"><button class="btn-s btn-full indigo white-text"><span class="fa fa-group"></span> Add Members</button></a>
            </div>';
            }  
            ?>             
          </div>
          <button class="btn-s indigo accent-2 white-text btn-full" onclick="leave_m('<?php echo $user; ?>')">Leave Group</button>

        </div>



        <div class="col-l15">

          <div class="card d-depth-2 circul-x1 full-on-s right" style="margin-top: 40px !important; width: 98%;">
           
            <div class="card-item" style="margin-bottom: 0px; max-height: 550px; overflow-y: auto;" id="message">
              <!-- data area -->
            </div>
            
            <div class="card-footer">
            <?php
            //i am admin or not
                        
            if($grp_row['share_allow']=='admin')
            {
                $iadmin = mysqli_query($con,"SELECT * FROM group_admin WHERE group_id='$grp_id' AND admin_id='$user' ");
                $admin_n= mysqli_num_rows($iadmin);
                if ($admin_n == 1)
                {
                    echo '<table style="border: 0; width: 100%;">
                          <tr>
                            <td width="88%"><textarea id="msg" style="width: 98%; height: 80px;"></textarea></td>
                            <td><button id="send_msg" style="height: 80px !important; width: 98%; margin-top: -4px;" class="grey-blue grey-text text-darken-2 btn-s"><span class="fa fa-arrow-right fa-4x"></span></button></td>
                          </tr>
                        </table>';    
                }
                else
                {
                  echo '<center>only admin can allow to send messages</center>';
                }
            }
            else
            {
                 echo '<table style="border: 0; width: 100%;">
                          <tr>
                            <td width="88%"><textarea id="msg" style="width: 98%; height: 80px;"></textarea></td>
                            <td><button id="send_msg" style="height: 80px !important; width: 98%; margin-top: -4px;" class="grey-blue grey-text text-darken-2 btn-s"><span class="fa fa-arrow-right fa-4x"></span></button></td>
                          </tr>
                        </table>';              
            }
            ?>
            </div> 
          </div>
        </div>
      </div>
    </div>


      

    </body>
   
    </html>
    <script type="text/javascript" src="../jquery.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        load_msg();
        $("#msg").scrollTop($("#msg")[0].scrollHeight);
      });

      function load_msg() {
        setInterval(function(){
		$("#message").load('group_profile_backend.php?grp_id=<?php echo $grp_id; ?>'),fadeIn("slow");
		},1000);
      }

      $("#send_msg").click(function() {
        var msg =  $("#msg").val();
        $.ajax({
          url:"group_profile_backend.php?grp_id=<?php echo $grp_id; ?>",
          type:"POST",
          data:{'msg_text':msg},
          success:function (data,status) {
            $("#msg").val("");
            load_msg();
          }
        });

      });

 function leave_m(uid)
        {
        $.ajax({
          url:"group_addm_backend.php?grp_id=<?php echo $grp_id; ?>",
          type:"post",
          data:{'remove_id':uid},
          success:function (data,status) {
            $("#res").html(data);
            //user is a member of group 
            window.location.href='groups.php';
             
             }
          
        });         
        }      
      
    </script>