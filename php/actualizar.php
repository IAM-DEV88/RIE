<?php
include('conn.php');
$pdo = connect();


$campo = "tipo='".$_POST["tipo"]."', descripcion='".$_POST["descripcion"]."', referido='".$_POST["referido"]."', fecha='".$_POST["fecha"]."', monto='".$_POST["monto"]."'";


$sql = "UPDATE libro SET ".$campo." WHERE id='".$_POST["id"]."'";

$query = $pdo->prepare($sql);
$query->execute();
echo $sql;
?>