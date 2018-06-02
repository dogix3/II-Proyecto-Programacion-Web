<?php 
    function crearTabla($filename)
    {
        $filearray = file($filename);
        while(list($var, $val) = each($filearray)){
            ++$var;
            $val = trim($val);
            print "$var: $val <br/>";
        }
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
        <h4>Info</h4><br>

            <?php 
                $inputsArray=['Name', 'Work', 'Mobile', 'Email', 'Address'];
                $inputsTxtArray=['txt_name', 'txt_work', 'txt_mobile', 'txt_email', 'txt_address'];
                
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
                        $cantCaracDetalle=fread($handleIndicesDetalles, 2);
                        $cantCaracNombre=fread($handleIndicesNombres, 1); // num de caract en nombre
                        fseek($handle2, 0); // detalle.txt
                    }else{
                        $fileArrayIndices = file($fileIndicesDetalles);
                        $fileArrayIndicesNombres = file($fileIndicesNombres);
                        $acumuladoFseekDetalle=0;
                        $acumuladoFseekNombre=0;
                        while(list($var, $val) = each($fileArrayIndices)){
                            //print "$var: $acumuladoFseekDetalle +$val<br/>";
                            if($var==$id){
                                $cantCaracDetalle+=$val;
                                break;
                            }else{
                                $acumuladoFseekDetalle += $val+2;
                            }
                        }
                        while(list($varr, $vall) = each($fileArrayIndicesNombres)){
                            if($varr==$id){
                                $cantCaracNombre+=$vall;
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
                    $resDetalleArray= explode('|', $resDetalle);
                    //print ':'.$resNombre.'+'.$resDetalle.'<br>';
                    $inputs_str='';
                    foreach ($resDetalleArray as $obj_key => $obj){                         
                        $inputs_str.='<p>'.$inputsArray[$obj_key].' <input type="text" value="'.$obj.'" name="'.$inputsTxtArray[$obj_key].'"></p>';
                    }
                    echo $inputs_str;

                    fclose($handle2);
                    fclose($handleIndicesDetalles);
                    fclose($handle);
                    fclose($handleIndicesNombres);
                }                
            ?>
 
    </div>
    </main>
</body>
</html>