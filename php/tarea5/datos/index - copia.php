<?php 

function CrearTablaProductos($array_productos)
{
	$str='';
		$str.="<form method='get' action='index.php'>";
	$str.='Num <input value="'.$_SESSION['fact'].'" type="text" name="txt_factura_num" style="width:6em;">&nbsp&nbsp';
	$str.='Fecha <input value="'.$_SESSION['fecha'].'" type="text" name="txt_fecha" style="width:6em;"><br>';
	$str.='Cliente <input value="'.$_SESSION['cliente'].'" type="text" name="txt_cliente" style="width:8em;">';
	$str.="<table><thead><tr>
	      <th>Cantidad</th><th>Descripcion</th><th>ValUnit</th><th>SubTotal</th><th>Acción</th>
	      </tr></thead><tbody>";
	if (!empty($array_productos)) {
		foreach ($array_productos as $key => $product) {
			$str.= "<form method='get' action='index.php'><tr>";
			$str.= "<td>". $product['cantidad'] ."</td>";
			$str.= "<td>". $product['descripcion'] ."</td>";
			$str.= "<td>". $product['valUnit'] ."</td>";
			$str.= "<td>". $product['subTotal'] ."</td>";
			$str.= "<td><button type='submit' name='eliminar' value='". $key ."'>Eliminar</button></td>";
	        $str.="</tr></form>";
		}
	}
	///$str.= "<form method='get' action='index.php'>";
	//$str.="<input type='hidden' name='txt_factura_num' style='display:none' value='". $_SESSION['fact'] ."'></input>";
	//$str.="<input type='hidden' name='txt_fecha' style='display:none' value='". $_SESSION['fecha'] ."'></input>";
	//$str.="<input type='hidden' name='txt_cliente' style='display:none' value='". $_SESSION['cliente'] ."'></input>";
	$str.="<tr><td><input type='text' name='txt_cant'></td>";
	$str.="<td><input style='width:8em;' type='text' name='txt_descrip'></td>";
	$str.="<td><input type='text' name='txt_valUnit'></td>";
	$str.="<td><input type='text' name='txt_subTotal'></td>";
	$str.="<td><button type='submit' name='agregar' value='2'>Agregar</button></td>";
	$str.="</tr>";
	///$str.="</form>";
	$str.="</tbody></table>";
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
	$str.="<form method='get' action='index.php'>";
	$str.='Num <input value="'.$_SESSION['fact'].'" type="text" name="txt_factura_num" style="width:6em;">&nbsp&nbsp';
	$str.='Fecha <input value="'.$_SESSION['fecha'].'" type="text" name="txt_fecha" style="width:6em;"><br>';
	$str.='Cliente <input value="'.$_SESSION['cliente'].'" type="text" name="txt_cliente" style="width:8em;">';
	/*if ($prodEstado='Nuevo') {
		$str.="<form method='get' action='index.php'>";
		$str.='Num <input type="text" name="txt_factura_num" style="width:6em;">&nbsp&nbsp';
		$str.='Fecha <input type="text" name="txt_fecha" style="width:6em;"><br>';
		$str.='Cliente <input type="text" name="txt_cliente" style="width:8em;">';
	}elseif ($prodEstado='Buscado') {
		$str.="<form method='get' action='index.php'>";
		$str.='Num <input value="'.$fact.'" type="text" name="txt_factura_num" style="width:6em;">&nbsp&nbsp';
		$str.='Fecha <input value="'.$fecha.'" type="text" name="txt_fecha" style="width:6em;"><br>';
		$str.='Cliente <input value="'.$cliente.'" type="text" name="txt_cliente" style="width:8em;">';
	}*/
	return $str;	
}
function actualizarTabla($fact)
{
	$pathProductos = "productos.json";
	$data = file_get_contents($pathProductos);
	$result2 = json_decode($data, true);

	foreach ($result2['productos'] as $key => $row) {
	    if ($row['factura_num'] == $fact) {
	        //$result2[$key]['factura_num'] = "TENNIS";
	        $array_productos[]= array('cantidad'=>$row['cantidad'], 'descripcion'=>$row['descripcion'], 'valUnit'=>$row['valUnit'], 'subTotal'=>$row['subTotal']);
	    }
	}

	$str='';
	if (!empty($array_productos)) {
		$tax=0;
		$TotalSubTotal=0;
		$str.="<form method='get' action='index.php'>";
		$str.='Num <input value="'.$_SESSION['fact'].'" type="text" name="txt_factura_num" style="width:6em;">&nbsp&nbsp';
		$str.='Fecha <input value="'.$_SESSION['fecha'].'" type="text" name="txt_fecha" style="width:6em;"><br>';
		$str.='Cliente <input value="'.$_SESSION['cliente'].'" type="text" name="txt_cliente" style="width:8em;">';

		$str.="<table><thead><tr>
		      <th>Cantidad</th><th>Descripcion</th><th>ValUnit</th><th>SubTotal</th><th>Acción</th>
		      </tr></thead><tbody>";
		foreach($array_productos as $key => $row) {
			//$_SESSION['array_productos'][]= array('cantidad'=>$row['cantidad'], 'descripcion'=>$row['descripcion'], 'valUnit'=>$row['valUnit'], 'subTotal'=>$row['subTotal']);

			$str.= "<form method='get' action='index.php'>";
			$str.="<input type='hidden' name='txt_factura_num' style='display:none' value='". $fact ."'></input>";
			$str.= "<tr><td>". $row['cantidad'] ."</td>";
			$str.= "<td>". $row['descripcion'] ."</td>";
			$str.= "<td>". $row['valUnit'] ."</td>";
			$str.= "<td>". $row['subTotal'] ."</td>";
			$str.= "<td>
		<button type='submit' name='eliminar' value='". $key ."'>Eliminar</button></td></tr></form>";
			//$TotalSubTotal.=$row['subTotal'];
		}
		///$str.= "<form method='get' action='index.php'>";
		//$str.="<input type='hidden' name='txt_factura_num' style='display:none' value='". $fact ."'></input>";
		//$str.="<input type='hidden' name='txt_fecha' style='display:none' value='". $_SESSION['fecha'] ."'></input>";
		//$str.="<input type='hidden' name='txt_cliente' style='display:none' value='". $_SESSION['cliente'] ."'></input>";
		$str.="<tr><td><input type='text' name='txt_cant'></td>";
		$str.="<td><input style='width:8em;' type='text' name='txt_descrip'></td>";
		$str.="<td><input type='text' name='txt_valUnit'></td>";
		$str.="<td><input type='text' name='txt_subTotal'></td>";
		$str.="<td><button type='submit' name='agregar' value='1'>Agregar</button></td>";
		$str.="</tr>";
		///$str.="</form>";
		$str.="</tbody></table>";
		$str.="Taxes: 471.90  Total: 4701.90"; 
		// para obtener taxes una fun obt_taxes($array_productos)
		//$tax= $TotalSubTotal*0.13;
		$str.="<br><button type='submit' name='cancelar' value='1'>Cancelar</button>";
		$str.="<button type='submit' name='guardar' value='2'>Guardar</button>";
		$str.="</form>";
	}else{
		$str='No se ha encontrado';
	}

	return $str;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tarea4-SQLite</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

</body>
</html>
<?php

$pathFacturas = "facturas.json";
$pathProductos = "productos.json";
if (!file_exists($pathFacturas))
    exit("Facturas.json not found");
if (!file_exists($pathProductos))
    exit("Productos.json not found");

$data = file_get_contents($pathFacturas);
$result = json_decode($data, true);

$str='';
$str="<table><thead><tr>
      <th>Factura_num</th><th>Fecha</th><th>Cliente</th><th>Impuestos</th><th>MontoTotal</th><th>Acción</th>
      </tr></thead><tbody>";
foreach($result['facturas'] as $row) {
	$str.= "<form method='get' action='index.php'><tr><td>". $row['factura_num'] ."</td>";
	$str.= "<td>". $row['fecha'] ."</td>";
	$str.= "<input type='hidden' name='fecha' value='". $row['fecha'] ."'></input>";
	$str.= "<td>". $row['cliente'] ."</td>";
	$str.= "<input type='hidden' name='cliente' value='". $row['cliente'] ."'></input>";
	$str.= "<td>". $row['impuestos'] ."</td>";
	$str.= "<td>". $row['montoTotal'] ."</td>";
	$str.= "<td>
<button type='submit' name='buscar' value='". $row['factura_num'] ."'>Buscar</button></tr></td></form>";
}
$str.="</tbody></table><br><form method='get' action='index.php'>";
$str.="<button style='padding:0.7em; padding-bottom: 1.5em;' type='submit' name='nuevo' value='1'>Nuevo</button>";
$str.="</form>";
echo $str;



echo "<br><h3>Facturación</h3>";
$array_productos= array();
session_start();
//$prodEstado='';

//$_SESSION['fact']='';
//$_SESSION['fecha']='';
//$_SESSION['cliente']='';

$_SESSION['prodEstado']='';

if (isset($_GET['buscar'])) {
	$fact=$_GET['buscar'];
	$fecha=$_GET['fecha'];
	$cliente=$_GET['cliente'];

	$_SESSION['fact']=$fact;
	$_SESSION['fecha']=$fecha;
	$_SESSION['cliente']=$cliente;

	print"Buscar ";
	$_SESSION['prodEstado']='Buscado';

	$array_productos= array();
	//$data = file_get_contents($pathProductos);
	//$result2 = json_decode($data, true);
	//echo crearCabecera($_SESSION['prodEstado']);
	$str=actualizarTabla($fact);

	
	
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


	$fact=$_GET['txt_factura_num'];
	$fecha=$_GET['txt_fecha'];
	$cliente=$_GET['txt_cliente'];

	$_SESSION['fact']=$fact;
	$_SESSION['fecha']=$fecha;
	$_SESSION['cliente']=$cliente;

	print " Agregar ".$fact;

	$data = file_get_contents($pathProductos);
	$result2 = json_decode($data, true);
	//$_SESSION['array_productos'][]= array('cantidad'=>$_GET['txt_cant'], 'descripcion'=>$_GET['txt_descrip'], 'valUnit'=>$_GET['txt_valUnit'], 'subTotal'=>$_GET['txt_subTotal']);

	$result2['productos'][]= array('factura_num'=>$fact, 'cantidad'=>$_GET['txt_cant'], 'descripcion'=>$_GET['txt_descrip'], 'valUnit'=>$_GET['txt_valUnit'], 'subTotal'=>$_GET['txt_subTotal']);

	$data = json_encode($result2);
	file_put_contents($pathProductos, $data);

	//echo crearCabecera($_SESSION['prodEstado']);
	//echo CrearTablaProductos($_SESSION['array_productos']);
	$str=actualizarTabla($fact);
	echo $str;
	//echo CrearTablaProductos($result2['productos']);

	//header('index.php');
}

if (isset($_GET['nuevo'])) {
	$_SESSION['prodEstado']='Nuevo';
	
	$_SESSION['fact']="";
	$_SESSION['fecha']="";
	$_SESSION['cliente']="";

	//echo crearCabecera($_SESSION['prodEstado']);
	$array_productos = array();
	echo CrearTablaProductos($array_productos);

}

if (isset($_GET['guardar'])) {
	$guardar=$_GET['guardar'];

	$fact=$_GET['txt_factura_num'];
	$fecha=$_GET['txt_fecha'];
	$cliente=$_GET['txt_cliente'];

	print "Guardar: ".$guardar.", ". $fact."<br> ";

	if ($fact!='') {
		print $fact.'<br>';
		print $fecha.'<br>';
		print $cliente.'<br>';

		$data = file_get_contents($pathFacturas);
		$result = json_decode($data, true);
		$result['facturas'][]= array('factura_num'=>$fact, 'fecha'=>$fecha, 'cliente'=>$cliente, 'impuestos'=>'impuestos', 'montoTotal'=>'montoTotal');
		//$result['facturas'][]= array('factura_num'=>$fact, 'fecha'=>$_GET['txt_cant'], 'cliente'=>$_GET['txt_descrip'], 'impuestos'=>$_GET['txt_valUnit'], 'montoTotal'=>$_GET['txt_subTotal']);

		$data = json_encode($result);
		file_put_contents($pathFacturas, $data);

		echo "<br><a href='index.php'>Recargar</a>";
		header('.\index.php');
	}

	/*if ($fact!='') {
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
	}*/

}

if (isset($_GET['cancelar'])) {
	print "Cancelar";
	$_SESSION['array_productos']= array();
	//echo CrearTablaProductos($_SESSION['array_productos']);
	header('index.php');
}



?>
