<!DOCTYPE html>
<html>
    <title>Register | D Cloud</title>
    <head>
    <!--Import Master-Css-->
    <link href="../../master-css/master-css/css/master-css.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initialscale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    
    <style type="text/css">
        body{
            
        }
         .manu-ani{
            -moz-animation-duration: 2s;
            -webkit-animation-duration: 2s;
            -moz-animation-name: slidein1;
            -webkit-animation-name: slidein1;
         }
         @-moz-keyframes slidein1 {
            from {
           	 	margin-top: 100%;
            }
            
            to {
                margin-top:0%;

            }
         }
         @-webkit-keyframes slidein1 {
            from {
           	 	margin-top: 100%;
            }
            
            to {
                margin-top:0%;

            }
         }

         

      </style>
    </head>
    

    <?php
     require_once("../config.php");
      $error = '';
      if(isset($_POST['save']))
      {
        $pass = htmlentities($_POST['pass']);
        $repass = htmlentities($_POST['re-pass']);
        if (isset($pass) AND isset($repass))
        {
            if (strlen($pass) <= 7)
            {
                $error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff; margin-top:8px;'>Enter minimum 8 digit password</div>";
            }
            elseif ($pass == $repass)
            {
                $new_pass = sha1(md5($pass));
                $passok = mysqli_query($con,"UPDATE login_user SET pass='$new_pass' WHERE id='$user' ");
                if ($passok) {
                	mysqli_query($con,"UPDATE otps SET status='yes',visited='yes' WHERE id='$user' AND otp='$otp' ");
                header('location:../login.php');
                }
                
            }
            else
            {
                $error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff; margin-top:8px;'>Re-password are not same</div>";               
            }
        }
      }
    ?>
    <body style=" background-image: linear-gradient(to right top, #188ea6, #179cb7, #16aac8, #14b8d9, #12c6eb);"><!-- blue-grey lighten-5 background-image: linear-gradient(to left bottom, #188ea6, #137d93, #0f6d80, #0b5d6e, #074e5c);-->    
    <header class="blue fix hide-on-l">    
        <div class="logo left">
            <img src="../img/logo_short.png" alt="document cloud"/>
        </div>
        <div class="left" style="padding-top:10px; ">
            <a class="title white-text" href="#" style="width: 200px;  padding-left: 20px;  font-family: 'Open Sans',Condensed Light; ">Document Cloud</a>
          </div>
          <nav class="right hide-on-s">
            <ul>
            <li><a href="../home.php" class="white-text">Home</a></li>
            <li><a href="../login.php" class="white-text">Sign in</a></li>
            <li><a href="../register.php" class="white-text">Register</a></li>
            <li><a href="../home.php" class="white-text">About</a></li>
            </ul>
          </nav>        
      </header>

      <table class="with-fix-s indigo accent-2" style="width: 100%; height: 100%; position: absolute;">
        <tr>
            <td align="center">
                <div class="white card full-on-s d-depth-4"  style="width: 400px;  ">
                    <div style="padding:18px 8px 18px 8px; margin-top: -35px; width: 56px; " class="round blue d-depth-4">
                      <img src="../img/logo_short.png" style="width: 50px; height: auto;">
                    </div>
                    <div style="font-size: 14px; color: #ccc; line-height: 22px; margin-top: 4px;">Document Cloud</div>
                    <div class="card-head">
                      Change Password
                    </div>
                    <div class="card-item">

                    	<?php 
   
    $msg ='';
    $style_cp= 'display:none';
    if (isset($_GET['uid']) && isset($_GET['otp']))
    {
      $user =  $_GET['uid'];
      $otp = $_GET['otp']; 

      echo "step  1 ok";

      $ck = mysqli_query($con,"SELECT * FROM otps WHERE (id='$user'AND otp='$otp' AND type='cp') ");
      $num = mysqli_num_rows($ck);

        if ($num == 1)
        {
        	echo "step  2 ok";
          mysqli_query($con,"UPDATE otps SET visited='yes' WHERE id='$user' AND otp='$otp' ");

          $user_acco = mysqli_query($con,"SELECT first_name FROM user_reg WHERE id='$user' ");
          $user_row = mysqli_fetch_assoc($user_acco);


                   $style= 'display:block';
                    
                    $sq = mysqli_query($con,"SELECT * from sec_q WHERE id='$_GET[uid]' ");
                    $sq_num = mysqli_num_rows($sq);
                    if($sq_num == 1)
                    {
                        $sec = mysqli_fetch_assoc($sq);
                    }
                    else
                    {
                      echo '<meta http-equiv="refresh" content="0;url=../login.php"/>';
                    }

                    if (isset($_POST['ansveri']))
                    {
                     
                      if ($_POST['ans'] == $sec['ans'])
                      {
                           $style= 'display:none';
                           $msg = '<div class="grey-text darken-2" style="'.$style_cp.'">Welcome <span class="black-text"><b>'.$user_row['first_name'].'</b></span>. your password changing request are sucseed. now you can change your password</div>
                      <form method="POST" name="login">
                          <input type="password" name="pass" id="pass" class="input-text" placeholder="New Password">
                          <input type="password" name="re-pass" id="re-pass" class="input-text" placeholder="Re-type">
                          <input type="submit" class="btn-s blue white-text" name="save" value="Save">
                      </form>';
                      }
                      else
                      {
                        $msg = "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>Wrong answer</div>";
                      }
                    }
          
        }
        else {
           $msg = '<div class="grey-text darken-2">Sorry, this link are expired</div>';
         } 
    }
    else
    {
      $msg = '<div class="grey-text darken-2">Sorry, this link are expired</div>';
    }
    
    ?>

   				 <?php 
                  /*  $sq = mysqli_query($con,"SELECT * from sec_q WHERE id='$_GET[uid]' ");
                    $sq_num = mysqli_num_rows($sq);
                    if($sq_num == 1)
                    {
                        $sec = mysqli_fetch_assoc($sq);
                    }*/
                  ?>
                        <form method="POST" name="login" style="<?php echo $style;?>">
                        What`s your <span style="text-transform: lowercase;"><?php echo $sec['quation']; ?></span> ?
                        <input type="text" class="input-text" name="ans" placeholder="Your answer.."/>
                        <input type="submit" value="Verify answer" name="ansveri" class="btn-s btn-full indigo accent-2 white-text"/>
                        </form>
                      <?php echo $msg; ?>
                      <?php echo $error; ?> 

                </div>
                    
                </div>
                <div style="width: 400px;" class="hide-on-sm">
                <nav >
                    <ul>
                    <li><a href="../home.php" class="white-text">Home</a></li>
                    <li><a href="../login.php" class="white-text">Sign in</a></li>
                    <li><a href="../register.php" class="white-text">Register</a></li>
                    <li><a href="../home.php" class="white-text">About</a></li>
                    </ul>
                </nav>
                </div>
            </td>
        </tr>
      </table>


      
    </body>
    
    <!--Import jquery using google CDN-->
    <script src="../jquery.js"></script>
              
    <!--Import master-css script file-->
    <script type="text/javascript" src="../master-css/master-css/script/master-css.js"></script>
    <script type="text/javascript">

        function fun_password()
        {
            if ($("#pass").val().length == 0)
            {
                $("#pass").css("border-bottom-color","#ff0000");
            }
            else if ($("#pass").val().length < 8)
            {
                $("#pass").css("border-bottom-color","#ff0000");
            }
            else if ($("#pass").val().length > 7)
            {
                $("#pass").css("border-bottom-color","#008000");
            }
        }
        function re_pass()
        {
          if($("#re-pass").val().length == 0)
          {
            $("#re-pass").css("border-bottom-color","#ff0000");
          }
          else if ($("#pass").val() == $("#re-pass").val())
          {
            $("#re-pass").css("border-bottom-color","#008000");        
          }
          else
          {
            $("#re-pass").css("border-bottom-color","#ff0000");            
          }
        }
              
        
        $("#pass").keyup(function(){
            fun_password();
        });
        $("#re-pass").change(function(){
            fun_password();
            re_pass();
            
        })

    </script>
    
</html>  