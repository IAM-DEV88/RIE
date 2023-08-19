<?php
include('conn.php');

$sql = "SELECT * FROM libro WHERE id= :id";
$query = $pdo->prepare($sql);
$query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
$query->execute();
$original = $query->fetch();

$copia = "INSERT INTO libro (id, tipo, descripcion, referido, fecha, monto) VALUES ('', :tipo, :descripcion, :referido, :fecha, :monto)";
$query = $pdo->prepare($copia);
$query->bindParam(':tipo', $original['tipo'], PDO::PARAM_STR);
$query->bindParam(':descripcion', $original['descripcion'], PDO::PARAM_STR);
$query->bindParam(':referido', $original['referido'], PDO::PARAM_INT);
$query->bindParam(':fecha', $original['fecha'], PDO::PARAM_STR);
$query->bindParam(':monto', $original['monto'], PDO::PARAM_INT);
$query->execute();

?>
