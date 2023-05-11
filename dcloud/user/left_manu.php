
                	<?php
                	$admin = mysqli_query($con,"SELECT role FROM login_user WHERE id='$user' && role='Admin' ");
                	$admin_check = mysqli_num_rows($admin);
                	if($admin_check == 1)
                	{
                		echo '
                    <div class="card d-depth-2 white hide-on-sm" style="width: 100%; margin-top: 20px;">
                    <div class="option-p grey-text text-darken-3">
                    <a href="../admin" class="blue white-text"><i class="fa fa-user" style="margin-right: 10px"></i>Admin Area</a>
                    </div>
              </div>';
                	}

                 	 ?>
              