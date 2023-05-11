<!DOCTYPE html>
<html>
    <title>Register | D Cloud</title>
    <head>
    <?php require_once 'require.php'; ?>

    <?php
    session_start();
    if (isset($_SESSION['user']))
    {
        unset($_SESSION['user']);
    } 
    require_once("login_con.php"); 
    ?>
  
    </head>

    <body class="indigo accent-2" style=" background-image: linear-gradient(to right top, #188ea6, #179cb7, #16aac8, #14b8d9, #12c6eb);"><!-- blue-grey lighten-5 background-image: linear-gradient(to left bottom, #188ea6, #137d93, #0f6d80, #0b5d6e, #074e5c);-->    
    <header class="blue fix hide-on-l">    
        <div class="logo left">
            <img src="img/logo_short.png" alt="document cloud"/>
        </div>
        <div class="left" style="padding-top:10px; ">
            <a class="title white-text" href="#" style="width: 200px;  padding-left: 20px;  font-family: 'Open Sans',Condensed Light; ">Document Cloud</a>
          </div>
          <nav class="right">
            <button onclick="dropdown('manu')"></button>
            <div class="nav-ul">              
              <ul id="manu">
              <button id="nav-close" onclick="dropdown_close('manu')"></button>
             <li><a href="index.php" class="white-text">Home</a></li>
             <li><a href="login.php" class="white-text">Sign in</a></li>
             <li><a href="register.php" class="white-text">Register</a></li>
             <li><a href="index.php" class="white-text">About</a></li>
              </ul>
          </div>
          </nav>        
      </header>

      <table class="indigo accent-2" style="width: 100%; height: 100%; position: absolute;">
        <tr>
            <td align="center">
                <div class="white card full-on-s d-depth-4 ani" style=" ">
                    <div class="row">
                    


                        </div>
                        <div class="col-s20 col-l12 col-m12" style="background: rgba(255,255,255,1);">
                          <div class="card depth-0 " >  
                          <div class="card-head grey-text">Login now</div>
                            <div class="card-item" style="margin:10px 20px">
                              <form method="POST" name="login">
                              <input type="email" class="input-text d-depth-1" placeholder="Email-id" name="username" id="username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>"  />
                              <input type="Password" placeholder="Password" class="input-text d-depth-1" name="password" id="password"/>                                
                              <input type="submit" value="Login" class="indigo accent-2 white-text btn-s btn-full d-depth-4"  id="reg" onclick="vali()" name="login">             
                              </form>
                              
                            </div>
                            <div class="card-footer">
                              <span class="blue-text">Lost your Password ?</span> <a href="user/forgot_pass.php"><b>Change now</b></a>
                            </div>
                            </div>  
                           </div>
                            <?php echo $error; ?>
                    </div>
                    
                </div>
                <div style="width: 400px;" class="hide-on-sm manu-ani">
                <nav >
                    <ul>
                    <li><a href="index.php" class="white-text">Home</a></li>
                    <li><a href="login.php" class="white-text">Sign in</a></li>
                    <li><a href="register.php" class="white-text">Register</a></li>
                    <li><a href="index.php" class="white-text">About</a></li>
                    </ul>
                </nav>
                </div>
            </td>
        </tr>
      </table>


      
    </body>

    <script type="text/javascript">
        
       function fun_email()
        {
            if ($("#username").val().length == 0)
            {
                $("#username").css("border-bottom-color","#ff0000");
            }
        }
        function fun_password()
        {
            if ($("#password").val().length == 0)
            {
                $("#password").css("border-bottom-color","#ff0000");
            }
            else if ($("#password").val().length < 8)
            {
                $("#password").css("border-bottom-color","#ff0000");
            }
            else if ($("#password").val().length > 7)
            {
                $("#password").css("border-bottom-color","#008000");
            }
        }
       
        $("#username").keyup(function(){
            fun_email();
        });
        $("#password").keyup(function(){
            fun_email();
            fun_password();
        });
    </script>
</html>  