 <?php
            require_once("size_conv.php");

            $reg = mysqli_query($con,"SELECT * FROM user_reg WHERE id=$user ");
            $reg_row = mysqli_fetch_assoc($reg);

            $log = mysqli_query($con,"SELECT * FROM login_user WHERE id=$user");
            $log_row = mysqli_fetch_assoc($log);

           $stor = mysqli_query($con,"SELECT SUM(size) FROM docfile WHERE id=$user");
            $size = mysqli_fetch_assoc($stor);

            $avilable = avilable($size['SUM(size)']);

            if (!empty($reg_row['profile_pic']))
            {
                $pro_pic_path = 'profile_pic/'.$user.'/'.$reg_row['profile_pic']; 
            }
            else
            {
                $pro_pic_path = '../img/profile.png';
            } 

          ?>
 <table class="simple-table full-on-l" style="width: 100%;">
                      <tr>
                        <th align="left" align="left">File</th>
                        <th width="100px" align="center">Number of files</th>
                        <th width="100px" align="center">Size</th>
                      </tr>
                      <tr>
                        <td>Image</td>
                        <td align="center"><?php if(get_filenum($user,'image')) echo get_filenum($user,'image'); else echo 0;?></td>
                        <td align="center"><?php if(get_size($user,'image')) echo conv(get_size($user,'image')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>PDF</td>
                        <td align="center"><?php if(get_filenum($user,'pdf')) echo get_filenum($user,'pdf'); else echo 0;?></td>
                        <td align="center"><?php if(get_size($user,'pdf')) echo conv(get_size($user,'pdf')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>Microsoft office file</td>
                        <td align="center"><?php if(get_filenum($user,'ms')) echo get_filenum($user,'ms'); else echo 0;?></td>
                        <td align="center"><?php if(get_size($user,'ms')) echo conv(get_size($user,'ms')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>ZIP / RAR</td>
                        <td align="center"><?php if(get_filenum($user,'extrected')) echo get_filenum($user,'extrected'); else echo 0;?></td>
                        <td align="center"><?php if(get_size($user,'extrected')) echo conv(get_size($user,'extrected')); else echo 0;?></td>
                      </tr>
                      <tr>
                        <td>Other Files</td>
                        <td align="center"><?php if(get_filenum($user,'other')) echo get_filenum($user,'other'); else echo 0;?></td>
                        <td align="center"><?php if(get_size($user,'other')) echo conv(get_size($user,'other')); else echo 0;?></td>
                      </tr>
                    </table>