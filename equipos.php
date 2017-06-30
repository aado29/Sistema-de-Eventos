<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
	<link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
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
						<li class="active"><a href="equipos.php">Equipos</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="inicio.php"><span class="glyphicon glyphicon-log-in"></span> Iniciar Sesión</a></li>
					</ul>
				</div>
			</nav>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-offset-4 col-sm-4">
				<h2>Equipos</h2>
				<form id="form-equipo" name="equipo" method="post">
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" class="form-control" name="name">
					</div>
					<div class="form-group">
						<label for="description">Description:</label>
						<input type="text" class="form-control" name="description">
					</div>
					<div class="form-group">
						<label for="state">Estado:</label>
						<input type="text" class="form-control" name="state">
					</div>
					<input type="hidden" name="formName" value="reg-equipo">
					<button type="submit" class="btn btn-primary">Iniciar</button>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="./back/master.js"></script>
</body>

</html>
