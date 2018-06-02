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
                $fileIndicesNombres = "indicesNombres.txt";         
                $fileIndicesDetalles = "indicesDetalles.txt"; 
                if(isset($_POST['buscar'])){
                    $id=$_POST['txt_id']; // indice o num de persona
                    //$id=2; // indice o num de persona
                    $id=$id-1;
                    $handle = fopen($filename, "r+");
                    $handle2 = fopen($filename2, "r+");
                    $handleIndicesDetalles = fopen($fileIndicesDetalles, "r+");
                    $handleIndicesNombres = fopen($fileIndicesNombres, "r+");
                    $cantCaracDetalle=0;
                    $cantCaracNombre=0;
                    $res='';
                    $resDetalle='';
                    if($id==0){
                        fseek($handle, 0); // nombres.txt
                        fseek($handleIndicesDetalles, 0);
                        fseek($handleIndicesNombres, 0);
                        $cantCaracDetalle=fread($handleIndicesDetalles, 1);
                        $cantCaracNombre=fread($handleIndicesNombres, 1); // num de caract en nombre
                        fseek($handle2, 0); // detalle.txt
                    }else{
                        $fileArrayIndices = file($fileIndicesDetalles);
                        $fileArrayIndicesNombres = file($fileIndicesNombres);
                        $acumuladoFseekDetalle=0;
                        $acumuladoFseekNombre=0;
                        while(list($var, $val) = each($fileArrayIndices)){
                            print "$var: $acumuladoFseekDetalle +$val<br/>";
                            if($var==$id){
                                $cantCaracDetalle+=$val;
                                print "$cantCaracDetalle carac<br/>";
                                break;
                            }else{
                                $acumuladoFseekDetalle += $val+2;
                            }
                        }
                        print "---<br/>";
                        while(list($varr, $vall) = each($fileArrayIndicesNombres)){
                            //print "$varr: $acumuladoFseekNombre +$vall<br/>";
                            if($varr==$id){
                                $cantCaracNombre+=$vall;
                                //print "$cantCaracNombre caracNom<br/>";
                                break;
                            }else{
                                $acumuladoFseekNombre += $vall+2;
                            }
                        }
                        fseek($handle, $acumuladoFseekNombre); 
                        fseek($handle2, $acumuladoFseekDetalle);
                    }  
                    $resNombre=fread($handle, $cantCaracNombre);
                    $resDetalle=fread($handle2, $cantCaracDetalle);
                    print ':'.$resNombre.'+'.$resDetalle.'<br>';
                    echo '<input type="text" value="'.$resNombre.'" name="txt_work">';
                    //cargarFormEdicion();
                    rewind($handle);rewind($handleIndicesNombres);
                    rewind($handle2);rewind($handleIndicesDetalles);

                    fclose($handle2);
                    fclose($handleIndicesDetalles);
                    fclose($handle);
                    fclose($handleIndicesNombres);
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