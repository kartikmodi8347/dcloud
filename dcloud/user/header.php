
<header class="fix indigo accent-2">    
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
              <button id="nav-close" onclick="dropdown_close('manu')"></button>
              <li><a href="<?php if(isset($_SESSION['user'])) echo 'home.php'; else echo '../' ?>" class="white-text">Home</a></li>
              <li><a href="fs_setting.php" class="white-text">Storage</a></li>
              <li class="hide-on-sm"><a href="../register.php" class="white-text">Register<a></li> 
              <li class="hide-on-lm"><a href="groups.php" class="white-text">Groups</a></li>
              <li class="hide-on-l"><a href="setting.php" class="white-text">Setting</a></li>
              <li class="hide-on-l"><a href="../login.php" class="white-text">Logout </a></li>
              <?php

              if(isset($_SESSION['user']))
              {
                echo '
                <li class="hide-on-sm"><a href="" class="white-text"><img src="'.$pro_pic_path.'" style="height: 25px; width: 25px; border-radius: 50%; background: #fff; margin-bottom: -8px;"/> Me <span></span></a>
                <ul>
                  <li><a href="fs_setting.php" class="white-text">Storage</a></li>
                  <li><a href="groups.php" class="white-text">Groups</a></li>
                  <li><a href="setting.php" class="white-text">Setting</a></li>
                  <li><a href="../login.php" class="white-text">Logout </a></li>
                </ul>
              </li>
                ';
              }
              else {
                echo'<li><a href="../login.php" class="white-text">Login<a></li>';
              }
               ?>             
              
              </ul>
          </div>
          </nav> 
          
      </header>