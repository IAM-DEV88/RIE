
$(".navbar-toggler").click(function(){
	$(".encabezado").slideToggle(400);
});

function cargarUI(modo, filtro, data){
	let modulo = "";
	let encabezado = "";
	let herramienta = "";
	let meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	let diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	switch (modo) {
		case "RIE":
		modulo="RIE";
		let f=new Date();
		encabezado = "Hoy, "+(diasSemana[f.getDay()] + " " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		herramienta="<i class='fas fa-check-square Todo'></i>"
		break;
		case "Archivo":
		encabezado = "Libro de contabilidad";
		modulo="archivo";
		herramienta="<i class='fas fa-download Download'></i>"
		switch (filtro) {
			case "mes":
			modulo="mes";
			encabezado = meses[data.slice(-2)-1]+" de "+data.substring(0, 4);
			herramienta+=goBack()+"<i class='fas fa-check-square Todo'></i>"
			break;
			case "dia":
			modulo="dia";
			encabezado = data.slice(-2)+" de "+meses[data.substring(5,7)-1]+" de "+data.substring(0, 4);
			herramienta+=goBack(data)+"<i class='fas fa-check-square Todo'></i>"
			break;
		}
		break;
		default:
		if(modo){notificacion("El modo "+modo+" aun no ha sido habilitado.");}
		cargarUI("RIE");
		return;
		break;
	}
	$(".navbar-brand").attr("data-modo", modo);
	$(".navbar-brand").html(modo);
	$(".encabezado>span:nth-child(1)").html(encabezado);
	$(".encabezado>span:nth-child(2)").html(herramienta);
	$(".Todo").click(function(){
		if($("main input:checked").length==$("main input").length){
			$("main input").prop("checked",false);
		}else {
			$("main input").prop("checked",true);
		}
	});
	if (filtro!=undefined) {
		$.ajax({
			type: "POST",
			url: "php/"+filtro+".php",
			data: {scope:data},
			success: function(data){$("main").html(data);},
			error: function(){mensaje("Error al cargar registros");
		}
	});
	}else{
		$.ajax({
			type: "GET",
			url: "php/"+modulo+".php",
			success: function(data){$("main").html(data);},
			error: function(){notificacion("Error al cargar registros");}
		});
	}
}



function goBack(scope){
	let goTo = ""
	if(!scope){
		goTo = "Archivo";		
	}else{
		goTo = scope.substring(0,7);		
	}
	return " <i class='fas fa-arrow-left Atras' data-history='"+goTo+"'></i>";		
}


function notificacion(txt){$("<div id='notificacion'>"+txt+"</div>").insertAfter('body').delay(3000).slideToggle(function() {$(this).remove();} );}

$("#Nuevo").click(function(){
	ventana("Nuevo");
});

function ventana(formato, data){
	$("#camposRegistro input").val("");
	switch (formato) {
		case "Nuevo":
		let now = new Date();
		let day = ("0" + now.getDate()).slice(-2);
		let month = ("0" + (now.getMonth() + 1)).slice(-2);
		let today = now.getFullYear()+"-"+(month)+"-"+(day) ;
		$(".titulo>span:nth-child(1)").html("NUEVO REGISTRO");
		$("#fecha").val(today);
		$("#Guardar").attr("regid",0);
		break;
		case "Examinar":
		let indice=0;
		let orden = ["fecha","monto","descripcion","referido"];
		$("#"+data["tipo"]).prop("checked",true);
		$("#camposRegistro input").each(function(){
			$(this).val(data[orden[indice]]);
			indice++;
		});
		$(".titulo>span:nth-child(1)").html("DETALLES DEL REGISTRO");
		$("#Guardar").attr("regid",data["id"]);
		break;
		default:
		break;
	}
	if($('#ventana[style*="display: none"]').length!=0){
		$("#ventana").slideToggle(400);
		$("main").css("paddingBottom","33rem");
	}
}

$("#Cerrar, #Cancelar").click(function(){
	$("#ventana").slideToggle(400);
	$("main").css("paddingBottom","8.7rem");
});




$("#Guardar").click(function(){
	let modo = $(".navbar-brand").data("modo");
	let filtro = $(".navbar-brand").data("filtro");
	let foco = $(".navbar-brand").data("foco");
	let update = $(this).attr("regid");
	let totalCampos = $("#formularioRegistro input").length;
	let llenos = 0;
	let vacios = "Debe llenar los campos:";
	$("#formularioRegistro input").each(function(){
		if (this.value!="") {llenos++;}
		else{
			let campo = $(this).attr("id");
			vacios += "<br> * "+campo.toUpperCase();
		}
	});
	if (llenos==totalCampos) {
		let form = $("#formularioRegistro").serialize();
		let accion = [];
		if (update!=0){
			if(confirm("¿Desea actualizar este resgistro?")) {
				form+="&id="+update;
				accion=["actualizar","actualizado"];
			}else{
				notificacion("Procedimiento cancelado");
				return;
			}
		}else{
			accion=["insertar","almacenado"];
		}
		$.ajax({
			type: "POST",
			url: "php/"+accion[0]+".php",
			data: form,
			success: function(data){
				$('#ventana').slideToggle(400);
				cargarUI(modo,filtro,foco);
				notificacion("Registro "+accion[1]+" correctamente");
			},
			error: function()
			{notificacion("Error al "+accion[0]+" registro");}

		});
	}else{notificacion(vacios);}
}); 

$("#Ocultar").click(function(){
	let badge = $(".Ocultos").html();
	if($("main input:checked").length>0){
		if(!badge){
			badge=0;
			$("main input:checked").each(function(){
				$(this).parent().parent().slideToggle(400);
				$(this).prop("checked",false);
				badge++;
			});
			$("footer").append("<div class='Mostrar'><i class='far fa-eye'></i> <span class='badge badge-dark Ocultos'>"+badge+"</span></div>");
			$(".Mostrar").click(function(){
				$('main > div[style*="display: none"]').slideToggle(400);
				$(this).remove();
			});
		}else{
			badge=0;
			$("main input:checked").each(function(){
				$(this).parent().parent().slideToggle(400);
				$(this).prop("checked",false);
				badge++;
			});
			$(".Ocultos").html(parseInt($(".Ocultos").text())+badge);
		}
	}else{
		notificacion("Ninguna seleccion para ocultar");
	}
});


$("#Duplicar").click(function(){
	let modo = $(".navbar-brand").data("modo");
	let filtro = $(".navbar-brand").data("filtro");
	let foco = $(".navbar-brand").data("foco");
	if($("main input:checked").length>0){
		if(confirm("¿Desea duplicar esta seleccion?")){
			$("main input:checked").each(function(){
				$.ajax({
					type: "POST",
					url: "php/copiar.php",
					data: {id:$(this).val()},
					success: function(data){
						cargarUI(modo,filtro,foco);
						notificacion("Seleccion duplicada correctamente");
					},
					error: function()
					{notificacion("Error al duplicar seleccion");}
				});
				$(this).prop("checked",false);
			});
		}else{notificacion("Procedimiento cancelado");}
	}else{
		notificacion("Ninguna seleccion para duplicar");
	}
});

$("#Eliminar").click(function(){
	let modo = $(".navbar-brand").data("modo");
	let filtro = $(".navbar-brand").data("filtro");
	let foco = $(".navbar-brand").data("foco");
	if($("main input:checked").length>0){
		if(confirm("¿Desea eliminar esta seleccion?")) {
			$("main input:checked").each(function(){
				$.ajax({
					type: "POST",
					url: "php/eliminar.php",
					data: {id:$(this).val()},
					success: function(data){
						notificacion("Seleccion elimianda exitosamente");
						cargarUI(modo,filtro,foco);
					},
					error: function()
					{notificacion("Error al eliminar seleccion");}

				});
				$(this).prop("checked",false);
			});
		}
		else{notificacion("Procedimiento cancelado");}
	}else{
		notificacion("Ninguna seleccion para eliminar");
	}
});
