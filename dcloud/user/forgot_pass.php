<!DOCTYPE html>
<html>
    <title>Register | D Cloud</title>
    <head>
   <?php require_once 'require.php'; ?>
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
    $error = "";

    $style= "display:block";
    if (isset($_POST['verify']))
    {
      $user = htmlentities($_POST['user']);
      if ($user == "") 
      {
        $error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>Enter email id or user name</div>";
      }
      else
      {
        $ck = mysqli_query($con,"SELECT id,username FROM login_user WHERE email='$user' || username='$user' ");
        $ck_num = mysqli_num_rows($ck);
        if ($ck_num >0)
        {
          $uid = mysqli_fetch_assoc($ck);
          
          $user_acco = mysqli_query($con,"SELECT first_name,last_name,profile_pic FROM user_reg WHERE id='$uid[id]' ");
          $user_row = mysqli_fetch_assoc($user_acco);

          
          
          if (!empty($user_row['profile_pic']))
            {
                $profile = 'profile_pic/'.$uid['id'].'/'.$user_row['profile_pic']; 
            }
            else
            {
                $profile = '../img/profile.png';
            } 

          $otp = rand(0,99999999);
        mysqli_query($con,"INSERT INTO otps (id,otp,type) VALUES ('$uid[id]',$otp,'cp')");   
        //This code are remove after email system start
          $link = 'cp.php?uid='.$uid['id'].'&otp='.$otp;

          $error = '<div class="card" style="width: 95%;">
                      <div class="card-item">
                        <img src="'.$profile.'" class="circul" style="height: 60px; width: 60px; border: solid 1px #f7f7f7">
                        <div class="item-head">'.$user_row['first_name'].' '.$user_row['last_name'].'</div>
                        <div class="grey-text darken-2"><b>account are verified. fillout your sequrity answer</b></div>
                    <a href="'.$link.'"><button class="btn-s btn-full blue white-text">Change Password</button></a>   
                    </div>
                    
                    ';
           $style="display:none";         

        
        }
        else
        {
          $error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>Invalid email id or user name</div>";
        } 
         
      }
    }
    ?>
  
    <body style=" background-image: linear-gradient(to right top, #188ea6, #179cb7, #16aac8, #14b8d9, #12c6eb);"><!-- blue-grey lighten-5 background-image: linear-gradient(to left bottom, #188ea6, #137d93, #0f6d80, #0b5d6e, #074e5c);-->    
    <header class="blue fix hide-on-l">    
        <div class="logo left">
            <img src="../img/logo_short.png" alt="document cloud"/>
        </div>
        <div class="left" style="padding-top:10px;  ">
            <a class="title white-text" href="#" style="width: 200px;  padding-left: 20px;  font-family: 'Open Sans',Condensed Light; ">Document Cloud</a>
          </div>
          <nav class="right hide-on-s">
            <ul>
               <li><a href="../index.php" class="white-text">Home</a></li>
               <li><a href="../login.php" class="white-text">Sign in</a></li>
               <li><a href="../register.php" class="white-text">Register</a></li>
               <li><a href="../index.php" class="white-text">About</a></li>
            </ul>
          </nav>        
      </header>

      <table class="with-fix-s indigo accent-2" style="width: 100%; height: 100%; position: absolute;">
        <tr>
            <td align="center">
                <div class="white card full-on-s d-depth-4"  style="width: 400px;  ">
                    <div style="padding:18px 8px 18px 8px; margin-top: -35px; width: 56px; " class="circul blue d-depth-4">
                      <img src="../img/logo_short.png" style="width: 50px; height: auto;">
                    </div>
                    <div style="font-size: 14px; color: #ccc; line-height: 22px; margin-top: 4px;">Document Cloud</div>
                    <div class="card-head">
                      Forgot Password
                    </div>
                    <div class="card-item">
                      <form method="POST" name="login" style="<?php echo $style; ?>">
                          <input type="text" name="user" class="input-text" placeholder="Email / username" value="<?php if(isset($_POST['user'])) echo $_POST['user'] ?>">
                          <input type="submit" class="btn-s indigo accent-2 white-text" name="verify" value="Verify">
                      </form>
                    </div>
                    <?php echo $error;?> 

                </div>
                    
                </div>
                <div style="width: 400px;" class="hide-on-sm">
                <nav >
                    <ul>
                    <li><a href="../index.php" class="white-text">Home</a></li>
                    <li><a href="../login.php" class="white-text">Sign in</a></li>
                    <li><a href="../register.php" class="white-text">Register</a></li>
                    <li><a href="../index.php" class="white-text">About</a></li>
                    </ul>
                </nav>
                </div>
            </td>
        </tr>
      </table>


      
    </body>

    
</html>  