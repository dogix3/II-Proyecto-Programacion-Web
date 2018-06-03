<?php
	require("Toro.php");
	class DBHandler {
		function init() {
			try {
				$dbh = new PDO('sqlite:test.db');
				return $dbh;
			} catch (Exception $e) {
				die("Unable to connect: " . $e->getMessage());
			}            
		}
		function get($id=null) {
			$dbh = $this->init();
			try {
				if ($id!=null) {
					$stmt = $dbh->prepare("SELECT * FROM facturas WHERE id = :id");
					$stmt->bindParam(':id', $id);
				} else {
					$stmt = $dbh->prepare("SELECT * FROM facturas");
				}
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
		function put($id=null) {
			$dbh = $this->init();
			try {
				$_PUT=json_decode(file_get_contents('php://input'), True);
				$cliente = $_PUT['cliente'];
				$fecha = $_PUT['fecha'];
				$impuestos = $_PUT['impuestos'];
				$montoTotal = $_PUT['montoTotal'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("INSERT INTO facturas (cliente,fecha,impuestos,montoTotal) 
												VALUES (:cliente,:fecha,:impuestos,:montoTotal)");
				$stmt->bindParam(':cliente', $cliente);
				$stmt->bindParam(':fecha', $fecha);
				$stmt->bindParam(':impuestos', $impuestos);
				$stmt->bindParam(':montoTotal', $montoTotal);
				$dbh->beginTransaction();
				$stmt->execute();
				$dbh->commit();
				echo 'Successfull';
			} catch (Exception $e) {
				$dbh->rollBack();
				echo "Failed: " . $e->getMessage();
			}
		}
		function delete($id=null) {
			$dbh = $this->init();
			try {
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("DELETE FROM facturas WHERE id = :id");
				$stmt->bindParam(':id', $id);
				$dbh->beginTransaction();
				$stmt->execute();
				$dbh->commit();
				echo 'Successfull';
			} catch (Exception $e) {
				$dbh->rollBack();
				echo "Failed: " . $e->getMessage();
			}
		}
		function updateTotal($id=null) {
			$dbh = $this->init();
			try {
				$_POST=json_decode(file_get_contents('php://input'), True);
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("UPDATE facturas SET montoTotal=(select (impuestos *(select total(subTotal) from productos where id_factura=1)/100)+(select total(subTotal) from productos where id_factura=1)
from facturas where id=:id) WHERE id = :id");
				$stmt->bindParam(':id', $id);
				$dbh->beginTransaction();
				$stmt->execute();
				$dbh->commit();
				echo 'Successfull';
			} catch (Exception $e) {
				$dbh->rollBack();
				echo "Failed: " . $e->getMessage();
			}
		}
		function post($id=null) {
			$dbh = $this->init();
			try {
				$_POST=json_decode(file_get_contents('php://input'), True);
				if ($_POST['method']=='put')
					return $this->put($id);
				else if ($_POST['method']=='delete')
					return $this->delete($id);
				else if ($_POST['method']=='updateTotal')
					return $this->updateTotal($id);
				$cliente = $_POST['cliente'];
				$fecha = $_POST['fecha'];
				$impuestos = $_POST['impuestos'];
				$montoTotal = $_POST['montoTotal'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("UPDATE facturas SET cliente=:cliente,
										fecha=:fecha, impuestos=:impuestos,
										montoTotal=:montoTotal WHERE id = :id");
				$stmt->bindParam(':id', $id);
				$stmt->bindParam(':cliente', $cliente);
				$stmt->bindParam(':fecha', $fecha);
				$stmt->bindParam(':impuestos', $impuestos);
				$stmt->bindParam(':montoTotal', $montoTotal);
				$dbh->beginTransaction();
				$stmt->execute();
				$dbh->commit();
				echo 'Successfull';
			} catch (Exception $e) {
				$dbh->rollBack();
				echo "Failed: " . $e->getMessage();
			}
		}
	}
	class DBHandler2 {
		function init() {
			try {
				$dbh = new PDO('sqlite:test.db');
				return $dbh;
			} catch (Exception $e) {
				die("Unable to connect: " . $e->getMessage());
			}            
		}
		function get($id_factura=null) {
			$dbh = $this->init();
			try {
				if ($id_factura!=null) {
					$stmt = $dbh->prepare("SELECT * FROM productos WHERE id_factura = :id_factura");
					$stmt->bindParam(':id_factura', $id_factura);
				} else {
					$stmt = $dbh->prepare("SELECT * FROM productos");
				}
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
		function put($id=null) {
			$dbh = $this->init();
			try {
				$_PUT=json_decode(file_get_contents('php://input'), True);
				$id = $_PUT['id_factura'];
				$cantidad = $_PUT['cantidad'];
				$descripcion = $_PUT['descripcion'];
				$valUnit = $_PUT['valUnit'];
				$subTotal = $_PUT['subTotal'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("INSERT INTO productos (id_factura,cantidad,descripcion,valUnit,subTotal) 
												VALUES (:id_factura,:cantidad,:descripcion,:valUnit,:subTotal)");
				$stmt->bindParam(':id_factura', $id);
				$stmt->bindParam(':cantidad', $cantidad);
				$stmt->bindParam(':descripcion', $descripcion);
				$stmt->bindParam(':valUnit', $valUnit);
				$stmt->bindParam(':subTotal', $subTotal);
				$dbh->beginTransaction();
				$stmt->execute();
				$dbh->commit();
				echo 'Successfull';
			} catch (Exception $e) {
				$dbh->rollBack();
				echo "Failed: " . $e->getMessage();
			}
		}
		function delete($id=null) {
			$dbh = $this->init();
			try {
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("DELETE FROM productos WHERE id = :id");
				$stmt->bindParam(':id', $id);
				$dbh->beginTransaction();
				$stmt->execute();
				$dbh->commit();
				echo 'Successfull';
			} catch (Exception $e) {
				$dbh->rollBack();
				echo "Failed: " . $e->getMessage();
			}
		}
		function deleteAll($id=null) {
			$dbh = $this->init();
			try {
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("DELETE FROM productos WHERE id_factura = :id");
				$stmt->bindParam(':id', $id);
				$dbh->beginTransaction();
				$stmt->execute();
				$dbh->commit();
				echo 'Successfull';
			} catch (Exception $e) {
				$dbh->rollBack();
				echo "Failed: " . $e->getMessage();
			}
		}
		function post($id=null) {
			$dbh = $this->init();
			try {
				$_POST=json_decode(file_get_contents('php://input'), True);
				if ($_POST['method']=='put')
					return $this->put($id);
				else if ($_POST['method']=='delete')
					return $this->delete($id);
				else if ($_POST['method']=='deleteAll')
					return $this->deleteAll($id);
				$id_factura = $_POST['id_factura'];
				$cantidad = $_POST['cantidad'];
				$descripcion = $_POST['descripcion'];
				$valUnit = $_POST['valUnit'];
				$subTotal = $_POST['subTotal'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("UPDATE productos SET id_factura=:id_factura,cantidad=:cantidad,
					descripcion=:descripcion,valUnit=:valUnit,subTotal=:subTotal WHERE id = :id_producto");
				$stmt->bindParam(':id_producto', $id);
				$stmt->bindParam(':id_factura', $id_factura);
				$stmt->bindParam(':cantidad', $cantidad);
				$stmt->bindParam(':descripcion', $descripcion);
				$stmt->bindParam(':valUnit', $valUnit);
				$stmt->bindParam(':subTotal', $subTotal);
				$dbh->beginTransaction();
				$stmt->execute();
				$dbh->commit();
				echo 'Successfull';
			} catch (Exception $e) {
				$dbh->rollBack();
				echo "Failed: " . $e->getMessage();
			}
		}
	}
	Toro::serve(array(
		"/factura" => "DBHandler",
		"/factura/:alpha" => "DBHandler",
		"/producto" => "DBHandler2",
		"/producto/:alpha" => "DBHandler2",
	));
?>
