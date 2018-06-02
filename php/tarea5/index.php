<?php 

function CrearTablaProductos($array_productos)
{
	$str='';
		$str.="<form method='get' action='index.php'>";
	$str.='Factura_num <input value="'.$_SESSION['fact'].'" type="text" name="txt_factura_num" style="width:6em;">&nbsp&nbsp';
	$str.='Fecha <input value="'.$_SESSION['fecha'].'" type="text" name="txt_fecha" style="width:6em;"><br>';
	$str.='Cliente <input value="'.$_SESSION['cliente'].'" type="text" name="txt_cliente" style="width:8em;">';
	$str.="<table><thead><tr>
	      <th>Cantidad</th><th>Descripcion</th><th>ValUnit</th><th>SubTotal</th><th>Acción</th>
	      </tr></thead><tbody>";
	if (!empty($array_productos)) {
		foreach ($array_productos as $key => $product) {
			$str.= "<form method='get' action='index.php'><tr>";
			$str.= "<td>". $product['cantidad'] ."</td>";
			$str.="<input type='hidden' name='descripcion' style='display:none' value='". $row['descripcion'] ."'></input>";
			$str.= "<td>". $product['descripcion'] ."</td>";
			$str.= "<td>". $product['valUnit'] ."</td>";
			$str.= "<td>". $product['subTotal'] ."</td>";
			$str.= "<td><button type='submit' name='eliminar' value='". $key ."'>Eliminar</button></td>";
	        $str.="</tr></form>";
		}
	}
	$str.="<tr><td><input type='text' name='txt_cant'></td>";
	$str.="<td><input style='width:8em;' type='text' name='txt_descrip'></td>";
	$str.="<td><input type='text' name='txt_valUnit'></td>";
	$str.="<td><input type='text' name='txt_subTotal'></td>";
	$str.="<td><button type='submit' name='agregar' value='2'>Agregar</button></td>";
	$str.="</tr>";
	$str.="</tbody></table>";
	$str.="<input type='hidden' name='txt_totalSubTotal' style='display:none' value='0'></input>";
	$str.="TotalSubTotal<input disabled type='text' value='0'></input>";
	$str.="<input type='hidden' name='txt_taxes' style='display:none' value='0'></input>";
	$str.="Taxes<input disabled type='text' value='0'></input>";
	$str.="<input type='hidden' name='txt_total' style='display:none' value='0'></input>";
	$str.="Total<input disabled style='width:8em;' type='text' value='0'></input>";
	$str.="<br><button type='submit' name='cancelar' value='1'>Cancelar</button>";
	$str.="<button type='submit' name='guardar' value='1'>Guardar</button>";
	$str.="</form>";
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
		$str.='Factura_num <input value="'.$_SESSION['fact'].'" type="text" name="txt_factura_num" style="width:6em;">&nbsp&nbsp';
		$str.='Fecha <input value="'.$_SESSION['fecha'].'" type="text" name="txt_fecha" style="width:6em;"><br>';
		$str.='Cliente <input value="'.$_SESSION['cliente'].'" type="text" name="txt_cliente" style="width:8em;">';

		$str.="<table><thead><tr>
		      <th>Cantidad</th><th>Descripcion</th><th>ValUnit</th><th>SubTotal</th><th>Acción</th>
		      </tr></thead><tbody>";
		foreach($array_productos as $key => $row) {

			$str.= "<form method='get' action='index.php'>";
			$str.="<input type='hidden' name='txt_factura_num' style='display:none' value='". $fact ."'></input>";
			$str.= "<tr><td>". $row['cantidad'] ."</td>";
			$str.="<input type='hidden' name='descripcion' style='display:none' value='". $row['descripcion'] ."'></input>";
			$str.= "<td>". $row['descripcion'] ."</td>";
			$str.= "<td>". $row['valUnit'] ."</td>";
			$str.= "<td>". $row['subTotal'] ."</td>";
			$str.= "<td>
		<button type='submit' name='eliminar' value='". $key ."'>Eliminar</button></td></tr></form>";
			$TotalSubTotal+=$row['subTotal'];
		}
		$str.="<tr><td><input type='text' name='txt_cant'></td>";
		$str.="<td><input style='width:8em;' type='text' name='txt_descrip'></td>";
		$str.="<td><input type='text' name='txt_valUnit'></td>";
		$str.="<td><input type='text' name='txt_subTotal'></td>";
		$str.="<td><button type='submit' name='agregar' value='1'>Agregar</button></td>";
		$str.="</tr>";
		$str.="</tbody></table>";
		$str.="TotalSubTotal<input disabled type='text' name='txt_totalSubTotal' value='".$TotalSubTotal."'></input>";
		$tax=$TotalSubTotal*0.10;
		$str.="<input type='hidden' name='txt_taxes' style='display:none' value='". $tax ."'></input>";
		$str.="Taxes<input disabled type='text' value='".$tax."'></input>";
		$total=$TotalSubTotal+$tax;
		$str.="<input type='hidden' name='txt_total' style='display:none' value='". $total ."'></input>";
		$str.="Total<input disabled style='width:8em;' type='text' value='".$total."'></input>";
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
	<title>Tarea5-AdministradorProductos-JSON</title>
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
	$str.= "<form method='get' action='index.php'><tr>";
	$str.= "<input type='hidden' name='factura_num' value='". $row['factura_num'] ."'></input>";
	$str.="<td>". $row['factura_num'] ."</td>";
	$str.= "<td>". $row['fecha'] ."</td>";
	$str.= "<input type='hidden' name='fecha' value='". $row['fecha'] ."'></input>";
	$str.= "<td>". $row['cliente'] ."</td>";
	$str.= "<input type='hidden' name='cliente' value='". $row['cliente'] ."'></input>";
	$str.= "<td>". $row['impuestos'] ."</td>";
	$str.= "<td>". $row['montoTotal'] ."</td>";
	$str.= "<td>
<button type='submit' name='buscar'>Buscar</button>";
	$str.="&nbsp<button type='submit' name='eliminarFactura' >Eliminar</button>";
	$str.="</td></tr></form>";
}
$str.="</tbody></table><br><form method='get' action='index.php'>";
$str.="<button style='padding:0.7em; padding-bottom: 1.5em;' type='submit' name='nuevo' value='1'>Nuevo</button>";
$str.="</form>";
echo $str;


