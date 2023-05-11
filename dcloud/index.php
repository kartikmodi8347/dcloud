<!DOCTYPE html>
<html>
    <head>
    
    <?php require_once 'require.php'; ?>
    <style type="text/css">
        /*body{
            background-image: linear-gradient(to right top, #188ea6, #179cb7, #16aac8, #14b8d9, #12c6eb);
        }*/
        .main-con {
            -moz-animation-name: main;
            -moz-animation-duration: 1s;
            -webkit-animation-name: main;
            -webkit-animation-duration: 1s;
        }
        @-moz-keyframes main{
            from {
                margin-top: -500px; 
            }
            to{
                margin-top: ;
            }

        }
        @-webkit-keyframes main{
            from {
                margin-top: -500px; 
            }
            to{
                margin-top: ;
            }

        }
        .content-ani {
            -moz-animation-name: con-ani;
            -moz-animation-duration: 3s;
            animation-name: con-ani;
            animation-duration: 3s;
        }
        
        @keyframes con-ani{
            from {
                margin-top: 100%; 
                transform:rotateZ(60deg);
                width:;
            }
            to{
                margin-top: ;
                transform:rotateZ(0deg);
                width: ;
            }

        }
    </style>
    </head>

    <body class="blue-grey lighten-5">
    <header class="fix indigo accent-2" id="header">
	    <div class="container">    
	        <div class="logo left">
	            <img src="img/logo_short.png" alt="document cloud"/>
	        </div>
	        <div class="left" style="padding-top:10px; ">
	            <a class="title white-text" href="#" style="width: 200px;  padding-left: 20px; font-width:100;  font-family: 'Open Sans',Condensed Light;">Document Cloud</a>
	        </div>
	          <nav class="right">
	          	<button onclick="dropdown('manu')"></button>
	          	<div class="nav-ul">          		
		            <ul id="manu">
			            <button id="nav-close" onclick="dropdown_close('manu')"></button>
			            <li><a href="#home" class="white-text">Home</a></li>
			            <li><a href="login.php" class="white-text">Sign in</a></li>
			            <li><a href="register.php" class="white-text">Register</a></li>
                  <?php
                  session_start();
                  require_once 'login_con.php';
                  if (isset($_SESSION['user']))
                  {
                    require_once 'config.php';

                    $reg = mysqli_query($con,"SELECT * FROM user_reg WHERE id='$_SESSION[user]' ");
                    $reg_row = mysqli_fetch_assoc($reg);
                    if (!empty($reg_row['profile_pic']))
                    {
                        $pro_pic_path = 'user/profile_pic/'.$_SESSION['user'].'/'.$reg_row['profile_pic']; 
                    }
                    else
                    {
                        $pro_pic_path = 'img/profile.png';
                    }  

                    echo' 
                        <li class="hide-on-sm"><a href="" class="white-text"><img src="'.$pro_pic_path.'" style="height: 25px; width: 25px; border-radius: 50%; background: #fff; margin-bottom: -8px;"/> Me <span></span></a>
                          <ul>
                            <li><a href="user/home.php" class="white-text">Home</a></li>
                            <li><a href="user/fs_setting.php" class="white-text">Storage</a></li>
                            <li><a href="user/setting.php" class="white-text">Setting</a></li>
                            <li><a href="login.php" class="white-text">Logout </a></li>
                          </ul>
                        </li>';
                  }
                  ?>
		            </ul>
	        	</div>
	          </nav>        
	      </div>
      </header>
      <div class="d-depth-2 main-con block-1" style=" background-image: url('img/pexels-manuel-geissinger-325229.jpg'); background-size:cover;">
          <div class="container">
              <table style="width: 100%; margin-top: 100px">
              	<tr>
              		<td>
              			
              			  <div class="card circul-x1 full-on-l full-on-s full-on-m content-ani depth-4 " style="height:auto; background: rgba(0,0,0,0.4);">
                	<div class="card-item">
                		<div class="row">
                			<div class="col-l20">
                				<div style="margin:40px; font-size: 18px; color: rgba(255,255,255,0.8); line-height: 28px;" class="card-item">
                					
