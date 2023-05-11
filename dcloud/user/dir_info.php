 <?php 
 require_once("../config.php");  
    function dirinfo($id)
          {
                global $con;
                $dnameq = mysqli_query($con,"SELECT dir_name FROM directory WHERE dir_id='$id' ");
                $dname = mysqli_fetch_assoc($dnameq);
                return $dname['dir_name'];
          }
    function num_of_items($id)
    	{
    		    global $con;
                $diq = mysqli_query($con,"SELECT * FROM `docfile` WHERE dir_id='$id' ");
                $dir_num = mysqli_num_rows($diq);
                return $dir_num;
    	}  
    function num_of_subdir($id)
        {
                global $con;
                $subfolder = mysqli_query($con,"SELECT linked_dir_id FROM dir_tree WHERE dir_id='$id' ");
                return mysqli_num_rows($subfolder);
        } 
    function dir_path($dir_id)
        {
            $dir_id = (string)$dir_id;
            global $con;
            $root = $dir_id;
            $i=0;//for dir in array index
            
            while($root !== 0)
            {
                $dir = mysqli_query($con,"SELECT * FROM dir_tree WHERE linked_dir_id='$root' ");
                $di = mysqli_fetch_assoc($dir);

                if (isset($di['dir_id']))
                {
                    /*echo ' < '.'<a href="file_area.php?dir='.$di['dir_id'].'" class="dirlink">'.dirinfo($di['dir_id']).'</a>';*/
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
                       
                   return $real_dir_path;                
            }
              

        }
        

    /*function del_dir($id)
    {
        global $con;
        
          session_start();
        }
        $path = '../data/'.$_SESSION['user'].'/'.dir_path($id); 
        if (file_exists('../data/'.$_SESSION['user'].'/'.dir_path($id)))
        {
            array_map('unlink',glob($path));
        }

        mysqli_query($con,"DELETE FROM `directory` WHERE dir_id='$id'");
        if (num_of_items($id) > 0)
        {
            mysqli_query($con,"DELETE FROM `docfile` WHERE dir_id='$id'");
        }
        if (num_of_subdir($id))
        {
             $subfolder = mysqli_query($con,"SELECT linked_dir_id FROM dir_tree WHERE dir_id='$id' ");
             while ($subdir = mysqli_fetch_assoc($subfolder)) 
             {
                 mysqli_query($con,"DELETE FROM `dir_tree` WHERE dir_id='$subdir[linked_dir_id]'");
                 del_dir($subdir['linked_dir_id']);

             }
             

        }


    }*/
function del_dir($id)
    {
        global $con;

        mysqli_query($con,"DELETE FROM `directory` WHERE dir_id='$id' ");
        mysqli_query($con,"DELETE FROM `dir_tree` WHERE dir_id='$id' ");
        mysqli_query($con,"DELETE FROM `dir_tree` WHERE linked_dir_id='$id' ");

        if (num_of_items($id) > 0)
        {
            mysqli_query($con,"DELETE FROM `docfile` WHERE dir_id='$id' ");
        }

       

    }
    function del_dir_path($id)//not work on external file
    {
        global $con;

        if (dir_path($id))
        {
            $path = '../data/'.$_SESSION['user'].'/'.dir_path($id);
        }    
        else
        {
            
            $path = '../data/'.$_SESSION['user'].'/'.dirinfo($id);
        }

        
        $files = glob(preg_replace('/(\*|\?|\[)/', '[$1]', $path).'/{,.}*',GLOB_BRACE);
        foreach ($files as $file) {
            if ($file == $path.'/.'||$file==$path.'/..')
            {
                continue;
            }
            is_dir($file)?del_dir_path($file) : unlink($file);
        }
        rmdir($path);

        mysqli_query($con,"DELETE FROM `directory` WHERE dir_id='$id' ");
        mysqli_query($con,"DELETE FROM `dir_tree` WHERE dir_id='$id' ");
        mysqli_query($con,"DELETE FROM `dir_tree` WHERE linked_dir_id='$id' ");

        if (num_of_items($id) > 0)
        {
            mysqli_query($con,"DELETE FROM `docfile` WHERE dir_id='$id' ");
        }
        return 1;

    }

?>        