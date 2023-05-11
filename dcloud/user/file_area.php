<!DOCTYPE html>
<html>
    <title>Home | D Cloud</title>
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
         
          display: none;
          left: 0;
          top: 0;}
          
      </style>
    </head>

    <body>
    <?php
            require_once("../config.php");
            require_once("size_conv.php");
                      
            session_start();
            if (isset($_SESSION['user']))
            {

              if (isset($_GET['dir']))
              {
                  $dir_id = $_GET['dir'];              
              }
              
              $user = $_SESSION['user'];

              $reg = mysqli_query($con,"SELECT * FROM user_reg WHERE id=$user ");
              $reg_row = mysqli_fetch_assoc($reg);
         

              $dir_c =mysqli_query($con,"SELECT id FROM directory WHERE id='$user' && dir_id='$dir_id' ");
              $di_num = mysqli_num_rows($dir_c);

              if ($di_num)
              {
                  $user_status = 'owner';
              }
              else
              {
                  $user_status = 'user';                  
              }
            }
            else
            {
              /* $user_status = 'user';*/
               header("Location:../login.php");
            }

            if (!empty($reg_row['profile_pic']))
            {
                $pro_pic_path = 'profile_pic/'.$user.'/'.$reg_row['profile_pic']; 
            }
            else
            {
                $pro_pic_path = '../img/profile.png';
            }

            
          function dirinfo($id)
          {
                global $con;
                $dnameq = mysqli_query($con,"SELECT dir_name FROM directory WHERE dir_id=$id");
                $dname = mysqli_fetch_assoc($dnameq);
                return $dname['dir_name'];
          }
          ?>
          <!-- Create directory -->
          <?php 
          require_once("create_dir.php");

          if (isset($_POST['creat_d']))
          {
            $dir_path = $user.'/'.dirinfo($dir_id);//directory path within a main directory (user id named directory)
            $dir_n = $_POST['dir_name'];

            create_dir($dir_n,$user,$dir_path,'none',$dir_id);
                   
          }
        ?>
    <?php require_once("mobile_option.php"); ?>
    <?php require_once("header.php"); ?>
      <div class="with-fix">
           <div class="card d-depth-2 white" style="width: 99%; margin-top: 20px; margin-left: .5%; border-radius: 4px 4px 0 0;">
      <table style="margin: 8px" style="border: none;">
        <tr>
          <th rowspan="2" width="100" style="border-bottom: none !important;"><center><img src="<?php echo $pro_pic_path; ?>" style="height: 72px; width: 72px; border:1px solid #f7f7f7;" class="circul d-depth-1"></center></th>
          <th><?php echo $reg_row['first_name'].' '.$reg_row['last_name']; ?></th>
        </tr>
        <tr>
          <td>
             <div class="option-h x4 hide-on-sm" style="width: 50%;" > 
                <a href="shared_file.php" style="font-size: 15px !important;"><i class="fa fa-cloud-upload" style="margin-right: 10px"></i>Shared File</a>
                <a href="recived_file.php" style="font-size: 15px !important;"><i class="fa fa-cloud-download" style="margin-right: 10px"></i>Received File</a>
               <a href="groups.php" style="font-size: 15px !important;"><i class="fa fa-group" style="margin-right: 10px"></i>Groups</a>
                <a href="setting.php" style="font-size: 15px !important;"><i class="fa fa-edit" style="margin-right: 10px"></i>Setting</a>
            </div>  
          </td>
        </tr>
      </table>
              </div>

      <div class="row">
        <div style="width: 99%; margin-left: .5%; ">
          <div class="card d-depth-2 circul-x1 full-on-l full-on-s" style="margin-top: 20px !important; ">
            <div class="card-head" style="padding: 10px"><span class="fa fa-folder-open yellow-text text-darken-3" style="font-size: 21px; margin: 4px;"></span>
              <?php 
                $root = $dir_id;
                $i=0;//for dir in array index
                echo dirinfo($root);
                  while($root !== 0)
                  {
                      $dir = mysqli_query($con,"select * FROM dir_tree WHERE linked_dir_id=$root ");
                      $di = mysqli_fetch_assoc($dir);

                      if (isset($di['dir_id']))
                      {
                          
                          echo ' < '.'<a href="file_area/'.$di['dir_id'].'" class="dirlink">'.dirinfo($di['dir_id']).'</a>';
                         $root   = $di['dir_id'];
                         $a[$i] = $di['dir_id']; // store dir id in array
                         $i++; //dir array index increment
                      }
                    else
                      {
                          $root = 0;  
                      }
        
                  }
              ?>


              <?php 
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
               
               echo '| <span style="font-size:12px; letter-spacing:1px;">'.$real_dir_path.'</span>';                
              }
              ?>
            </div>
            <div class="card-item">
            	<a href="<?php if(isset($a[0])) echo'file_area/'.$a[0]; else echo'home.php'; ?>">
              	<button class="white btn-s circul" style="margin-bottom: 4px; margin-right: 4px; width: auto; font-size: 20px; color: #333" ><span class="fa fa-arrow-circle-left"></span></button></a>
                <button class="blue lighten-2 white-text btn-s" style="margin-bottom: 4px; margin-right: 4px; width: auto;" id="create_dir"><span class="fa fa-folder"></span> Create</button>
                <a href="delete_folder/<?php echo $_GET['dir']; ?>">
                  <button class="blue lighten-2 white-text btn-s" id='delete_dir' style="margin-bottom: 4px; margin-right: 4px; width: auto;"><span class="fa fa-folder"></span> Delete</button>
                </a>
                <button class="blue lighten-2 white-text btn-s" id="upload" style="margin-bottom: 4px; margin-right: 4px; width: auto;"><span class="fa fa-file"></span> Upload</button>
                <a href="delete_doc/<?php echo $_GET['dir']; ?>">
                <button class="blue lighten-2 white-text btn-s" style="margin-bottom: 4px; margin-right: 4px; width: auto;"><span class="fa fa-file"></span> Delete</button>
                </a>
                <a href="share_select/<?php echo $_GET['dir']; ?>">
                <button class="blue lighten-2 white-text btn-s right" style="margin-bottom: 4px; margin-right: 4px; width: auto;" id="share"><span class="fa fa-share"></span> Share</button>
                </a>
                <form method="post" enctype="multipart/form-data">
                  <input type="file" id="file" name="file[]" style="display:none" onchange="this.form.submit();" multiple/>
                </form>

              <div> 
             <?php
             //Directory list
              if ($user_status == 'owner')
              {
                  $root_dir =mysqli_query($con,"SELECT * FROM dir_tree WHERE dir_id='$dir_id' ");
                  while ($root = mysqli_fetch_assoc($root_dir)) 
                  {

                      $dir_info = mysqli_query($con,"SELECT * FROM directory WHERE dir_id='$root[linked_dir_id]' ");
                      $row_dir_info = mysqli_fetch_assoc($dir_info);
                        echo'
                        <div class="card depth-0" style="width: 85px;">
                          <div class="card-item" style="margin:4px">
                            <center>
                              <a href="file_area/'.$root['linked_dir_id'].'">
                                <img src="../img/folder.png" style="margin-left:16px"/>
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
                              <a target="blank" href="../data/'.$user.'/'.$real_dir_path.'/'.$doc_row['doc_path'].'">';
                              if(in_array($doc_row['doc_type'],$img_ex))
                              {
                                echo'
                                <img src="../data/'.$user.'/'.$real_dir_path.'/'.$doc_row['doc_path'].'" style="width:auto; height:45px; max-width:55px;"/>
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
                else
                {
                  echo "<div class='red white-text' style='padding:20px 0 20px 0; text-align:center;'>Sorry ! you are un-authorized to access this file</div>";
                } 
                
                ?>
               </div>
            </div> 
          </div>
        </div>
      </div>
    </div>

    <!-- create folder popup manu-->
      <div class="div" id="create" >
        <div class="container">
            <center>
            <div class="full-on-s circul-x1 white card" style="width: 400px; height: 200px; margin-top:100px !important; display: block;">
              <div class="card-head">Create folder</div>
              <div class="card-item" style="padding-bottom: 40px;">
                <form method="post" onsubmit="ck()">
                  <span class="item-head left">Enter Folder name :</span>
                  <input type="text" class="input-text" id="dirname" name="dir_name" required />
                
                  <input type="submit" value="Create" name="creat_d" id="creat_d" class="btn-s left blue white-text"/>&nbsp;<input type="button" value="Cancel" id="cencel_d" class="btn-s left blue white-text"/>
                </form>
                <!-- <p class="right grey-text" style="line-height: 28px; padding-bottom: 80px; "><b>Note :</b> Folder name are must be start with 0-9 , a-z or A-Z</p> -->
              </div>
            </div>
            </center>
        </div>
      </div>

      <!-- delete folder popup manu-->
      <div class="div" id="deldir">
        <div class="container">
            <center>
            <div class="full-on-s circul-x1 white card" style="width: 600px; height: auto; padding-bottom: 15px; margin-top:100px !important; display: block;">
              <div class="card-head">Delete folder</div>
              <div class="card-item" style="padding-bottom: 40px;">
                <div id="delete_div"></div>
                <input type="button" value="Cancel" id="cencel_d1" class="btn-s right blue white-text"/>
              </div>
            </div>
            </center>
        </div>
      </div>

    </body>
    
    <script type="text/javascript">
      $("#create_dir").click(function () {
        $("#create").css("display","block");
      });
      $("#cencel_d").click(function () {
        $("#create").css("display","none");
      });
      $("#upload").click(function(){
        $("#file").trigger('click');
      });

      /*for deleting directory*/
      

      $("#cencel_d1").click(function () {
        $(".div").css("display","none");
      });

      $("#share").click(function(){
        $("#").css("display","block");
      });
   </script>
    </html>