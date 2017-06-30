<?php
	session_start();
	session_destroy();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
	<link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="back/master.css">
</head>

<body>
	<!-- <div class="container">
		<div class="row">
			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">Sistema</a>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="eventos.php">Gestión de Eventos</a></li>
						<li><a href="grupos.php">Grupos de Rescate</a></li>
						<li><a href="voluntarios.php">Voluntarios</a></li>
						<li><a href="vehiculos.php">Vehiculos</a></li>
						<li><a href="equipos.php">Equipos</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="inicio.php"><span class="glyphicon glyphicon-log-in"></span> Iniciar Sesión</a></li>
					</ul>
				</div>
			</nav>
		</div>
	</div> -->
	<div class="container center">
		<div class="jumbotron">
		  <div class="row">
			<div class="col-sm-offset-4 col-sm-4">
				<h2>Iniciar Sesión</h2>
				<form id="form-session" name="session" method="post">
					<div class="form-group">
						<label for="user">Usuario:</label>
						<input type="text" class="form-control" name="user">
					</div>
					<div class="form-group">
						<label for="password">Contraseña:</label>
						<input type="password" class="form-control" name="pass">
					</div>
					<input type="hidden" name="formName" value="session">
					<button type="submit" class="btn btn-primary">Iniciar</button>
				</form>
			</div>
		    </div>
		</div>
	</div>

	<script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="back/master.js">

	</script>
</body>

</html>
