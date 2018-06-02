<?php 
	session_start();
	
    if (isset($_POST['btnAgregarProducto'])) {
    	if (empty($_POST['txtCantidad']) || empty($_POST['txtDescipcion']) || empty($_POST['txtPrecioUnitario'])) {
    		echo "Datos de factura obligatorios";
    	}else{
    		agregarProductoTabla($_POST['txtCantidad'], $_POST['txtDescipcion'], $_POST['txtPrecioUnitario']);
    	}
    }
    if (isset($_POST['btnGuardarFactura'])) {
    	if (empty($_POST['txtNumeroFactura']) || empty($_POST['txtFechaFactura']) || empty($_POST['txtNombreClientes'])) {
    		echo "Datos de factura obligatorios";
    	}else{
    		insertarFactura($_POST['txtNumeroFactura'], $_SESSION['productosArray']);
    		insertarCliente($_POST['txtNumeroFactura'], $_POST['txtFechaFactura'], $_POST['txtNombreClientes']);
    		unset($_SESSION['productosArray']);
    		unset($_SESSION['total']);
    	}
    	
    }
    if (isset($_POST['btnDelete'])) {
    	$newArray = array();
    	foreach ($_SESSION['productosArray'] as $value) {
    		if (!in_array($_POST['btnDelete'], $value)) {
    			$newArray[] = $value;
    		}
    	}
    	$_SESSION['productosArray'] = $newArray;
    }
    if (isset($_POST['btnEditFact'])) {
    	getFactData($_POST['btnEditFact']);
    }
    function agregarProductoTabla($cantidad, $descripcion, $precioUnitario){
    	if (isset($_SESSION['productosArray'])) {
			$productosArray = $_SESSION['productosArray'];
		}else{
			$productosArray = array();
		}
    	$productosArray[] = array("cantidad" => $cantidad, "descripcion" => $descripcion, "precioUnit" => $precioUnitario);
    	$_SESSION['productosArray'] = $productosArray;
    }

    function mostrarTablaProductos(){
    	$tabla = "";
    	$total = 0;
    	if (isset($_SESSION['productosArray'])) {
    		$array = $_SESSION['productosArray'];
	    	foreach ($array as $val) {
	    		$tabla .= '<tr>
								<td>'.$val["cantidad"].'</td>
								<td>'.$val["descripcion"].'</td>
								<td>₡ '.$val["precioUnit"].'</td>
								<td>₡ '.$val["cantidad"] * $val["precioUnit"].'</td>
								<td><button name="btnDelete" value='.$val["descripcion"].'>Eliminar</button></td>
							</tr>';
				$total += $val["cantidad"] * $val["precioUnit"];
	    	}
	    	$_SESSION['total'] = $total;
    	}else{
    	}
    	return $tabla;
    }

    function insertarFactura($numFact, $datosFac){
    	sendFactToWS('facturasByID', $datosFac, '/'.$numFact, $numFact);
    }

    function insertarCliente($numFact, $fechaFact, $clienteFact){
    	sendClientToWS($numFact, $fechaFact, $clienteFact);
    }

    function mostrarClientes(){
    	$result = getDataFromWS('clientesByFact');
    	$table = "";
	    foreach($result as $row) {
	      $table .= "<tr>
						<td>".$row['factura_num']."</td>
						<td>".$row['cliente']."</td>
						<td><button name='btnEditFact' value=".$row['factura_num'].">Editar</button></td>
					</tr>";
	    }
	    return $table;
    }

    function getFactData($factNum){
    	$result = getDataFromWS('facturasByID','/'.$factNum);
 		$table = "";
	    foreach($result as $row) {
			$productosArray[] = array("cantidad" => $row['cantidad'], "descripcion" => $row['descripcion'], "precioUnit" => $row['valor_unitario']);
	    }

    	$_SESSION['productosArray'] = $productosArray;
    }

    function getDataFromWS($accion, $parametro = ""){
    	$path = "http://localhost:8080/Programacion_web/webService/webService.php/".$accion.$parametro;
	    $data = file_get_contents($path);
	    $dataArray = json_decode($data, true);
	    return $dataArray;
    }

    function sendFactToWS($accion, $dataArray, $parametro, $numeroFact){
    	$path = "http://localhost:8080/Programacion_web/webService/webService.php/".$accion;
    	$eliminado = true;
    	foreach ($dataArray as $value) {
			$factura_num = $numeroFact;
			$cantidad = $value["cantidad"];
			$descripcion = $value["descripcion"];
			$valor_unitario = $value["precioUnit"];
			$sub_total = $value["precioUnit"] * $value["cantidad"];

			$data = array('numfact'=>$factura_num, 'cantidad'=>$cantidad, 'descripcion'=>$descripcion, 'valor_unitario'=>$valor_unitario, 'sub_total'=>$sub_total, 'eliminado' => $eliminado);

			$options = array(
			        'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => http_build_query($data),
			    )
			);

			$context  = stream_context_create($options);
			$result = file_get_contents($path, false, $context);

			if ($eliminado) {
				$eliminado = false;
			}
		}
    }
    function sendClientToWS($numFact, $fechaFact, $clienteFact){
    	$path = "http://localhost:8080/Programacion_web/webService/webService.php/clientesByFact";
    	$eliminado = true;
    	
    	$data = array('numfact'=>$numFact, 'fechaFact'=>$fechaFact, 'clienteFact'=>$clienteFact);
    	$options = array(
		    'http' => array(
			    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			    'method'  => 'POST',
			    'content' => http_build_query($data),
		    )
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($path, false, $context);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Facturas</title>
	<style>
		#facturas{
			width: 60%;
		    /* display: inline-block; */
		    margin-left: 30%;
		    padding: 5px;
		}
		#clientes{
			width: 30%;
		    display: inline-block;
		    position: absolute;
		}
		table {
		    border-collapse: collapse;
		}

		#clientes table, #clientes th, #clientes td {
		    border: 1px solid black;
		}
	</style>
</head>
<body>
	<main>
		<div id="clientes">
			<form action="" method="post">
				<table>
					<thead>
						<th>N° Fact</th>
						<th>Cliente</th>
						<th>Acción</th>
					</thead>
					<tbody>
						<?php echo mostrarClientes(); ?>
					</tbody>
				</table>
			</form>
			
		</div>
		<div id="facturas">
			<form action="" method="post">
				<div>
					<span>N° Factura</span><input type="text" name="txtNumeroFactura">
				</div>
				<br>
				<div>
					<span>Fecha</span><input type="date" name="txtFechaFactura">
				</div>
				<br>
				<div>
					<span>Cliente</span><input type="text" name="txtNombreClientes">
				</div>
				<table>
					<thead>
						<tr>
							<th>Cantidad</th>
							<th>Descripcón</th>
							<th>Valor unitario</th>
							<th>Sub total</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php echo mostrarTablaProductos(); ?>
						<tr>
							<td><input type="text" name="txtCantidad"></td>
							<td><input type="text" name="txtDescipcion"></td>
							<td><input type="text" name="txtPrecioUnitario"></td>
							<td></td>
							<td><input type="submit" name="btnAgregarProducto" value="Agregar"></td>
						</tr>
						<tr>
							<td></td>
							<td>Impuestos: <?php ?></td>
							<td>Total:</td>
							<td><?php if (isset($_SESSION['total'])) {
									echo "₡ ".$_SESSION['total'];
								}else{
									echo "₡ 0";
								} ?></td>
							<td><input type="submit" name="btnGuardarFactura" value="Guardar"></td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</main>
</body>
</html>