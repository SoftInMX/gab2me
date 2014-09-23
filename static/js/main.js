$( document ).ready(function(){
	$("#registrar").click(function(){
		$("#registrar").attr('value', 'Iniciar sesión');
		$("#registrar").attr('id', 'acceder');
		$("#txt_note").text('Si ya tienes una cuenta');
		$("#login").addClass("oculto");
		$("#signup").removeClass("oculto");
	});
	$("#acceder").click(function(){
		$("#acceder").attr('value', 'Regístrate');
		$("#registrar").attr('id', 'registrar');
		$("#txt_note").text('¿Aún no tienes una cuenta?');
		$("#signup").addClass("oculto");
		$("#login").removeClass("oculto");
	});

	$("#sendChat").click(function(){
		$("#ask").removeClass("disableP");
		$("#ask").addClass("activeP");
		$("#pregunta").addClass("oculto");
		$("#sendChat").removeClass("activeP");
		$("#sendChat").addClass("disableP");
		$("#chateo").removeClass("oculto");
	});
	$("#ask").click(function(){
		$("#sendChat").removeClass("disableP");
		$("#sendChat").addClass("activeP");
		$("#chateo").addClass("oculto");
		$("#ask").removeClass("activeP");
		$("#ask").addClass("disableP");
		$("#pregunta").removeClass("oculto");
	});

	$("#icon-check").click(function(){
		$("#icon-check").removeClass("icon-checkbox-unchecked");
		$("#icon-check").addClass("icon-checkbox-checked");
		$("#anonimo").prop("checked", true);
	});

	$(".desactivado").click(function() {
		$('.desactivado').removeClass('activado')
		$(this).toggleClass("activado");
	});

	$("#formRegistrar").click(function(){
		$("#formRegistrar").addClass('disableP');
		var user = $("#rusername").val();
		var mail = $("#email").val();
		var pass = $("#rpassword").val();
		
		if(user != '' && mail != '' && pass != ''){
			$.ajax({
				type: 'POST',
				url:  '/user/registar_new',
				data: {user:user, mail:mail, pass:pass}
			})
		}else{
			alert("Todos los campos son requeridos");
		}

		setTimeout(function(){
			$("#formRegistrar").removeClass('disableP');
		}, 3000)
	})

});
