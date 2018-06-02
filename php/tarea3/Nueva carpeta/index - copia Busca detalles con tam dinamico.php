<?php 
    function crearTabla($filename)
    {
        $filearray = file($filename);
        //$handle = fopen($filename, "r+");
        while(list($var, $val) = each($filearray)){
            ++$var;
            $val = trim($val);
            print "$var: $val <br/>";
        }
        //fclose($handle);
    }
    function cargarFormEdicion()
    {
        $filename = "test.txt";        
        $handle = fopen($filename, "wr+");

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        main{
            display: -ms-flex;
            display: -webkit-flex;
            display: flex;
        }
        main > div {
            width: 30%;
            padding: 10px;
        }
        main > div:first-child {
            margin-right: 25px;
        }
        h4{
            margin-bottom:0px;
        }
    </style>
</head>
<body>
    <h2>Lista de Contactos</h2>
    <main>
    <div>
    <?php
        crearTabla("test.txt");
    ?>
    </div>
    <div>
        <form method="POST" name="busqueda">
            <input type="text" name="txt_id">
            <input type="submit" name="buscar" value="Buscar"><br>
        </form>
        <h4>Address</h4>

            <?php 
                /*
                        <form method="POST" name="edicion">
            <h4>Name</h4>
            <input type="text" name="<?php if(!isset($res)) echo $res ?>"><br>
            <h4>Work</h4>
            <input type="text" value="ajs" name="txt_work">
            <h4>Mobile</h4>
            <input type="text" name="txt_mobile">
            <h4>Email</h4>
            <input type="text" name="txt_email">
            <h4>Address</h4>
            <input type="text" name="txt_address">

                */
                $filename = "test.txt";
                $filename2 = "test2.txt";
                $fileIndicesNombres = "indicesDetalles.txt";         
                $fileIndicesDetalles = "indicesDetalles.txt"; 
                if(isset($_POST['buscar'])){
                    //$id=$_POST['txt_id']; // indice o num de persona
                    $id=3; // indice o num de persona
                    $id=$id-1;
                    $handle = fopen($filename, "r+");
                    $handle2 = fopen($filename2, "r+");
                    $handleIndices = fopen($fileIndicesDetalles, "r+");
                    $handleIndices = fopen($fileIndicesNombres, "r+");
                    $cantCaracNombre=0;
                    $res='';
                    $res2='';
                    if($id==0){
                        fseek($handle, 0);
                        fseek($handleIndices, 0);
                        $cantCaracNombre=fread($handleIndices, 1);
                        fseek($handle2, 0);
                    }else{
                        $fileArrayIndices = file($fileIndicesDetalles);
                        $acumuladoFseek=0;
                        while(list($var, $val) = each($fileArrayIndices)){
                            print "$var: $acumuladoFseek +$val<br/>";
                            if($var==$id){
                                $cantCaracNombre+=$val;
                                print "$cantCaracNombre carac<br/>";
                                break;
                            }else{
                                $acumuladoFseek += $val+2;
                            }
                        }
                        fseek($handle, 6*$id); 
                        fseek($handle2, $acumuladoFseek);
                    }  
                    $res=fread($handle, 4);
                    $res2=fread($handle2, $cantCaracNombre);
                    print ':'.$res.'+'.$res2.'<br>';
                    echo '<input type="text" value="'.$res.'" name="txt_work">';
                    //cargarFormEdicion();
                    fclose($handle2);
                    fclose($handleIndices);
                    fclose($handle);
                }
                
            ?>
 
    </div>
    </main>
    <?php 
        echo '-----------<br>';
        $filename = "test.txt";
        
        //$busID = "2";
        //$mystring = "Caro\r\nJona\r\nFeri\r\nMary";
        
        //$handle = fopen($filename, "wr+");

        //fseek($handle, 0);        
        //fseek($handle, 2*5);
        //print fread($handle, 6).'<br>';
        
        
        
        //$x= fseek($handle, $busID);
        //print fgets($handle, 2);

        //print fseek($handle, $busID); 
    /*  $mystring = "Caro";
        $numbytes = fwrite($handle, "Caro\r\n");
        print "$numbytes bytes written \n<br>";

        $numbytes = fwrite($handle, "Jona\r\n");
        print "$numbytes bytes written \n<br>";

        $numbytes = fwrite($handle, "Feri\r\n");
        print "$numbytes bytes written \n<br>";

        $numbytes = fwrite($handle, "Mary\r\n");
        print "$numbytes bytes written \n<br>";
    */
        
        /*if(isset($_POST['buscar'])){
            $id=$_POST['txt_id'];
            $id=$id-1;
            
            if($id==0){
                fseek($handle, 0);
            }else{
                fseek($handle, 6*$id);
            }        
            //print ':'.fread($handle, 4).'<br>';
            $res=fread($handle, 4);
            print ':'.$res.'<br>';
            echo '<input type="text" value="'.$res.'" name="txt_work">';
        }*/
        //fclose($handle);
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