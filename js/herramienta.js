$(".Examinar").click(function(){
	var elemento = $(this).data("regid");
	$.ajax({
		type: "POST",
		url: "php/examinar.php",
		dataType: 'json',
		data: {id:elemento},
		success: function(data){
			ventana("Examinar", data);
			notificacion("Carga exitosa");
		},
		error: function()
		{notificacion("Error al cargar registro");}

	});
});

$(".Mes").click(function(){
	var data = $(this).attr("data-scope");
	$(".navbar-brand").attr("data-filtro", "mes").attr("data-foco", data);
	cargarUI("Archivo","mes",data);
});

$(".Dia").click(function(){
	var data = $(this).data("scope");
	$(".navbar-brand").attr("data-filtro", "dia").attr("data-foco", data);
	cargarUI("Archivo","dia",data);
});
$(".Atras").click(function(){
		var data = $(this).data("history");
		if (data !=="Archivo"){
			cargarUI("Archivo","mes",data);
			$(".navbar-brand").attr("data-filtro", "mes").attr("data-foco", data);
		}else{
		location.reload();
			
		}
	});

$(".Download").click(function(){
	var modo = $(".navbar-brand").data("modo");
	var filtro = $(".navbar-brand").data("filtro");
	var foco = $(".navbar-brand").data("foco");
	if(confirm("¿Desea descargar una copia del libro?")) {
		window.open('php/backup.php', '_blank');
	}else{notificacion("Procedimiento cancelado");}
});