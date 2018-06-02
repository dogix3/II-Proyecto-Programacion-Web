<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>My test page</title>
  </head>
  <body>
    <form enctype="multipart/form-data" method="post" action="http://localhost:7881/php/tarea4/">
    Send this file: <input name="userfile" type="file" /></br>
    <input type="submit" value="Send File"/>
    <?php
        error_reporting(E_ERROR | E_PARSE);
        //print $_FILES['userfile']['tmp_name']. "</br>";
        if(move_uploaded_file($_FILES['userfile']['tmp_name'], "folder/".$_FILES['userfile']['name'])){
            print "Received {$_FILES['userfile']['name']} -
                    its size is {$_FILES['userfile']['size']}";
        }else{
            print "Upload failed!";
        }


        print "<br><br>";

        print "<br>";

        if (isset($_POST['btn_eliminar'])) 
        {  
            print 'folder/'.$_POST['btn_eliminar'].'<br>';
            if(unlink('folder/'.$_POST['btn_eliminar'])){
                print 'Deleted '.$_POST['btn_eliminar'].'<br>';
            }else{
                print "Delete of ". $_POST['btn_eliminar'] ." failed!<br>";
            }
        }
        $handle = opendir('./folder');
        if($handle){ 
            print "<form method='POST' action='http://localhost:7881/php/tarea4/'>";
            while(false !== ($file = readdir($handle))){
                if($file =='.' || $file =='..'){

                }else{
                    print "<a href='folder/$file' >".$file."</a> <button name='btn_eliminar' value='$file' type='submit'>Eliminar</button> <br />\n";
                }
            }
            closedir($handle);
            print '</form>';
        }        
    ?>
  </body>
</html>