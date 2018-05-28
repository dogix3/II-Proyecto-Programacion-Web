<?php
	require("Toro.php");
	class DBHandlerPrograma {
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
					$stmt = $dbh->prepare("SELECT * FROM tbl_Programas WHERE id = :id");
					$stmt->bindParam(':id', $id);
				} else {
					$stmt = $dbh->prepare("SELECT * FROM tbl_Programas");
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
				$num_version = $_PUT['num_version'];
				$fecha_publicacion = $_PUT['fecha_publicacion'];
				$lenguaje = $_PUT['lenguaje'];
				$descripcion = $_PUT['descripcion'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("INSERT INTO tbl_Programas (num_version,fecha_publicacion,lenguaje,descripcion) 
												VALUES (:num_version,:fecha_publicacion,:lenguaje,:descripcion)");
				$stmt->bindParam(':num_version', $num_version);
				$stmt->bindParam(':fecha_publicacion', $fecha_publicacion);
				$stmt->bindParam(':lenguaje', $lenguaje);
				$stmt->bindParam(':descripcion', $descripcion);
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
				$stmt = $dbh->prepare("DELETE FROM tbl_Programas WHERE id = :id");
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
				$num_version = $_PUT['num_version'];
				$fecha_publicacion = $_PUT['fecha_publicacion'];
				$lenguaje = $_PUT['lenguaje'];
				$descripcion = $_PUT['descripcion'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("UPDATE tbl_Programas SET num_version=:num_version,
										fecha_publicacion=:fecha_publicacion, lenguaje=:lenguaje,
										descripcion=:descripcion WHERE id = :id");
				$stmt->bindParam(':id', $id);
				$stmt->bindParam(':num_version', $num_version);
				$stmt->bindParam(':fecha_publicacion', $fecha_publicacion);
				$stmt->bindParam(':lenguaje', $lenguaje);
				$stmt->bindParam(':descripcion', $descripcion);
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
		"/programa" => "DBHandlerPrograma",
		"/programa/:alpha" => "DBHandlerPrograma",
	));
?>