echo "<br><h3>Facturación</h3>";
$array_productos= array();
session_start();

$_SESSION['prodEstado']='';

if (isset($_GET['buscar'])) {
	$fact=$_GET['factura_num'];
	$fecha=$_GET['fecha'];
	$cliente=$_GET['cliente'];

	$_SESSION['fact']=$fact;
	$_SESSION['fecha']=$fecha;
	$_SESSION['cliente']=$cliente;

	print"Buscar ";
	$_SESSION['prodEstado']='Buscado';

	$array_productos= array();

	$str=actualizarTabla($fact);
	
	echo $str;

	
}

if (isset($_GET['eliminar'])) { // Productos
	$fact=$_GET['txt_factura_num'];
	$descripcion=$_GET['descripcion'];
	print " Eliminar fact: ".$fact;
	print " Descripcion ".$descripcion;
	$subTotal=0;
	$data = file_get_contents($pathProductos);
	$result2 = json_decode($data, true);
	foreach ($result2['productos'] as $key => $row) {
	    if ($row['factura_num'] == $fact && $row['descripcion'] == $descripcion) {
	    	$subTotal=$row['subTotal'];
	    	unset($result2['productos'][$key]);
	    }
	}
	$data = json_encode($result2);
	file_put_contents($pathProductos, $data);
	///////////// facturas
	$data = file_get_contents($pathFacturas);
	$result = json_decode($data, true);
	foreach ($result['facturas'] as $key => $row) {
	    if ($row['factura_num'] == $fact) {
	    	$result['facturas'][$key]['impuestos'] = $row['impuestos']-($subTotal*0.10);
			$result['facturas'][$key]['montoTotal'] = $row['montoTotal']-$subTotal;
	    }
	}
	$data = json_encode($result);
	file_put_contents($pathFacturas, $data);

	
	echo actualizarTabla($fact);
}

