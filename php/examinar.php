<?php
include('conn.php');

$sql = "SELECT * FROM libro WHERE id=:id";
$query = $pdo->prepare($sql);
$query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
$query->execute();
$element = $query->fetch();

$response = json_encode($element);
echo $response;
?>
