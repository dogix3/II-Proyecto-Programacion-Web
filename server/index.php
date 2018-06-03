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
					$stmt = $dbh->prepare("SELECT * FROM programas WHERE id = :id");
					$stmt->bindParam(':id', $id);
				} else {
					$stmt = $dbh->prepare("SELECT * FROM programas");
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
				$nombre_compuesto = $_PUT['nombre_compuesto'];
				$num_version = $_PUT['num_version'];
				$fecha_publicacion = $_PUT['fecha_publicacion'];
				$lenguaje = $_PUT['lenguaje'];
				$descripcion = $_PUT['descripcion'];
				$id_usuario = $_PUT['id_usuario'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("INSERT INTO programas (nombre_compuesto,num_version,
							fecha_publicacion,lenguaje,descripcion,id_usuario) 
									VALUES (:nombre_compuesto,:num_version,:fecha_publicacion,
							:lenguaje,:descripcion,:id_usuario)");
				$stmt->bindParam(':nombre_compuesto', $nombre_compuesto);
				$stmt->bindParam(':num_version', $num_version);
				$stmt->bindParam(':fecha_publicacion', $fecha_publicacion);
				$stmt->bindParam(':lenguaje', $lenguaje);
				$stmt->bindParam(':descripcion', $descripcion);
				$stmt->bindParam(':id_usuario', $id_usuario);
				$dbh->beginTransaction();
				$stmt->execute();
				$dbh->commit();
				echo 'Successfull put';
			} catch (Exception $e) {
				$dbh->rollBack();
				echo "Failed: " . $e->getMessage();
			}
		}
		function delete($id=null) {
			$dbh = $this->init();
			try {
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("DELETE FROM programas WHERE id = :id");
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
				$nombre_compuesto = $_POST['nombre_compuesto'];
				$num_version = $_POST['num_version'];
				$fecha_publicacion = $_POST['fecha_publicacion'];
				$lenguaje = $_POST['lenguaje'];
				$descripcion = $_POST['descripcion'];
				$id_usuario = $_POST['id_usuario'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("UPDATE programas SET nombre_compuesto=:nombre_compuesto,
										num_version=:num_version, fecha_publicacion=:fecha_publicacion,
										lenguaje=:lenguaje,descripcion=:descripcion WHERE id = :id");
				$stmt->bindParam(':id', $id);
				$stmt->bindParam(':nombre_compuesto', $nombre_compuesto);
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
	class DBHandler2 {
		function init() {
			try {
				$dbh = new PDO('sqlite:test.db');
				return $dbh;
			} catch (Exception $e) {
				die("Unable to connect: " . $e->getMessage());
			}            
		}
		function get($id_revision=null) {
			$dbh = $this->init();
			try {
				if ($id_revision!=null) {
					$stmt = $dbh->prepare("SELECT * FROM revisiones WHERE id_revision = :id_revision");
					$stmt->bindParam(':id_revision', $id_revision);
				} else {
					$stmt = $dbh->prepare("SELECT * FROM revisiones");
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
				$id = $_PUT['id_programa'];
				$descripcion = $_PUT['descripcion'];
				$fecha = $_PUT['fecha'];
				$id_usuario = $_PUT['id_usuario'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("INSERT INTO revisiones (id_programa,descripcion,fecha,id_usuario) 
												VALUES (:id_programa,:descripcion,:fecha,:id_usuario)");
				$stmt->bindParam(':id_programa', $id);
				$stmt->bindParam(':descripcion', $descripcion);
				$stmt->bindParam(':fecha', $fecha);
				$stmt->bindParam(':id_usuario', $id_usuario);
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
				$stmt = $dbh->prepare("DELETE FROM revisiones WHERE id = :id");
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
				$stmt = $dbh->prepare("DELETE FROM revisiones WHERE id_programa = :id");
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
				$id_programa = $_POST['id_programa'];
				$descripcion = $_POST['descripcion'];
				$fecha = $_POST['fecha'];
				$id_usuario = $_POST['id_usuario'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("UPDATE revisiones SET id_programa=:id_programa,descripcion=:descripcion,
					fecha=:fecha,id_usuario=:id_usuario WHERE id = :id_revision");
				$stmt->bindParam(':id_revision', $id);
				$stmt->bindParam(':id_programa', $id_programa);
				$stmt->bindParam(':descripcion', $descripcion);
				$stmt->bindParam(':fecha', $fecha);
				$stmt->bindParam(':id_usuario', $id_usuario);
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
	class DBHandler3 {
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
					$stmt = $dbh->prepare("SELECT * FROM usuarios WHERE id = :id");
					$stmt->bindParam(':id', $id);
				} else {
					$stmt = $dbh->prepare("SELECT * FROM usuarios");
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
		function confirmUser($id=null) {
			$dbh = $this->init();
			try {
				$_PUT=json_decode(file_get_contents('php://input'), True);
				$usuario = $_PUT['usuario'];
				$password = $_PUT['password'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("SELECT * FROM usuarios WHERE id = :usuario OR usuario = :usuario 
											AND password = :password");
				$stmt->bindParam(':usuario', $usuario);
				$stmt->bindParam(':password', $password);
				$stmt->execute();
				$data = Array();
				while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$data[] = $result;
				}
				echo json_encode($data);
				//$dbh->beginTransaction();
				//$dbh->commit();
				//echo 'Successfull';
			} catch (Exception $e) {
				$dbh->rollBack();
				echo "Failed: " . $e->getMessage();
			}
		}
		function put($id=null) {
			$dbh = $this->init();
			try {
				$_PUT=json_decode(file_get_contents('php://input'), True);
				$usuario = $_PUT['usuario'];
				$password = $_PUT['password'];
				$nombre = $_PUT['nombre'];
				$tipo_usuario = $_PUT['tipo_usuario'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("INSERT INTO usuarios (usuario,password,nombre,tipo_usuario) 
												VALUES (:usuario,:password,:nombre,:tipo_usuario)");
				$stmt->bindParam(':usuario', $usuario);
				$stmt->bindParam(':password', $password);
				$stmt->bindParam(':nombre', $nombre);
				$stmt->bindParam(':tipo_usuario', $tipo_usuario);
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
				$stmt = $dbh->prepare("DELETE FROM usuarios WHERE id = :id");
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
				else if ($_POST['method']=='confirmUser')
					return $this->confirmPassword($id);
				$usuario = $_POST['usuario'];
				$password = $_POST['password'];
				$nombre = $_POST['nombre'];
				$tipo_usuario = $_POST['tipo_usuario'];
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $dbh->prepare("UPDATE usuarios SET usuario=:usuario,
										password=:password, nombre=:nombre,
										tipo_usuario=:tipo_usuario WHERE id = :id");
				$stmt->bindParam(':id', $id);
				$stmt->bindParam(':usuario', $usuario);
				$stmt->bindParam(':password', $password);
				$stmt->bindParam(':nombre', $nombre);
				$stmt->bindParam(':tipo_usuario', $tipo_usuario);
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
		"/programa" => "DBHandler",
		"/programa/:alpha" => "DBHandler",
		"/revision" => "DBHandler2",
		"/revision/:alpha" => "DBHandler2",
		"/usuario" => "DBHandler3",
		"/usuario/:alpha" => "DBHandler3",
	));
?>
