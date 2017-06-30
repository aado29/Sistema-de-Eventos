$(document).ready(function(){

	var met = 'post';
	var pet = 'back/master.php';

	/* ----------------------- FORMULARIO PARA INICIAR SESION     --------------*/

			$('#form-session').on('submit',function(e){

				e.preventDefault();
				console.log("Seccion prevented");

				$.ajax({
					url: pet,
					type: met,
					data: $('#form-session').serialize(),
					success:function( data ){
						if (data != 'error') {
							window.location.href = "eventos.php";
						}else{
							alert('Usuario y/o Contraseña incorrectos');
						}
					},
					error: function( jqXHR,estado,error ){
						alert('error');
					},
					timeout: 10000
				});
			});

	/* ----------------------- FORMULARIO PARA REGISTRAR GRUPO    --------------*/

			$('#form-grupo').on('submit',function(e){

				e.preventDefault();

				$.ajax({
					url: pet,
					type: met,
					data: $('#form-grupo').serialize(),
					success:function( data ){
						if (data != 'error') {
							console.log(data);
							alert('Grupo registrado');
						}else{
							console.log(data);
							alert('Grupo no registrado');
						}
					},
					error: function( jqXHR,estado,error ){
						console.log(error);
						alert('error');
					},
					timeout: 10000
				});
			});

	/* ----------------------- FORMULARIO PARA REGISTRAR EQUIPO   --------------*/

			$('#form-equipo').on('submit',function(e){

				e.preventDefault();

				$.ajax({
					url: pet,
					type: met,
					data: $('#form-equipo').serialize(),
					success:function( data ){
						if (data != 'error') {
							console.log(data);
							alert('Equipo registrado');
						}else{
							console.log(data);
							alert('Equipo no registrado');
						}
					},
					error: function( jqXHR,estado,error ){
						console.log(error);
						alert('error');
					},
					timeout: 10000
				});
			});

	/* ----------------------- FORMULARIO PARA REGISTRAR USUARIO  --------------*/

			$('#form-usuario').on('submit',function(e){

				e.preventDefault();

				$.ajax({
					url: pet,
					type: met,
					data: $('#form-usuario').serialize(),
					success:function( data ){
						if (data != 'error') {
							console.log(data);
							alert('Usuario registrado');
						}else{
							console.log(data);
							alert('Usuario no registrado');
						}
					},
					error: function( jqXHR,estado,error ){
						console.log(error);
						alert('error');
					},
					timeout: 10000
				});
			});

	/* ----------------------- FORMULARIO PARA REGISTRAR VEHICULO --------------*/

			$('#form-vehiculo').on('submit',function(e){

				e.preventDefault();

				$.ajax({
					url: pet,
					type: met,
					data: $('#form-vehiculo').serialize(),
					success:function( data ){
						if (data != 'error') {
							console.log(data);
							alert('Vehiculo registrado');
						}else{
							console.log(data);
							alert('Vehiculo no registrado');
						}
					},
					error: function( jqXHR,estado,error ){
						console.log(error);
						alert('error');
					},
					timeout: 10000
				});
			});

	/* ----------------------- FORMULARIO PARA REGISTRAR VOLUNTARIO ------------*/

			$('#form-voluntario').on('submit',function(e){

				e.preventDefault();

				$.ajax({
					url: pet,
					type: met,
					data: $('#form-voluntario').serialize(),
					success:function( data ){
						if (data != 'error') {
							console.log(data);
							alert('Voluntario registrado');
						}else{
							console.log(data);
							alert('Voluntario no registrado');
						}
					},
					error: function( jqXHR,estado,error ){
						console.log(error);
						alert('error');
					},
					timeout: 10000
				});
			});

	/* ----------------------- FORMULARIO PARA REGISTRAR EVENTO     ------------*/

			$('#form-evento').on('submit',function(e){

				e.preventDefault();

				$.ajax({
					url: pet,
					type: met,
					data: $('#form-evento').serialize(),
					success:function( data ){
						if (data != 'error') {
							console.log(data);
							alert('Evento registrado');
						}else{
							console.log(data);
							alert('Evento no registrado');
						}
					},
					error: function( jqXHR,estado,error ){
						console.log(error);
						alert('error');
					},
					timeout: 10000
				});
			});

});