if (isset($_GET['eliminarFactura'])) { // Factura y todos sus productos
	$fact=$_GET['factura_num'];
	print " Eliminar fact: ".$fact."<br>";
	///////////// facturas
	$data = file_get_contents($pathFacturas);
	$result = json_decode($data, true);
	foreach ($result['facturas'] as $key => $row) {
	    if ($row['factura_num'] == $fact) {
	    	unset($result['facturas'][$key]);
	    }
	}
	$data = json_encode($result);
	file_put_contents($pathFacturas, $data);
	/////////////////////// productos
	$data = file_get_contents($pathProductos);
	$result2 = json_decode($data, true);
	foreach ($result2['productos'] as $key => $row) {
	    if ($row['factura_num'] == $fact) {
	    	unset($result2['productos'][$key]);
	    }
	}
	$data = json_encode($result2);
	file_put_contents($pathProductos, $data);

	echo "<br>Se eliminó factura y productos<br><a href='index.php'>Recargar</a>";
	header('.\index.php');
}
if (isset($_GET['agregar'])) {


	$fact=$_GET['txt_factura_num'];
	$fecha=$_GET['txt_fecha'];
	$cliente=$_GET['txt_cliente'];

	$_SESSION['fact']=$fact;
	$_SESSION['fecha']=$fecha;
	$_SESSION['cliente']=$cliente;

	print " Agregar ".$fact;
	if ($fact!='') {
		$tot2=0;
		$imp2=0;

		$imp2=$_GET['txt_subTotal']*0.10+$_GET['txt_taxes']; // 50
		$tot2=$_GET['txt_total']+$_GET['txt_subTotal']+($_GET['txt_subTotal']*0.10); // 440 + 100 + 10= 540 

		//print $tot2."  : ".$imp2;
		// Crear una Factura_num en caso de que no exista, sino modificarle los impuestos y total
		$existe=false;
		$data = file_get_contents($pathFacturas);
		$result = json_decode($data, true);
		foreach ($result['facturas'] as $key => $row) {
		    if ($row['factura_num'] == $fact) {
				$result['facturas'][$key]['fecha'] = $fecha;
				$result['facturas'][$key]['cliente'] = $cliente;
				$result['facturas'][$key]['impuestos'] = $imp2;
				$result['facturas'][$key]['montoTotal'] = $tot2;
		    	$existe=true;
		    	continue;
		    }
		}
		if (!$existe) {
			$result['facturas'][]= array('factura_num'=>$fact, 'fecha'=>$fecha, 'cliente'=>$cliente, 'impuestos'=>$imp2, 'montoTotal'=>$tot2);
		}else{
		}
		$data = json_encode($result);
		file_put_contents($pathFacturas, $data);
		//////////////
		$data2 = file_get_contents($pathProductos);
		$result2 = json_decode($data2, true);

		$result2['productos'][]= array('factura_num'=>$fact, 'cantidad'=>$_GET['txt_cant'], 'descripcion'=>$_GET['txt_descrip'], 'valUnit'=>$_GET['txt_valUnit'], 'subTotal'=>$_GET['txt_subTotal']);

		$data2 = json_encode($result2);
		file_put_contents($pathProductos, $data2);
		echo actualizarTabla($fact);
	}

}

if (isset($_GET['nuevo'])) {
	$_SESSION['prodEstado']='Nuevo';
	
	$_SESSION['fact']="";
	$_SESSION['fecha']="";
	$_SESSION['cliente']="";

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

		$imp=$_GET['txt_taxes'];
		$tot=$_GET['txt_total'];

		// Crear una Factura_num en caso de que no exista, sino modificarla
		$existe=false;
		$data = file_get_contents($pathFacturas);
		$result = json_decode($data, true);
		foreach ($result['facturas'] as $key => $row) {
		    if ($row['factura_num'] == $fact) {
		    	$result['facturas'][$key]['fecha'] = $fecha;
				$result['facturas'][$key]['cliente'] = $cliente;
				$result['facturas'][$key]['impuestos'] = $imp;
				$result['facturas'][$key]['montoTotal'] = $tot;
		    	$existe=true;
		    	continue;
		    }
		}
		if (!$existe) {	
			$result['facturas'][]= array('factura_num'=>$fact, 'fecha'=>$fecha, 'cliente'=>$cliente, 'impuestos'=>$imp, 'montoTotal'=>$tot);		
		}else{		
		}

		$data = json_encode($result);
		file_put_contents($pathFacturas, $data);

		echo "<br><a href='index.php'>Recargar</a>";
		header('.\index.php');
	}

}

if (isset($_GET['cancelar'])) {
	print "Cancelar";

	//echo CrearTablaProductos($_SESSION['array_productos']);
	echo "<br><a href='index.php'>Recargar</a>";
	header('.\index.php');
}



?>
