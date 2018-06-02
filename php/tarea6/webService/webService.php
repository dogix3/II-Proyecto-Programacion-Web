<?php 
	require("Toro.php");

	class FacturasByNum {
		//Seleccionar factura por el ID
	    function get($factNum = 0) {
	        try {
	          $dbh = new PDO('sqlite:facturas.sqlite3');
	        } catch (Exception $e) {
	          die("Unable to connect: " . $e->getMessage());
	        }
	        try {
	            $stmt = $dbh->prepare('SELECT * FROM facturas where factura_num = '.$factNum);
	            $stmt->execute();

	            $data = Array();
	            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
	                $data[] = $result;
	            }
	            
	            echo json_encode($data);	            
	        } catch (Exception $e) {
	          echo "Failed: " . $e->getMessage();
	        }
	    }
	    //insertar facturas
	    function post() {
            try {
              	$dbh = new PDO('sqlite:facturas.sqlite3');
              	$factura_num = $_POST['numfact'];
              	$cantidad = $_POST['cantidad'];
              	$descripcion = $_POST['descripcion'];
              	$valor_unitario = $_POST['valor_unitario'];
              	$sub_total = $_POST['sub_total'];
              	$eliminado = $_POST['eliminado'];
              	
              	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              	#se eliminan todos los datos relacionados a la factura para insrtarlos nuevamente
              	if ($eliminado) {
              		$delete = "DELETE FROM facturas WHERE factura_num = ".$factura_num;
				    // Execute update
				    $dbh->exec($delete);
              	}

			    $insert = "INSERT INTO facturas (factura_num, cantidad, descripcion, valor_unitario, sub_total) VALUES (:factura_num, :cantidad, :descripcion, :valor_unitario, :sub_total)";
			    $stmt = $dbh->prepare($insert);
			 
			    // Bind parameters to statement variables
			    $stmt->bindParam(':factura_num', $factura_num);
			    $stmt->bindParam(':cantidad', $cantidad);
			    $stmt->bindParam(':descripcion', $descripcion);
			    $stmt->bindParam(':valor_unitario', $valor_unitario);
			    $stmt->bindParam(':sub_total', $sub_total);

			    /*$factura_num = $numFact;
				$cantidad = $value["cantidad"];
				$descripcion = $value["descripcion"];
				$valor_unitario = $value["precioUnit"];
				$sub_total = $value["precioUnit"] * $value["cantidad"];*/
			    $dbh->beginTransaction();
	            $stmt->execute();
	            $dbh->commit();
            } catch (Exception $e) {
              $dbh->rollBack();
              echo json_encode(array('fail' => "Failed: " . $e->getMessage()));
            }
        }
	}

	class ClientesByFact{
		function get() {
	        try {
	          $dbh = new PDO('sqlite:facturas.sqlite3');
	        } catch (Exception $e) {
	          die("Unable to connect: " . $e->getMessage());
	        }
	        try {
	            $stmt = $dbh->prepare('SELECT * FROM clientes');
	            $stmt->execute();

	            $data = Array();
	            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
	                $data[] = $result;
	            }
	            echo json_encode($data);
	        } catch (Exception $e) {
	          echo "Failed: " . $e->getMessage();
	        }
	    }
	    function post(){
	    	try {
              	$dbh = new PDO('sqlite:facturas.sqlite3');
              	$factura_num = $_POST['numfact'];
              	$fecha = $_POST['fechaFact'];
              	$cliente = $_POST['clienteFact'];
              	
              	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              	#se eliminan todos los datos relacionados a la factura para insrtarlos nuevamente
              	if ($eliminado) {
              		$delete = "DELETE FROM clientes WHERE factura_num = ".$factura_num;
				    // Execute update
				    $dbh->exec($delete);
              	}

			    $insert = "INSERT INTO clientes (factura_num, fecha, cliente) VALUES (:factura_num, :fecha, :cliente)";
			    $stmt = $dbh->prepare($insert);
			 
			    // Bind parameters to statement variables
			    $stmt->bindParam(':factura_num', $factura_num);
			    $stmt->bindParam(':fecha', $fecha);
			    $stmt->bindParam(':cliente', $cliente);
			    
			    $dbh->beginTransaction();
	            $stmt->execute();
	            $dbh->commit();
            } catch (Exception $e) {
              $dbh->rollBack();
              echo json_encode(array('fail' => "Failed: " . $e->getMessage()));
            }
	    }
	}

	Toro::serve(array(
	    "/facturasByID" => "FacturasByNum",
	    "/facturasByID/:alpha" => "FacturasByNum",
	    "/clientesByFact" => "ClientesByFact",
	));
?>