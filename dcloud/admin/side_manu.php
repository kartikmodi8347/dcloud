<!-- all veriable are defined in header.php/ file  are included parent file of this file -->
<img class="circul" src="<?php echo $pro_pic_path; ?>" style="height: 100px; width: 100px; margin-top: 20px;"/>
<p style="font-size: 18px;  color: rgba(255,255,255,0.8);"><?php echo $data['first_name'].' '.$data['last_name']; ?></p>

<div class="card depth-0 hide-on-sm fixe" style="width: 100%; margin-top: 20px; color: rgba(255,255,255,0.8);">
                <div class="option-p ">
                <a href="index.php"><i class="fa fa-user" style="margin-right: 10px"></i>Admin Home</a>	
                  <a href="manage_users.php"><i class="fa fa-user" style="margin-right: 10px"></i>Manage Users</a>
                  <a href="manag_grp.php"><i class="fa fa-group" style="margin-right: 10px"></i>Manage Group</a>
                  <a href="storage.php"><i class="fa fa-edit" style="margin-right: 10px"></i>Storage </a>
                  <a href="add_admin.php"><i class="fa fa-user" style="margin-right: 10px"></i>Admins </a>
                </div>
              </div>