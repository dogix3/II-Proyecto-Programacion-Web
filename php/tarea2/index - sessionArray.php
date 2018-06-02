<?php 
    function CrearTabla($sesion_eventos)
    {
        $table_str='';
        foreach ($sesion_eventos as $obj_key => $obj){ 
            $table_str.='<tr id="'.$obj_key.'">';
            while(list ($key, $value)=each ($obj)){
                $table_str.='<td>'.$value.'</td>';
            }
            $table_str.='<td><form method="post">
                <button type="submit" name="eliminar" value="'.$obj_key.'">Eliminar</button>
                </td>';
            $table_str.='</form></tr>';      
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
        //$_SESSION['sesion_eventos']="";  
        echo '<table><thead><tr>
              <th>Día</th><th>Hora</th><th>Evento</th><th>Operación</th>
              </tr></thead><tbody>';
        
        if (isset($_POST['agregar'])) 
        {  
            $dia = $_POST['txt_dia'];
            $hora = $_POST['txt_hora'];
            $evento = $_POST['txt_evento'];            
            $_SESSION['sesion_eventos'][] = array($dia, $hora, $evento); 
        }
        if(empty ($_SESSION['sesion_eventos'])){
            $_SESSION['sesion_eventos'][] = array('23/02/2013', '10:30am', 'Reunión con mercadeo');
        }
        if (isset($_POST['eliminar'])) 
        {  
            unset($_SESSION['sesion_eventos'][$_POST['eliminar']]);
        }
        
        echo crearTabla($_SESSION['sesion_eventos']);
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