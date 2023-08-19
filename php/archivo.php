<?php
include('conn.php');

$conteoSaldos = "SELECT COUNT(*) FROM libro WHERE tipo='saldo'";
$query = $pdo->prepare($conteoSaldos);
$query->execute();
$qtySaldos = $query->fetch();

$conteoIngresos = "SELECT COUNT(*) FROM libro WHERE tipo='ingreso'";
$query = $pdo->prepare($conteoIngresos);
$query->execute();
$qtyIngresos = $query->fetch();

$conteoEgresos = "SELECT COUNT(*) FROM libro WHERE tipo='egreso'";
$query = $pdo->prepare($conteoEgresos);
$query->execute();
$qtyEgresos = $query->fetch();

$meses = "SELECT date_format(fecha, '%Y-%m') FROM libro GROUP BY date_format(fecha, '%Y-%m') ORDER BY fecha DESC";
$query = $pdo->prepare($meses);
$query->execute();
$lista = $query->fetchAll();
$ingresoTotal=0;
$egresoTotal=0;
$saldoTotal=0;
$i=0;

$meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

?>
<?php
if (count($lista) < 1) {
	?>
	<div>
		<span>
			No hay registros en el archivo
		</span>
	</div>
	<?php
} else {
	foreach ($lista as $fecha) {
		$ingreso = "SELECT SUM(monto) AS 'ingreso' FROM libro WHERE tipo='ingreso' AND fecha LIKE '".$fecha[0]."%'";
		$query = $pdo->prepare($ingreso);
		$query->execute();
		$ingresos = $query->fetch();
		$ingresoTotal+=$ingresos[0];

		$egreso = "SELECT SUM(monto) AS 'egreso' FROM libro WHERE tipo='egreso' AND fecha LIKE '".$fecha[0]."%'";
		$query = $pdo->prepare($egreso);
		$query->execute();
		$egresos = $query->fetch();
		$egresoTotal+=$egresos[0];

		$saldo = "SELECT SUM(monto) AS 'saldo' FROM libro WHERE tipo='saldo' AND fecha LIKE '".$fecha[0]."%'";
		$query = $pdo->prepare($saldo);
		$query->execute();
		$saldos = $query->fetch();
		$saldoTotal+=$saldos[0];
		$i++;
		?>
		<div>
			<span class="numerador">
				<?php echo $i; ?>
			</span>
			<span class="monto ingreso">
				<?php echo "$ ".number_format($ingresos[0], 0, '.', '.'); ?>
			</span>
			<span class="monto egreso">
				<?php echo "$ ".number_format($egresos[0], 0, '.', '.'); ?>
			</span>
			<span class="monto saldo">
				<?php echo "$ ".number_format($saldos[0], 0, '.', '.'); ?>
			</span>
			<span class="Mes" data-scope="<?php echo $fecha[0]; ?>">
				<?php echo substr($fecha[0], 0, 4)." - ".substr($meses[substr($fecha[0], 5, 2)-1], 0, 3)."."; ?>
			</span>
		</div>
		<?php 
	}
}
?>
<div class="totales">
	<span class="numerador">
		#
	</span>
	<span class='monto'>
		$ <?php echo number_format(($ingresoTotal-$egresoTotal), 0, '.', '.'); ?>
	</span>
	<span class="resumen">
		<span>
			Saldos (<?php echo $qtySaldos[0]; ?>):
		</span>
		<span id='totalSaldos'>
			$ <?php echo number_format($saldoTotal, 0, '.', '.'); ?>
		</span>
		<span>
			Ingresos (<?php echo $qtyIngresos[0]; ?>):
		</span>
		<span id='totalIngresos'>
			$ <?php echo number_format($ingresoTotal, 0, '.', '.'); ?>
		</span>
		<span>
			Egresos (<?php echo $qtyEgresos[0]; ?>):
		</span>
		<span id='totalEgresos'>
			$ <?php echo number_format($egresoTotal, 0, '.', '.'); ?>
		</span>
		<span>
			Total (<?php echo ($qtySaldos[0]+$qtyIngresos[0]+$qtyEgresos[0]); ?>):
		</span>
		<span>
			$ <?php echo number_format(($ingresoTotal-$egresoTotal), 0, '.', '.'); ?>
		</span>
	</span>
</div>
<script src='js/herramienta.js'></script>