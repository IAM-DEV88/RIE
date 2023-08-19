<?php
include('conn.php');

try {
	$sql = "INSERT INTO libro (id, tipo, descripcion, referido, fecha, monto) VALUES ('', :tipo, :descripcion, :referido, :fecha, :monto)";
	$query = $pdo->prepare($sql);
	$query->bindParam(':tipo', $_POST['tipo'], PDO::PARAM_STR);
	$query->bindParam(':descripcion', $_POST['descripcion'], PDO::PARAM_STR);
	$query->bindParam(':referido', $_POST['referido'], PDO::PARAM_STR);
	$query->bindParam(':fecha', $_POST['fecha'], PDO::PARAM_STR);
	$query->bindParam(':monto', $_POST['monto'], PDO::PARAM_STR);
	$query->execute();
} catch (PDOException $e) {
	echo 'PDOException : '.  $e->getMessage();
}
var_dump($_POST);
?>