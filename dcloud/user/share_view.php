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

            if(isset($_GET['share_id']))
            {
               $s_id = $_GET['share_id'];

               $shre_q = mysqli_query($con,"SELECT share_title FROM share_privacy WHERE share_id='$s_id' ");
               $share_info =mysqli_fetch_assoc($shre_q);

               $by = mysqli_query($con,"SELECT * FROM docfile_share WHERE share_id='$s_id' ");
               $by_user = mysqli_fetch_array($by);

               $shared_by = $by_user['id']; //OWNER OF DIRECTOY AND SENDER

               $by_data_q = mysqli_query($con,"SELECT * FROM user_reg WHERE id='$shared_by' ");
               $by_data = mysqli_fetch_array($by_data_q);    
               
               if (!empty($by_data['profile_pic']))
              {
                  $by_pic = 'profile_pic/'.$by_data['id'].'/'.$by_data['profile_pic']; 
              }
              else
              {
                  $by_pic = '../img/profile.png';
              }           
             }

          ?>
          <!-- Create directory -->
          

    <?php require_once("header.php"); ?>
      <div class="container with-fix">
           <div class="row">
            <div class="col-l20">
                <div class="card depth-0" style="width: 100%; margin-top: 20px; border-radius: 4px 4px 0 0;">
                  <div class="blue lighten-1 d-depth-2" style="height: 60px;border-radius: 4px 4px 0 0; width: 100%;" id="user_head">
                  </div>
                  <img src="<?php echo $by_pic; ?>" style="height: 60px; width: 60px; margin-top:  -30px; background: #FFF; border:1px solid #f7f7f7; margin-left: 40px;" class="circul d-depth-1">                
                    <div style="line-height: 25px; font-size: 14px; color: #fff; margin: -60px 0 0 110px;"><b><?php echo $by_data['first_name'].' '.$by_data['last_name']?></b></div>

                </div>
                            
            </div>
          </div>

      <div class="row">
        <div class="col-l20">
          <div class="card d-depth-2 circul-x1 full-on-l full-on-s" style="margin-top: 40px !important; ">
            <div class="card-head" style="padding: 10px"><span class="fa fa-folder-open yellow-text text-darken-3" style="font-size: 21px; margin: 4px;"></span>
            <B><?php echo $share_info['share_title']; ?></B>
              <?php 
              if(isset($_GET['dir']))
              {
                    $dir_id = $_GET['dir'];
                    $root = $dir_id;
                    $i=0;//for dir in array index
                    echo dirinfo($root);
                      while($root !== 0)
                      {
                          $dir = mysqli_query($con,"select * FROM dir_tree WHERE linked_dir_id=$root ");
                          $di = mysqli_fetch_assoc($dir);

                          if (isset($di['dir_id']))
                          {
                              
                              /*echo ' < '.'<a href="share_view.php?dir='.$di['dir_id'].'&share_id='.$s_id.'" class="dirlink">'.dirinfo($di['dir_id']).'</a>';*/
                             $root   = $di['dir_id'];
                             $a[$i] = $di['dir_id']; // store dir id in array
                             $i++; //dir array index increment
                          }
                        else
                          {
                              $root = 0;  
                          }
            
                      }



                      if (isset($a))
                      {
                       $path = array_reverse($a); // get dir_id from reverse array
                       $i = 0;
                       //find dir_name from $path
                       foreach ($path as $link) {
                        $real_dir[$i] = dirinfo($link);
                         $i++;
                       }
                       $real_dir_path = implode("/", $real_dir).'/'.dirinfo($dir_id).'/'; //Current directory path within root directory, if this is root directory, then not set a path
                       
                       echo ' | <span style="font-size:12px; letter-spacing:1px;">'.$real_dir_path.'</span>';                
                      }
              }
              ?>

            </div>
            <div class="card-item">
            	<!-- BACK KEY -->
              <a href="<?php if((isset($a[0])) && $a[0]==$dir) echo'share_view/'.$a[0].'/'.$s_id; else echo'share_view/0/'.$s_id; ?>"><!-- DEFULT -->
              	<button class="white btn-s circul" style="margin-bottom: 4px; margin-right: 4px; width: auto; font-size: 20px; color: #333" ><span class="fa fa-arrow-circle-left"></span></button></a>
            <div> 
             <?php
             //SECURITY OPTION
             $security_q = mysqli_query($con,"SELECT privacy,starting_time,ending_time,password FROM share_privacy WHERE share_id='$s_id' && id='$shared_by' ");
             $sec_data = mysqli_fetch_assoc($security_q);
             $sec_data_num = mysqli_num_rows($security_q);

             $authanticate = "";
             $access = "";
             $error = "";
             //AUTHANTICATION
             if ($by_user['share_type'] == 'Public')
             {
                $authanticate = 'YES';
             }
             elseif($by_user['share_type'] == 'Private')
             {
                if(isset($user))
                {
                  $share_to= mysqli_query($con,"SELECT share_user FROM share_to WHERE share_id='$s_id' && share_user='$user' ");
                  $share_to_row = mysqli_num_rows($share_to);
                  if (($share_to_row > 0) || ($user == $shared_by))
                  {
                      $authanticate = 'YES';      
                  }
                  else
                  {
                      $authanticate = 'NO';
                  }
                }
             }
             //SECURITY ACTHNTICATION
             if($authanticate == 'YES')
             {
                      if(($sec_data['privacy']=='none')||($sec_data_num==0))
                      {
                        $access = 'YES';
                      }
                      elseif($sec_data['privacy']=='Password')
                      {
                          if(isset($_POST['pass']))
                          {
                            $password = sha1(md5($_POST['pass']));

                            if($sec_data['password'] == $password)
                            {
                               $access = 'YES';                           
                            }
                            else
                            {
                               $access = 'NO';
                               $error ='Wrong password, try again';
                            }
                          }
                      }
                      elseif ($sec_data['privacy']== 'Time') {
  
                        $start = $sec_data['starting_time'];
                        $end = $sec_data['ending_time'];
                        if ($start <= time() AND time() <= $end)
                        {
                            $access = 'YES';
                        } 
                        else
                        {
                            $access = 'NO';
                            $error = 'Sharing Time Out';
                        }
                      }
                  }
              //viewer is a owner
              if(isset($_SESSION['user']))
              {
                if ($shared_by == $_SESSION['user'])
                {
                  $authanticate = 'YES'; 
                  $access = 'YES';
                } 
              }

              if ($authanticate == 'YES' && $access == 'YES')
              {
                if((!isset($_GET['dir'])) || $_GET['dir']==0)
                {
                  $sel_data_q = mysqli_query($con,"SELECT * FROM docfile_share WHERE share_id='$s_id' ");
                  while($share_data=mysqli_fetch_assoc($sel_data_q))
                  {
  
                      $root_dir =mysqli_query($con,"SELECT * FROM directory WHERE dir_id='$share_data[dir_id]' ");
                      while ($root = mysqli_fetch_assoc($root_dir)) // DEFULT
                      {
                            echo'
                            <div class="card depth-0" style="width: 85px;">
                              <div class="card-item" style="margin:4px">
                                <center>
                                  <a href="share_view/'.$root['dir_id'].'/'.$s_id.'">
                                    <SPAN class="fa fa-folder-open yellow-text text-darken-3 " style="font-size: 48px; width: 85px;"></SPAN>
                                    <div style="width: 85px;" class="truncate">'.dirinfo($root['dir_id']).'</div>
                                  </a>
                                </center>
                              </div>
                            </div>';
                        }

                   $doc = mysqli_query($con,"SELECT * FROM docfile WHERE doc_id='$share_data[doc_id]' ");

                    $img_ex = array('image/png','image/jpeg','image/jpg','image/gif','image/svg','image/ico','image/bmp','image/ico','image/bmp','image/ai');

                        while ($doc_row = mysqli_fetch_assoc($doc)) 
                        {
                           $f_dir = $doc_row['dir_id'];

                            if($doc_row['dir_id'] == $shared_by)
                            {
                              $real_path = '';
                            } 
                            else
                            {
                                 if(dir_path($f_dir))
                                {
                                  $real_path = dir_path($f_dir);
                                }
                                else
                                {
                                  $real_path = dirinfo($f_dir);
                                }
                            }

                         
                         

                             echo'
                            <div class="card depth-0" style="width: 85px;">
                              <div class="card-item" style="margin:4px">
                                <center> 
                                  <a target="blank" href="../data/'.$shared_by.'/'.$real_path.'/'.$doc_row['doc_path'].'">';
                                  if(in_array($doc_row['doc_type'],$img_ex))
                                  {
                                    echo'
                                    <img src="../data/'.$shared_by.'/'.$real_path.'/'.$doc_row['doc_path'].'" style="width:auto; height:45px; max-width:55px;"/>
                                    <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                                  }
                                  if($doc_row['doc_type'] == 'application/x-zip-compressed')
                                  {
                                    echo'
                                    <img src="../img/6.zip.png" style="width:auto; height:45px; max-width:55px;"/>
                                    <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';

                                  }
                                  if($doc_row['doc_type'] == 'application/octet-stream')
                                  {
                                    echo'
                                    <img src="../img/7.rar.png" style="width:auto; height:45px; max-width:55px;"/>
                                    <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                                  }
                                  if($doc_row['doc_type'] == 'application/pdf')
                                  {
                                    echo'
                                    <img src="../img/8.pdf.png" style="width:auto; height:45px; max-width:55px;"/>
                                    <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                                  }
                                  if($doc_row['doc_type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                  {
                                    echo'
                                    <img src="../img/3.word.png" style="width:auto; height:45px; max-width:55px;"/>
                                    <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                                  }
                                  if($doc_row['doc_type'] == 'application/msaccess')
                                  {
                                    echo'
                                    <img src="../img/1.access.png" style="width:auto; height:45px; max-width:55px;"/>
                                    <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                                  }
                                  if($doc_row['doc_type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                  {
                                    echo'
                                    <img src="../img/5.Excel.png" style="width:auto; height:45px; max-width:55px;"/>
                                    <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                                  }
                                  if($doc_row['doc_type'] == 'application/vnd.openxmlformats-officedocument.presentationml.presentation')
                                  {
                                    echo'
                                    <img src="../img/4.Powerpoint.png" style="width:auto; height:45px; max-width:55px;"/>
                                    <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                                  }
                                  if($doc_row['doc_type'] == 'application/vnd.ms-publisher')
                                  {
                                    echo'
                                    <img src="../img/2.publisher.png" style="width:auto; height:45px; max-width:55px;"/>
                                    <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                                  }
                              echo'</a>
                                </center>
                              </div>
                            </div>';
                        
                        }

                  }
                }
                else
                {
                  $dir_id = $_GET['dir'];
                  $root_dir =mysqli_query($con,"SELECT * FROM dir_tree WHERE dir_id='$dir_id' ");
                  while ($root = mysqli_fetch_assoc($root_dir)) 
                  {

                      $dir_info = mysqli_query($con,"SELECT * FROM directory WHERE dir_id='$root[linked_dir_id]' ");
                      $row_dir_info = mysqli_fetch_assoc($dir_info);
                        echo'
                        <div class="card depth-0" style="width: 85px;">
                          <div class="card-item" style="margin:4px">
                            <center>
                              <a href="share_view/'.$root['linked_dir_id'].'/'.$s_id.'">
                                <SPAN class="fa fa-folder-open yellow-text text-darken-3 " style="font-size: 48px; width: 85px;"></SPAN>
                                <div style="width: 85px;" class="truncate">'.dirinfo($root['linked_dir_id']).'</div>
                              </a>
                            </center>
                          </div>
                        </div>';
                    }
                    require_once("upload_file.php");

                    $doc = mysqli_query($con,"SELECT * FROM docfile WHERE dir_id='$dir_id' ");

                    $img_ex = array('image/png','image/jpeg','image/jpg','image/gif','image/svg','image/ico','image/bmp','image/ico','image/bmp','image/ai');

                    while ($doc_row = mysqli_fetch_assoc($doc)) 
                    {

                         echo'
                        <div class="card depth-0" style="width: 85px;">
                          <div class="card-item" style="margin:4px">
                            <center> 
                              <a href="../data/'.$shared_by.'/'.$real_dir_path.'/'.$doc_row['doc_path'].'">';
                              if(in_array($doc_row['doc_type'],$img_ex))
                              {
                                echo'
                                <img src="../data/'.$shared_by.'/'.$real_dir_path.'/'.$doc_row['doc_path'].'" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/x-zip-compressed')
                              {
                                echo'
                                <img src="../img/6.zip.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';

                              }
                              if($doc_row['doc_type'] == 'application/octet-stream')
                              {
                                echo'
                                <img src="../img/7.rar.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/pdf')
                              {
                                echo'
                                <img src="../img/8.pdf.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                              {
                                echo'
                                <img src="../img/3.word.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/msaccess')
                              {
                                echo'
                                <img src="../img/1.access.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                              {
                                echo'
                                <img src="../img/5.Excel.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/vnd.openxmlformats-officedocument.presentationml.presentation')
                              {
                                echo'
                                <img src="../img/4.Powerpoint.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                              if($doc_row['doc_type'] == 'application/vnd.ms-publisher')
                              {
                                echo'
                                <img src="../img/2.publisher.png" style="width:auto; height:45px; max-width:55px;"/>
                                <div style="width: 85px;" class="truncate">'.$doc_row['doc_path'].'</div>';
                              }
                          echo'</a>
                            </center>
                          </div>
                        </div>';
                    
                    }
                }
                  
              }
                else
                {
                  echo "<div class='red white-text' style='padding:20px 0 20px 0; text-align:center;'>Sorry ! you are un-authorized to access this file";
                  if ($error !== "")
                  {
                      echo ' : <b>'.$error.'</b>';
                  }
                  echo "</div>";
                } 
                
                ?>
               </div>
            </div> 
          </div>
        </div>
      </div>
    </div>

    <!-- create folder popup manu-->
    <?php 
    if ($sec_data['privacy']=='Password' AND $access !== 'YES' )
    {
      echo '
      <div class="div" id="create" >
        <div class="container">
            <center>
            <div class="full-on-s circul-x1 white card" style="width: 400px; height: 200px; margin-top:100px !important; ">
              <div class="card-head">Password</div>
              <div class="card-item" style="padding-bottom: 40px;">
                <form method="post" onsubmit="ck()">
                  <span class="item-head left">Enter Password :</span>
                  <input type="password" class="input-text" id="dirname" name="pass" required />
                
                  <input type="submit" value="Open" name="creat_d" id="creat_d" class="btn-s left blue white-text"/>&nbsp;
                <p class="right grey-text" style="line-height: 28px; padding-bottom: 80px; ">'.$error.'</p>
                </form>
                
              </div>
            </div>
            </center>
        </div>
      </div>
      ';
    }
    ?>
      

    </body>
   
    </html>