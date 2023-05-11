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


            }
            else
            {
              header("Location:../index.php");
            }
           

          ?>
          <!-- Create directory -->
          

    <?php require_once("header.php"); ?>
      <div class="container with-fix">
       <input type="" class="input-text" width="100%;" name="" id="stext">
       <div id="res"></div>    
      </div>


      

    </body>
   
    </html>
    <script type="text/javascript" src="../jquery.js"></script>
    <script type="text/javascript">
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
          url:"search_backend.php",
          type:"POST",
          data:{ 'search':search},
          success:function (data,status) {
            $("#res").html(data);
            }
          });
            
          }
        })
      });

      function follow(uid)
        {
        $.ajax({
          url:"search_backend.php",
          type:"POST",
          data:{ user_id:uid },
          success:function (data,status) {
            $("#res").html(data);
          }
        });         
        }
     

      
    </script>