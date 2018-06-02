<?php 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

    </style>
</head>
<body>
    <h2>Calendario de eventos</h2>
    <form method="POST">
    <input type="text" name="txt_id">
    <input type="submit" name="buscar" value="Buscar"><br>
    <input type="text" name="txt_nombre">    
    <input type="submit" name="agregar" value="Agregar"><br>
    </form>
    <?php 
        $filename = "test.txt";
        
        //$busID = "2";
        //$mystring = "Caro\r\nJona\r\nFeri\r\nMary";
        
        $handle = fopen($filename, "wr+");

        //fseek($handle, 0);        
        //fseek($handle, 2*5);
        //print fread($handle, 6).'<br>';
        
        
        
        //$x= fseek($handle, $busID);
        //print fgets($handle, 2);

        //print fseek($handle, $busID); 
        $mystring = "Caro";
        $numbytes = fwrite($handle, "Caro\r\n");
        print "$numbytes bytes written \n<br>";

        $numbytes = fwrite($handle, "Jona\r\n");
        print "$numbytes bytes written \n<br>";

        $numbytes = fwrite($handle, "Feri\r\n");
        print "$numbytes bytes written \n<br>";

        $numbytes = fwrite($handle, "Mary\r\n");
        print "$numbytes bytes written \n<br>";

        if(isset($_POST['buscar'])){
            $id=$_POST['txt_id'];
            $id=$id-1;
            
            if($id==0){
                fseek($handle, 0);
            }else{
                fseek($handle, 6*$id);
            }        
            print ':'.fread($handle, 4).'<br>';
        }
        fclose($handle);
    ?>
</body>
</html>



<?php 
        /*$desired_line=1;
        rewind($handle);
		for($i=0; $i<$desired_line; $i++){
            fgetcsv($handle, 1000, ",");
        }*/

?>