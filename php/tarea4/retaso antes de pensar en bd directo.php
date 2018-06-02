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
function CrearTabla3($array_productos)
{
	$str='';
	//$str="Factura_num: 123 <br><br>";
	$str.="<form method='get' action='index.php'><table><thead><tr>
	      <th>Cantidad</th><th>Descripcion</th><th>ValUnit</th><th>SubTotal</th><th>Acción</th>
	      </tr></thead><tbody>";
	foreach($result as $key => $row) {
		//$array_productos_temp[0] = $row['cantidad'];
		//$array_productos_temp[1] = $row['descripcion'];
		//$array_productos_temp[2] = $row['valUnit'];
		//$array_productos_temp[3] = $row['subTotal'];

		$_SESSION['array_productos'][]= array('cantidad'=>$row['cantidad'], 'descripcion'=>$row['descripcion'], 'valUnit'=>$row['valUnit'], 'subTotal'=>$row['subTotal']);

		$str.= "<form method='get' action='index.php'>";
		$str.="<input type='hidden' name='txt_factura_num' style='display:none' value='". $row['factura_num'] ."'></input>";
		$str.= "<tr><td>". $row['cantidad'] ."</td>";
		$str.= "<td>". $row['descripcion'] .$key."</td>";
		$str.= "<td>". $row['valUnit'] ."</td>";
		$str.= "<td>". $row['subTotal'] ."</td>";
		$str.= "<td>
	<button type='submit' name='eliminar' value='". $key ."'>Eliminar</button></td></tr></form>";
	}
	$str.="<form><tr><td><input type='text' name='txt_cant'></td>";
	$str.="<td><input style='width:8em;' type='text' name='txt_descrip'></td>";
	$str.="<td><input type='text' name='txt_valUnit'></td>";
	$str.="<td><input type='text' name='txt_subTotal'></td>";
	$str.="<td><button type='submit' name='agregar' value=''>Agregar</button></td>";
	$str.="</tr></form></tbody></table>";
	$str.="Taxes: 471.90  Total: 4701.90"; 
	// para obtener taxes una fun obt_taxes($array_productos)

	$str.="<br><button type='submit' name='nuevo' value='1'>Cancelar</button>";
	$str.="<button type='submit' name='nuevo' value='1'>Guardar</button>";
	$str.="</form>";
	echo $str;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Tarea4-SQLite</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

</body>
</html>
<?php

// Set default timezone
date_default_timezone_set('UTC');

try {
/**************************************
* Create databases and                *
* open connections                    *
**************************************/

// Create (connect to) SQLite database in file
$file_db = new PDO('sqlite:clientes.db');
// Set errormode to exceptions
$file_db->setAttribute(PDO::ATTR_ERRMODE, 
	PDO::ERRMODE_EXCEPTION);


/**************************************
* Create tables                       *
**************************************/
// Create table clientes
//$file_db->exec("sqlite:clientes.db");

// Create table facturas
$file_db->exec("CREATE TABLE IF NOT EXISTS facturas (
	factura_num INTEGER, 
	fecha TEXT, 
	cliente TEXT,
	impuestos TEXT,
	montoTotal TEXT);");
// Create table productos
$file_db->exec("CREATE TABLE IF NOT EXISTS productos (
	factura_num INTEGER PRIMARY KEY, 
	cantidad TEXT, 
	descripcion TEXT,
	valUnit TEXT,
	subTotal TEXT);");

/**************************************
* Play with databases and tables      *
**************************************/

// FIN_INSERTS ----------------
/*// Prepare INSERT statement to SQLite3 memory db
$insert = "INSERT INTO facturas (factura_num, fecha, cliente, impuestos, montoTotal) 
VALUES (:factura_num, :fecha, :cliente, :impuestos, :montoTotal)";
$stmt = $file_db->prepare($insert);
//********* Insert book 

// Bind parameters to statement variables
$stmt->bindParam(':factura_num', $factura_num);
$stmt->bindParam(':fecha', $fecha);
$stmt->bindParam(':cliente', $cliente);
$stmt->bindParam(':impuestos', $impuestos);
$stmt->bindParam(':montoTotal', $montoTotal);

// Set values to bound variables
$factura_num = 3455941;
$fecha = '25/03/2018';
$cliente = 'Gonzalo Mora';
$impuestos = '471.90';
$montoTotal = '2000';

// Execute statement
$stmt->execute();
 //inserts de facturas
*/

/*
 // INSERTS de productos ---------------------
// Prepare INSERT statement to SQLite3 memory db
$insert = "INSERT INTO productos (factura_num, cantidad, descripcion, valUnit, subTotal) 
VALUES (:factura_num, :cantidad, :descripcion, :valUnit, :subTotal)";
$stmt = $file_db->prepare($insert);
//********* Insert book 

// Bind parameters to statement variables
$stmt->bindParam(':factura_num', $factura_num);
$stmt->bindParam(':cantidad', $cantidad);
$stmt->bindParam(':descripcion', $descripcion);
$stmt->bindParam(':valUnit', $valUnit);
$stmt->bindParam(':subTotal', $subTotal);

// Set values to bound variables
$factura_num = 3455941;
$cantidad = '1';
$descripcion = 'Caja de leche';
$valUnit = '2000';
$subTotal = '2000';

// Execute statement
$stmt->execute();
*/
// FIN_INSERTS--------------------------
/*$update2 = "UPDATE facturas SET montoTotal = '2000' WHERE factura_num = 3455941";
$stmt = $file_db->prepare($update2);
$stmt->execute();*/

// Select all data from file db messages table 
$result = $file_db->query('SELECT * FROM facturas');
//print $result['factura_num']."<br>";
$str='';
$str="<form method='get' action='index.php'><table><thead><tr>
      <th>Factura_num</th><th>Fecha</th><th>Cliente</th><th>Impuestos</th><th>MontoTotal</th><th>Acción</th>
      </tr></thead><tbody>";
foreach($result as $row) {
	$str.= "<td>". $row['factura_num'] ."</td>";
	$str.= "<td>". $row['fecha'] ."</td>";
	$str.= "<td>". $row['cliente'] ."</td>";
	$str.= "<td>". $row['impuestos'] ."</td>";
	$str.= "<td>". $row['montoTotal'] ."</td>";
	$str.= "<td>
<button type='submit' name='buscar' value='". $row['factura_num'] ."'>Buscar</button></td>";
}
$str.="</tbody></table>";
$str.="<br><button type='submit' name='nuevo' value='1'>Nuevo</button>";
$str.="</form>";
echo $str;



echo "<br><h3>Facturación</h2>";
$array_productos= array();
session_start();

if (isset($_GET['buscar'])) {
	//$array_productos_temp= array();
	print"Factura_num ".$_GET['buscar'];
	$FACTURA = $_GET['buscar'];
	// Select all data from file db messages table 
	$result = $file_db->query("SELECT * FROM productos WHERE factura_num='".$_GET['buscar']."'");
	//print crearTabla($result);
	// Select all data from file db messages table 
	$str='';
	//$str="Factura_num: 123 <br><br>";
	$str.="<form method='get' action='index.php'><table><thead><tr>
	      <th>Cantidad</th><th>Descripcion</th><th>ValUnit</th><th>SubTotal</th><th>Acción</th>
	      </tr></thead><tbody>";
	foreach($result as $key => $row) {
		//$array_productos_temp[0] = $row['cantidad'];
		//$array_productos_temp[1] = $row['descripcion'];
		//$array_productos_temp[2] = $row['valUnit'];
		//$array_productos_temp[3] = $row['subTotal'];

		//$_SESSION['array_productos'][]= array('cantidad'=>$row['cantidad'], 'descripcion'=>$row['descripcion'], 'valUnit'=>$row['valUnit'], 'subTotal'=>$row['subTotal']);

		$str.= "<form method='get' action='index.php'>";
		$str.="<input type='hidden' name='txt_factura_num' style='display:none' value='". $row['factura_num'] ."'></input>";
		$str.= "<tr><td>". $row['cantidad'] ."</td>";
		$str.= "<td>". $row['descripcion'] .$key."</td>";
		$str.= "<td>". $row['valUnit'] ."</td>";
		$str.= "<td>". $row['subTotal'] ."</td>";
		$str.= "<td>
	<button type='submit' name='eliminar' value='". $key ."'>Eliminar</button></td></tr></form>";
	}
	$str.="<form><tr><td><input type='text' name='txt_cant'></td>";
	$str.="<td><input style='width:8em;' type='text' name='txt_descrip'></td>";
	$str.="<td><input type='text' name='txt_valUnit'></td>";
	$str.="<td><input type='text' name='txt_subTotal'></td>";
	$str.="<td><button type='submit' name='agregar' value=''>Agregar</button></td>";
	$str.="</tr></form></tbody></table>";
	$str.="Taxes: 471.90  Total: 4701.90"; 
	// para obtener taxes una fun obt_taxes($array_productos)

	$str.="<br><button type='submit' name='nuevo' value='1'>Cancelar</button>";
	$str.="<button type='submit' name='nuevo' value='1'>Guardar</button>";
	$str.="</form>";
	echo $str;

	//var_dump($array_productos);
	//print $result['factura_num']."<br>";
	/*$str='';
	$str="<form method='get' action='index.php'><table><thead><tr>
	      <th>Factura_num</th><th>Fecha</th><th>Cliente</th><th>Impuestos</th><th>MontoTotal</th><th>Acción</th>
	      </tr></thead><tbody>";
	foreach($result as $row) {
		$str.= "<td>". $row['factura_num'] ."</td>";
		$str.= "<td>". $row['cantidad'] ."</td>";
		$str.= "<td>". $row['descripcion'] ."</td>";
		$str.= "<td>". $row['valUnit'] ."</td>";
		$str.= "<td>". $row['subTotal'] ."</td>";
		$str.= "<td>
	<button type='submit' name='eliminar' value='". $row['factura_num'] ."'>Eliminar</button></td>";
	}
	//$str.= "<td></td>";
	$str.='<tr><form method="post">
                <td><input type="text" required name="txt_dia"></td>
                <td><input type="text" required name="txt_hora"></td>
                <td><input type="text" required name="txt_evento"></td>
                <td><input type="submit" name="agregar" value="Agregar"></td>
            </form></tr>';
	$str.= "<td><button type='submit' name='agregar' value='2'>Agregar</button></td>";
	$str.="</tbody></table>";
	//$str.="<br><button type='submit' name='agregar' value='2'>Agregar</button>";
	$str.="</form>";
	echo $str;*/
}

if (isset($_GET['eliminar'])) {
	print"Factura_num ".$_GET['txt_factura_num'];
	print" Eliminar ".$_GET['eliminar'];
	$fact = $_GET['txt_factura_num'];
	//$resultado = $file_db->arrayQuery("SELECT * FROM productos WHERE factura_num=".$fact."", SQLITE_ASSOC);
	
	//var_dump($_SESSION['array_productos'][0]);
	//echo crearTabla($_SESSION['array_productos']);
	//print $_SESSION['array_productos'][];
	$array_productos=$_SESSION['array_productos'];
	foreach ($array_productos as $key => $product) {
		//var_dump ($product);
		//print $product['factura_num'];
		foreach ($product as $key => $pro) {
			print $pro;
			//print $row;
		}
	}
	$str='';
	//$str="Factura_num: 123 <br><br>";
	$str.="<form method='get' action='index.php'><table><thead><tr>
	      <th>Cantidad</th><th>Descripcion</th><th>ValUnit</th><th>SubTotal</th><th>Acción</th>
	      </tr></thead><tbody>";
	foreach ($array_productos as $key => $product) {

		while(list ($key, $row)=each ($product)){
            //$table_str.='<td>'.$value.'</td>';
			print "$row";

			$str.= "<form method='get' action='index.php'>";
			$str.="<input type='hidden' name='txt_factura_num' style='display:none' value='". $row['factura_num'] ."'></input>";
			$str.= "<tr><td>". $row['cantidad'] ."</td>";
			$str.= "<td>". $row['descripcion'] .$key."</td>";
			$str.= "<td>". $row['valUnit'] ."</td>";
			$str.= "<td>". $row['subTotal'] ."</td>";
			$str.= "<td>
		<button type='submit' name='eliminar' value='". $key ."'>Eliminar</button></td></tr></form>";
        }

	}
	$str.="<form><tr><td><input type='text' name='txt_cant'></td>";
	$str.="<td><input style='width:8em;' type='text' name='txt_descrip'></td>";
	$str.="<td><input type='text' name='txt_valUnit'></td>";
	$str.="<td><input type='text' name='txt_subTotal'></td>";
	$str.="<td><button type='submit' name='agregar' value=''>Agregar</button></td>";
	$str.="</tr></form></tbody></table>";
	$str.="Taxes: 471.90  Total: 4701.90"; 
	// para obtener taxes una fun obt_taxes($array_productos)

	$str.="<br><button type='submit' name='nuevo' value='1'>Cancelar</button>";
	$str.="<button type='submit' name='nuevo' value='1'>Guardar</button>";
	$str.="</form>";
	echo $str;

	//print $table_str;
	//var_dump($resultado);
	//unset($array_productos($_GET['eliminar']));

}
// seccion de buscar
// num input fecha input deshabilitado en caso de buscar
// cliente input 

// tabla de productos de la compra tal
//// cant 	descrip 		valUnit subTotal  accion
//// 1		cajas de leche	2000	2000	  eliminar  -> value=pos (unset pos del array)  
/// eliminar
/// 
// agregar para nuevos productos en array
//// $array-productos (cant->1, descrip->cepillos de dientes, valUnit->2000, subTotal->2000)
////
// cancelar / Taxes: 471.90 Total: 4701.90 / Guardar factura


// seccion de nuevo
// establecer arrays a []
// if isset de cada cosa valida que la tabla no salga 2 veces gracias al form bien definido
// num input fecha-predefinida / inputs habilitados en caso de nuevo
// cliente input 

// tabla de productos vacia de nueva compra
// agregar para nuevos productos
// cancelar / Taxes: 471.90 Total: 4701.90 / Guardar factura





/**************************************
* Drop tables                         *
**************************************/

// Drop table messages from file db
//$file_db->exec("DROP TABLE books");
//$file_db->exec("DROP TABLE authors");
// Drop table messages from memory db
//$memory_db->exec("DROP TABLE messages");


/**************************************
* Close db connections                *
**************************************/

// Close file db connection
$file_db = null;
// Close memory db connection
$memory_db = null;
}
catch(PDOException $e) {
// Print PDOException message
	echo $e->getMessage();
}


?>
