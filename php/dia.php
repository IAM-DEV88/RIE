<?php
include('conn.php');
date_default_timezone_set("America/Bogota");

$sql = "SELECT * FROM libro WHERE fecha LIKE '".$_POST['scope']."%' ORDER BY fecha ASC";
$query = $pdo->prepare($sql);
$query->execute();
$list = $query->fetchAll();
$ingresos=0;
$egresos=0;
$saldos=0;
$conteoIngresos=0;
$conteoEgresos=0;
$conteoSaldos=0;
$i=0;

?>
<?php
if (count($list) < 1) {
	?>
	<div>
		<span>
			No hay registros este dia
		</span>
	</div>
	<?php
} else {
	foreach ($list as $registro) {
		$i++;
		?>

		<div>
			<span class="numerador">
				<?php echo $i; ?>
			</span>
			<span class="monto <?php echo $registro['tipo']; ?>">
				<?php echo "$ ".number_format($registro['monto'], 0, '.', '.'); ?>
			</span>
			<span class="descripcion Examinar" data-regid="<?php echo $registro['id']; ?>">
				<?php echo $registro['descripcion']; ?>
			</span>
			<span class="herramienta">
				<input type="checkbox" class="item" name="item<?php echo $registro['id']; ?>" value="<?php echo $registro['id']; ?>">
			</span>
		</div>
		<?php
		if($registro['tipo']=="saldo"){
			$saldos+=$registro['monto'];
			$conteoSaldos++;
		}
		if($registro['tipo']=="ingreso"){
			$ingresos+=$registro['monto'];
			$conteoIngresos++;
		}
		if($registro['tipo']=="egreso"){
			$egresos+=$registro['monto'];
			$conteoEgresos++;
		}
	}
}
?>
<div class="totales">
	<span class="numerador">
		#
	</span>
	<span class='monto'>
		$ <?php echo number_format(($ingresos-$egresos), 0, '.', '.'); ?>
	</span>
	<span class="resumen">
		<span>
			Saldos (<?php echo $conteoSaldos; ?>):
		</span>
		<span id='totalSaldos'>
			$ <?php echo number_format($saldos, 0, '.', '.'); ?>
		</span>
		<span>
			Ingresos (<?php echo $conteoIngresos; ?>):
		</span>
		<span id='totalIngresos'>
			$ <?php echo number_format($ingresos, 0, '.', '.'); ?>
		</span>
		<span>
			Egresos (<?php echo $conteoEgresos; ?>):
		</span>
		<span id='totalEgresos'>
			$ <?php echo number_format($egresos, 0, '.', '.'); ?>
		</span>
		<span>
			Total (<?php echo ($conteoSaldos+$conteoIngresos+$conteoEgresos); ?>):
		</span>
		<span>
			$ <?php echo number_format(($ingresos-$egresos), 0, '.', '.'); ?>
		</span>
	</span>
</div>
<script src='js/herramienta.js'></script>