Save work files or folders in Cloud, access them from any device and share them instantly with teammates, customers or partners. You can even share files with people that don’t use Document CLoud. No more sending attachments or spending time merging different versions of files. Experience your business workflow enhanced with DCLoud.<br><br>
									<p>Supported files</p>
									<div>
										<p style="font-size: 14px;font-weight: bold; color: #333">Image</p>
										<blockquote style="font-size: 14px;">JPG , JPEG , PNG , GIF , SVG , ICO , BMP , AI</blockquote>
										<p style="font-size: 14px;font-weight: bold; color: #333">Microsoft Office Files</p>
										<blockquote style="font-size: 14px;">MS Word , MS Access , MS Exel , PPT , MS Publisher </blockquote>
										<p style="font-size: 14px;font-weight: bold; color: #333">Compressed File</p>
										<blockquote style="font-size: 14px;">ZIP , RAR</blockquote>
										<p style="font-size: 14px;font-weight: bold; color: #333">Other Files</p>
										<blockquote style="font-size: 14px;">PDF , TXT</blockquote>
									</div>
                				</div>
                				<img src="https://img.icons8.com/fluent/96/000000/microsoft-word-2019.png" style="height: 64px; width: 64px" /><img src="https://img.icons8.com/fluent/96/000000/microsoft-excel-2019.png" style="height: 64px; width: 64px"/><img src="https://img.icons8.com/color/96/000000/ms-publisher.png" style="height: 64px; width: 64px"/><img src="https://img.icons8.com/color/96/000000/ms-access.png" style="height: 64px; width: 64px"/><img src="https://img.icons8.com/color/96/000000/ms-one-note.png" style="height: 64px; width: 64px" /><img src="https://img.icons8.com/fluent/96/000000/microsoft-office-delve-2020.png" style="height: 64px; width: 64px"/>
                			</div>
                		</div>
               		</div>
              	</div>

              		</td>
              		<td width="400" valign="top"> 
                    <div class="card circul-x1 depth-0 white" >  
                          <div class="card-head grey-text" style="font-family: Arial !important">Login now</div>
                            <div class="card-item" style="margin:10px 20px">
                              <form method="POST" name="login">
                              <input type="text" class="input-text d-depth-1" placeholder="Email / User name" name="username" id="username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>"  />
                              <input type="Password" placeholder="Password" class="input-text d-depth-1" name="password" id="password"/>                                
                              <input type="submit" style="font-family: Arial !important" value="Login" class="indigo accent-2 white-text btn-s btn-full d-depth-4"  id="reg" onclick="vali()" name="login">             
                              </form>
                              
                            </div>
                            <div class="card-footer">
                              <center><span class="blue-text">Lost your Password ?</span> <a href="user/forgot_pass.php"><b>Change now</b></a></center>
                            </div>
                            </div> 
                             <a href="register.php"> <input type="button" style="font-family: Arial !important" value="Register" class="indigo accent-2 white-text btn-s btn-full d-depth-4"  id="reg" onclick="vali()" name="login"></a>   
                        </td>
              	</tr>
              </table>
          </div>
      </div>
       <div class="container-fluid" style="margin-top:48% ">
      	<div class="row">
            <div class="col-l20 content-ani">
                 <footer class="gray">
			        <div class="container">
			          <div class="row">
			            <div class="col-s20 col-l10">
			              <div class="title">
			                <a class="title white-text" href="#" style="width: 200px; font-family:Poiret One;">documentcloud.ml</a>
			              </div>
			              <div class="description" style="color: #ccc">
			                Document cloud is a online cloud storage system. in which user can create directory, upload file and share a file in a publicly or privately with a file sharing protection. 
			              </div>
			            </div>
			            <div class="col-s20 col-l10">
			                  <div class="option-h x5 text-pink" style="text-align: right">
			                    <a href="" class="white-text"><i class="fa fa-home fa-2x" ></i>Home</a>
			                    <a href="" class="white-text"><i class="fa fa-file-text-o fa-2x" ></i>About</a>
			                    <a href="login.php" class="white-text"><i class="fa fa-sign-in fa-2x"></i>Sign In</a>
			                    <a href="register.php" class="white-text"><i class="fa fa-user-plus fa-2x"></i>Register</a>
			                  </div>
			            </div> 
			          </div>
			        </div> 

			        <div class="sub-footer">
			          <div class="container">
			            <p style="font-size: 14px; font-family: Arial; color: #f7f7f7; float: left;">&copy;documentcloud.com 2021. All Right Reserved.</p>
			          </div>
			        </div>
       			</footer>

            </div>
          
        </div>
      </div>
 
    </body>

</html>  


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