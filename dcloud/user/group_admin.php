<!DOCTYPE html>
<html>
    <title>Share View</title>
    <head>
    <?php require_once 'require.php'; ?>

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

              $acheck_q = mysqli_query($con,"SELECT admin_id FROM group_admin WHERE admin_id='$user' ");
              $acheck_row = mysqli_num_rows($acheck_q);

              if($acheck_row == 0)
              {
                echo '<meta http-equiv="refresh" content="0;url=home.php/"/>';
              }
         
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
              $check2 = mysqli_query($con,"SELECT `group_id` FROM `group_member` WHERE member_id='$user' && group_id='$grp_id'");
              $check2_row = mysqli_num_rows($check2);



              if ($check1_row==0)
              {
                  header("Location:../home.php");
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
      <div class="container with-fix">
           <div class="row">
            <div class="col-l20">
                <div class="card depth-0" style="width: 100%; margin-top: 20px; border-radius: 4px 4px 0 0;">
                  <div class="blue lighten-1 d-depth-2" style="height: 60px;border-radius: 4px 4px 0 0; width: 100%;" id="user_head">
                  </div>
                  <img src="<?php echo $grp_img; ?>" style="height: 60px; width: 60px; margin-top:  -30px; background: #FFF; border:1px solid #f7f7f7; margin-left: 40px;" class="circul d-depth-1">                
                    <div style="line-height: 25px; font-size: 14px; color: #fff; margin: -60px 0 0 110px;"><b><a href="group/<?php echo $grp_row['group_id'] ?>">
                      <?php echo $grp_row['name']; ?></a>
                    </b></div>

                </div>
                            
            </div>
          </div>

      <div class="row">
        <div class="col-l5 hide-on-s">
          <?php
          $admins = mysqli_query($con,"SELECT * FROM group_admin WHERE group_id='$grp_id' ");
              $admin_num  = mysqli_num_rows($admins);
           ?>
          <div class="card d-depth-2 circul-x1 full-on-l full-on-s" style="margin-top: 40px !important;" id="adminbox">            
              <!-- admin are from member_admin.php -->
          </div>
           <?php 
          $members = mysqli_query($con,"SELECT * FROM group_member WHERE group_id='$grp_id' ");
              $num_m = mysqli_num_rows($members);
          ?>
          <div class="card d-depth-2 circul-x1 full-on-l full-on-s" style="margin-top: 10px !important;" id="memberbox">            
             <!-- admin are from member_admin.php -->
          </div>
          <button class="btn-s blue white-text btn-full" onclick="leave_m('<?php echo $user; ?>')">Leave Group</button>
        </div>




        <div class="col-l15">
          <div class="card d-depth-2 circul-x1 full-on-s right" style="margin-top: 40px !important; width: 98%;">
            <div class="card-head">Add Admin</div>            
            <div class="card-item" style="margin-bottom: 0px; max-height: 550px; overflow-y: auto;">
              <input type="text" class="input-text" id="stext" placeholder="Search username">
              <div id="res" style="margin-top:20px; "></div>
            </div>
 
          </div>
        </div>
      </div>
    </div>


      

    </body>
   
    </html>
    <script type="text/javascript" src="../jquery.js"></script>
    <script type="text/javascript">

    function load_admin()
    {
         $.ajax({
          url:"member_admin.php",
          type:"POST",
          data:{type:'admin','ids':<?php echo $grp_id;?>},
          success:function (data,status) {
            $("#adminbox").html(data);
            }
          });
    }
    function load_member()
    {
         $.ajax({
          url:"member_admin.php",
          type:"POST",
          data:{type:'member','ids':<?php echo $grp_id;?>},
          success:function (data,status) {
            $("#memberbox").html(data);
            }
          });
    }
    load_member();
    load_admin();


    $(document).ready(function () {
        $("#stext").keyup(function () {
          var search = $("#stext").val();
          if($.trim(search.length) == 0)
          {
              $("#res").html('Please enter searching keyword');
          }
          else
          {
              $.ajax({
          url:"group_admin_back.php?grp_id=<?php echo $grp_id; ?>",
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
          url:"group_admin_back.php?grp_id=<?php echo $grp_id; ?>",
          type:"post",
          data:{'member_id':uid},
          success:function (data,status) {
            $("#res").html(data);
            load_admin();
            load_member();
          }
        });         
        }

      function remove_m(uid)
        {
        $.ajax({
          url:"group_admin_back.php?grp_id=<?php echo $grp_id; ?>",
          type:"post",
          data:{'remove_id':uid},
          success:function (data,status) {
            $("#res").html(data);
            load_admin();
            load_member();
          }
        });         
        }
        
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