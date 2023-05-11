<!-- <base href="http://www.documentcloud.ml/admin/" /> -->
<?php
session_start();
require_once '../config.php';
$admin = mysqli_query($con,"SELECT id FROM login_user WHERE id='$_SESSION[user]' AND role='Admin' ");
$num = mysqli_num_rows($admin);
if ($num == 0)
{
    header("location:../index.php");
}
$ad_info = mysqli_query($con,"SELECT * FROM user_reg WHERE id='$_SESSION[user]' ");
$data = mysqli_fetch_assoc($ad_info);
if ($data['profile_pic']== "")
{
  $pro_pic_path = '../img/profile.png';  
}
else
{
  $pro_pic_path = '../user/profile_pic/'.$_SESSION['user'].'/'.$data['profile_pic']; 
}

?>

<header class="fix blue">    
        <div class="logo left">
            <img src="../img/logo_short.png" alt="document cloud"/>
        </div>
        <div class="left" style="padding-top:10px; ">
            <a class="title white-text" href="../" style="width: 200px;  padding-left: 20px;  font-family: 'Open Sans',Condensed Light; ">Document Cloud</a>
          </div>

          <nav class="right">
            <button onclick="dropdown('manu')"></button>
            <div class="nav-ul">              
              <ul id="manu">
              <div class="hide-on-l">
                  <button id="nav-close" onclick="dropdown_close('manu')"></button>
                   <li><a href="" class="white-text">User Home</a></li>
                   <li><a href="setting.php" class="white-text">Setting</a></li>
                   <li><a href="../login.php" class="white-text">Logout </a></li>
              </div>             
              <li class="hide-on-sm"><a href="" class="white-text"><img src="<?php echo $pro_pic_path; ?>" style="height: 25px; width: 25px; border-radius: 50%; background: #fff; margin-bottom: -8px;"/> Me <span></span></a>
                <ul>
                  <li><a href="../user/home.php" class="white-text">User Home</a></li>
                  <li><a href="../user/setting.php" class="white-text">Setting</a></li>
                  <li><a href="../login.php" class="white-text">Logout </a></li>
                </ul>
              </li>

              </ul>
          </div>
          </nav> 
          
      </header>