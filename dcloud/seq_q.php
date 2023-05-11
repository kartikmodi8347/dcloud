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
    require_once("config.php");
    session_start();
    $user = $_SESSION['user'];

    $error = "";
    if (isset($_POST['verify']))
    {
     	if($_POST['qua'] == "")
     	{	
        	$error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>Select quation</div>";
        }
        elseif (empty($_POST['ans']))
        {
          $error = "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>Ans can't be blank</div>";
        }
       	else
       	{
       		$qua = $_POST['qua'];
       		$ans = htmlspecialchars(htmlentities($_POST['ans']));
       		$ins = mysqli_query($con,"INSERT INTO `sec_q`(`id`, `quation`, `ans`) VALUES ('$user','$qua','$ans')");
       		if($ins)
       		{
       			echo '<meta http-equiv="refresh" content="0;url=user/home.php"/>';
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
            <li><a href="../index.php" class="white-text">Home</a></li>
            <li><a href="login.php" class="white-text">Sign in</a></li>
            <li><a href="register.php" class="white-text">Register</a></li>
            <li><a href="" class="white-text">Search</a></li>
            <li><a href="" class="white-text">About</a></li>
            </ul>
          </nav>        
      </header>

      <table class="with-fix-s" style="width: 100%; height: 100%; position: absolute; background-image: linear-gradient(to right top, #188ea6, #179cb7, #16aac8, #14b8d9, #12c6eb);">
        <tr>
            <td align="center">
                <div class="white card full-on-s d-depth-4"  style="width: 400px;  ">
                    <div style="padding:18px 8px 18px 8px; margin-top: -35px; width: 56px; height: 46px; " class="circul blue d-depth-4">
                      <img src="img/logo_short.png" style="width: 40px; height: 40px;">
                    </div>
                    <div style="font-size: 14px; color: #ccc; line-height: 22px; margin-top: 4px;">Document Cloud</div>
                    <div class="card-head">
                      Sequrity Quation
                    </div>
                    <div class="card-item">
                      <form method="POST" name="login">
                      	<select class="input-text" style="width: 98%;" name="qua">
                      		<option selected="selected">Select quation..</option>
                      		<option value="Favourit food">Favourit food</option>
                      		<option value="Favourit pet">Favourit pet</option>
                      		<option value="Favourit aunt">Favourit aunt</option>
                      		<option value="Favourit teacher">Favourit teacher</option>
                      	</select>
                          <input type="text" name="ans" class="input-text" placeholder="Your answer.." value="<?php if(isset($_POST['user'])) echo $_POST['user'] ?>">
                             <input type="submit" class="btn-s blue white-text" name="verify" value="Verify">
                      </form>
                    </div>
                    <?php echo $error;?> 

                </div>
                    
                </div>
                <div style="width: 400px;" class="hide-on-sm">
                <nav >
                    <ul>
                    <li><a href="index.php" class="white-text">Home</a></li>
                    <li><a href="login.php" class="white-text">Sign in</a></li>
                    <li><a href="register.php" class="white-text">Register</a></li>
                    <li><a href="" class="white-text">About</a></li>
                    </ul>
                </nav>
                </div>
            </td>
        </tr>
      </table>


      
    </body>

    
</html>  