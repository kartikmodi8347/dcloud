<!DOCTYPE html>
<html>
    <title>Register | D Cloud</title>
    <head>
    
    <?php require_once 'require.php'; ?>

    <?php require_once("reg_con.php"); ?>
 
    </head>

    <body style=" background-image: linear-gradient(to right top, #188ea6, #179cb7, #16aac8, #14b8d9, #12c6eb);"><!-- blue-grey lighten-5 background-image: linear-gradient(to left bottom, #188ea6, #137d93, #0f6d80, #0b5d6e, #074e5c);-->    
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

      <table class="with-fix-s with-fix-m indigo accent-2" style="width: 100%; height: 100%; position: absolute; ">
        <tr>
            <td align="center">
                <div class="white card full-on-s d-depth-4 ani" style="width: 500px">
                    <div class="row">



                    </div>
                        <div class="col-s20 col-l12 col-m12" style="background: rgba(255,255,255,1);">
                          <div class="card depth-0">  
                          <div class="card-head grey-text">Register now for free</div>
                            <div class="card-item" style="margin:10px 20px">
                              <form method="POST" name="reg">
                              <input type="text" class="input-text" placeholder="First Name" name="fname" id="fname" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>"/>
                              <input type="text" class="input-text" placeholder="Last Name" name="lname" id="lname" value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; ?>"/>
                              <input type="email" class="input-text" placeholder="Email Id" name="email" id="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"/>
                              <input type="Password" placeholder="Password" class="input-text " name="password" id="password"/>
                              <span class="item-head" style="line-height: 20px;">Date of birth</span>
                              <span ><input type="date" placeholder="Password" class="input-text " id="dob" name="dob" max="<?php echo date('Y')-18;?>-01-01" /></span>
                              
                              <span class="item-head"  >Gender</span>
                              
                              <input type="radio" name="gen" value="male" id="gen">Male
                              <input type="radio" name="gen" value="female" id="gen">Female
                            <div>
                              <input type="submit" value="Sign up" class="indigo accent-2 white-text btn-s btn-full "  id="reg" name="sub">
                                
                            </div>                      
                              </form>

                            </div>

                            </div>  
                         </div>
                         <?php echo "<div class='red' style='line-height:35px; font-size:14px; color:#fff;'>".$error."</div>"; ?>
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
        
        function fun_fname()
        {
            if ($("#fname").val().length == 0)
            {
                $("#fname").css("border-bottom-color","#ff0000");
            }
            
        }

        function fun_lname()
        {
            if ($("#lname").val().length == 0)
            {
                $("#lname").css("border-bottom-color","#ff0000");
            }
            
        }
        function fun_email()
        {
            if ($("#email").val().length == 0)
            {
                $("#email").css("border-bottom-color","#ff0000");
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
        function fun_date()
        {
            if($("#dov").val() == "undefined")
            {
                $("#dov").css("border-bottom-color","#ff0000");
            }
        }      
        $("#fname").keyup(function (){
            $("#fname").css("border-bottom-color","");
        });

        $("#lname").keyup(function (){
            fun_fname();
            $("#lname").css("border-bottom-color","");
        });
        $("#email").keyup(function (){
            fun_fname(this);
            fun_lname(this);
            $("#email").css("border-bottom-color","");
        });
        $("#password").keyup(function(){
            fun_fname();
            fun_lname();
            fun_email();
            fun_password();
        });
        $("#gen").change(function(){
            fun_date();
            
        })

    </script>
</html>  