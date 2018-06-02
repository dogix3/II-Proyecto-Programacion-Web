<?php 

function CrearTablaProductos($array_productos)
{
	$str='';
	$str.="<table><thead><tr>
	      <th>Cantidad</th><th>Descripcion</th><th>ValUnit</th><th>SubTotal</th><th>Acción</th>
	      </tr></thead><tbody>";
	foreach ($array_productos as $key => $product) {

		$str.= "<form method='get' action='index.php'><tr>";
		$str.= "<td>". $product['cantidad'] ."</td>";
		$str.= "<td>". $product['descripcion'] ."</td>";
		$str.= "<td>". $product['valUnit'] ."</td>";
		$str.= "<td>". $product['subTotal'] ."</td>";
		$str.= "<td><button type='submit' name='eliminar' value='". $key ."'>Eliminar</button></td>";
        $str.="</tr></form>";
	}
	$str.="<form><tr><td><input type='text' name='txt_cant'></td>";
	$str.="<td><input style='width:8em;' type='text' name='txt_descrip'></td>";
	$str.="<td><input type='text' name='txt_valUnit'></td>";
	$str.="<td><input type='text' name='txt_subTotal'></td>";
	$str.="<td><button type='submit' name='agregar' value=''>Agregar</button></td>";
	$str.="</tr></form></tbody></table>";
	$str.="Taxes: 471.90  Total: 4701.90"; 
	// para obtener taxes una fun obt_taxes($array_productos)

	$str.="<br><button type='submit' name='cancelar' value='1'>Cancelar</button>";
	$str.="<button type='submit' name='guardar' value='1'>Guardar</button>";
	$str.="</form>";
	return $str;
}
function crearCabecera($prodEstado)
{
	$str='';
	if ($prodEstado='Nuevo') {
		$str.="<form method='get' action='index.php'>";
		$str.='Num <input type="text" name="txt_factura_num" style="width:6em;">&nbsp&nbsp';
		$str.='Fecha <input type="text" name="txt_fecha" style="width:6em;"><br>';
		$str.='Cliente <input type="text" name="txt_cliente" style="width:8em;">';
	}elseif ($prodEstado='Buscado') {
		$str.="<form method='get' action='index.php'>";
		$str.='Num <input value="'.$fact.'" type="text" name="txt_factura_num" style="width:6em;" disabled>&nbsp&nbsp';
		$str.='Fecha <input value="'.$fecha.'" type="text" name="txt_fecha" style="width:6em;"><br>';
		$str.='Cliente <input value="'.$cliente.'" type="text" name="txt_cliente" style="width:8em;">';
	}
	return $str;	
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


// Select all data from file db messages table 
$result = $file_db->query('SELECT * FROM facturas');
$str='';
$str="<table><thead><tr>
      <th>Factura_num</th><th>Fecha</th><th>Cliente</th><th>Impuestos</th><th>MontoTotal</th><th>Acción</th>
      </tr></thead><tbody>";
foreach($result as $row) {
	$str.= "<form method='get' action='index.php'><td>". $row['factura_num'] ."</td>";
	$str.= "<td>". $row['fecha'] ."</td>";
	$str.= "<input type='hidden' name='txt_fecha' value='". $row['fecha'] ."'></input>";
	$str.= "<td>". $row['cliente'] ."</td>";
	$str.= "<input type='hidden' name='txt_cliente' value='". $row['cliente'] ."'></input>";
	$str.= "<td>". $row['impuestos'] ."</td>";
	$str.= "<td>". $row['montoTotal'] ."</td>";
	$str.= "<td>
<button type='submit' name='buscar' value='". $row['factura_num'] ."'>Buscar</button></td></form>";
}
$str.="</tbody></table><br><form method='get' action='index.php'>";
$str.="<button type='submit' name='nuevo' value='1'>Nuevo</button>";
$str.="</form>";
echo $str;



echo "<br><h3>Facturación</h2>";
$array_productos= array();
session_start();
//$prodEstado='';
$_SESSION['prodEstado']='';
if (isset($_GET['buscar'])) {
	$fact=$_GET['buscar'];
	print"Buscar ";
	$fecha=$_GET['txt_fecha'];
	$cliente=$_GET['txt_cliente'];
	
	$_SESSION['prodEstado']='Buscado';
	// Select all data from file db messages table 
	$result = $file_db->query("SELECT * FROM productos WHERE factura_num='".$fact."'");
	$str='';
	$str.="<form method='get' action='index.php'>";
	$str.='Num <input value="'.$fact.'" type="text" name="txt_factura_num" style="width:6em;" disabled>&nbsp&nbsp';
	$str.='Fecha <input value="'.$fecha.'" type="text" name="txt_fecha" style="width:6em;"><br>';
	$str.='Cliente <input value="'.$cliente.'" type="text" name="txt_cliente" style="width:8em;">';

	$str.="<table><thead><tr>
	      <th>Cantidad</th><th>Descripcion</th><th>ValUnit</th><th>SubTotal</th><th>Acción</th>
	      </tr></thead><tbody>";
	foreach($result as $key => $row) {
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
	$str.= "<form method='get' action='index.php'>";
	$str.="<tr><td><input type='text' name='txt_cant'></td>";
	$str.="<td><input style='width:8em;' type='text' name='txt_descrip'></td>";
	$str.="<td><input type='text' name='txt_valUnit'></td>";
	$str.="<td><input type='text' name='txt_subTotal'></td>";
	$str.="<td><button type='submit' name='agregar'>Agregar</button></td>";
	$str.="</tr></form></tbody></table>";
	$str.="Taxes: 471.90  Total: 4701.90"; 
	// para obtener taxes una fun obt_taxes($array_productos)

	$str.="<br><button type='submit' name='cancelar' value='1'>Cancelar</button>";
	$str.="<button type='submit' name='guardar' value='2'>Guardar</button>";
	$str.="</form>";

	echo $str;

	
}

if (isset($_GET['eliminar'])) {
	print " Eliminar ".$_GET['eliminar'];
	echo crearCabecera($_SESSION['prodEstado']);
	unset($_SESSION['array_productos'][$_GET['eliminar']]);
	print "<br>";
	echo CrearTablaProductos($_SESSION['array_productos']);
}
if (isset($_GET['agregar'])) {
	print " Agregar ".$_GET['agregar'];

	$_SESSION['array_productos'][]= array('cantidad'=>$_GET['txt_cant'], 'descripcion'=>$_GET['txt_descrip'], 'valUnit'=>$_GET['txt_valUnit'], 'subTotal'=>$_GET['txt_subTotal']);

	echo crearCabecera($_SESSION['prodEstado']);
	echo CrearTablaProductos($_SESSION['array_productos']);
	//header('index.php');
	//ob_flush();
}

if (isset($_GET['nuevo'])) {
	$_SESSION['prodEstado']='Nuevo';
	echo crearCabecera($_SESSION['prodEstado']);
	$_SESSION['array_productos']= array();
	echo CrearTablaProductos($_SESSION['array_productos']);

}

if (isset($_GET['guardar'])) {
	print "Guardar: ".$_GET['guardar'] ."<br> ";
	$guardar=$_GET['guardar'];

	$fact=$_GET['txt_factura_num'];
	$fecha=$_GET['txt_fecha'];
	$cliente=$_GET['txt_cliente'];

	if ($fact!='') {
		print $_GET['txt_factura_num'].'<br>';
		print $_GET['txt_fecha'].'<br>';
		print $_GET['txt_cliente'].'<br>';

		$array_productos= $_SESSION['array_productos'];
		if ($guardar=='1') {
			print "Nuevo ";
			$update2='';
			foreach ($array_productos as $key => $product) {
					$update2.="INSERT INTO productos VALUES (".$fact.", '".$product['cantidad']."', '".$product['descripcion']."', '".$product['valUnit']."', '".$product['subTotal']."')";
			}
			print $update2;
			$stmt = $file_db->prepare($update2);
			$stmt->execute();
		//	$result = $file_db->query("SELECT * FROM productos WHERE factura_num='".$fact."'");
		}else{
			print "Buscado ";

		}
		$update2="UPDATE facturas SET fecha = '".$fecha."', cliente= '".$cliente."' WHERE factura_num=".$fact."";
		print $update2;
		$stmt = $file_db->prepare($update2);
		$stmt->execute();
	}

}

if (isset($_GET['cancelar'])) {
	print "Cancelar";
	$_SESSION['array_productos']= array();
	//echo CrearTablaProductos($_SESSION['array_productos']);
	header('index.php');
}

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
