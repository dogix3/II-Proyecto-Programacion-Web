<?php 
    function CrearTabla($str)
    {
        $table_str='';
        if($str!=''){
            $str = explode('|', $str);            
            foreach( $str as $key => $value ){
                if($key==0 ){
                    $table_str.='<tr><td>'.$str[$key].'</td>';
                    $table_str.='<td>'.$str[$key+1].'</td>';
                    $table_str.='<td>'.$str[$key+2].'</td>';
                    $table_str.='<td><form method="post">
                    <button type="submit" name="eliminar" value="'.$key.'">Eliminar</button>
                    </td></form></tr>';
                }elseif($key%3==0 && $key!=count($str)-1 ){
                    $table_str.='<tr><td>'.$str[$key].'</td>';
                    $table_str.='<td>'.$str[$key+1].'</td>';
                    $table_str.='<td>'.$str[$key+2].'</td>';
                    $table_str.='<td><form method="post">
                    <button type="submit" name="eliminar" value="'.$key.'">Eliminar</button>
                    </td></form></tr>';
                }else{
                }
            }
        }                    
        return $table_str;
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
        table{
            width: 85%;
        }
        thead{
            background-color: #a9a9a9;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 0.3em 1.5em 0.3em 1.5em;
            text-align: center;
        }
        table tr:nth-child(even) {
            background-color: #eee;
        }
        input{
            width:90px;
        }
    </style>
</head>
<body>
    <h2>Calendario de eventos</h2>
    <?php 
        session_start();
        //$_COOKIE['cookie']="";
        //setcookie("cookie", "");  
        echo '<table><thead><tr>
              <th>Día</th><th>Hora</th><th>Evento</th><th>Operación</th>
              </tr></thead><tbody>';

        if (isset($_POST['agregar'])) 
        {  
            $dia = $_POST['txt_dia'];
            $hora = $_POST['txt_hora'];
            $eve = $_POST['txt_evento']; 
            $cadTotal='';
            $cadTotal=$_COOKIE["cookie"];            
            $cadTotal.=$dia.'|'.$hora.'|'.$eve.'|';
            echo $cadTotal;
            setcookie("cookie", $cadTotal); 
            echo crearTabla($cadTotal);                     
        }
        
        if (isset($_POST['eliminar'])) 
        {  
            $cadTotal='';
            $cadTotal = $_COOKIE["cookie"];
            $cadTotal = explode('|', $cadTotal);
            unset ($cadTotal[$_POST['eliminar']]);
            unset ($cadTotal[$_POST['eliminar']+1]);
            unset ($cadTotal[$_POST['eliminar']+2]);
            $cadTotal = implode('|', $cadTotal);
            setcookie("cookie", $cadTotal);
            echo crearTabla($cadTotal); 
            
        }   

        echo
            '<tr><form method="post">
                <td><input type="text" required name="txt_dia"></td>
                <td><input type="text" required name="txt_hora"></td>
                <td><input type="text" required name="txt_evento"></td>
                <td><input type="submit" name="agregar" value="Agregar"></td>
            </form></tr>';
        echo '</tbody></table>';
        ob_flush();
    ?>
</body>
</html>