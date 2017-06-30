<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Vehículos</title>
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
						<li class="active"><a href="vehiculos.php">Vehiculos</a></li>
						<li><a href="equipos.php">Equipos</a></li>
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
				<h2>Vehículos</h2>
				<form id="form-vehiculo" name="vehiculo" method="post">
					<div class="form-group">
						<label for="plate">Placa:</label>
						<input type="text" class="form-control" name="plate">
					</div>
					<div class="form-group">
						<label for="brand">Marca:</label>
						<input type="text" class="form-control" name="brand">
					</div>
					<div class="form-group">
						<label for="model">Modelo:</label>
						<input type="text" class="form-control" name="model">
					</div>
					<div class="form-group">
						<label for="color">Color:</label>
						<input type="text" class="form-control" name="color">
					</div>
					<div class="form-group">
						<label for="year">Año:</label>
						<input type="number" class="form-control" name="year">
					</div>
					<div class="form-group">
						<label for="bodywork">Numero de carrocería:</label>
						<input type="number" class="form-control" name="bodywork">
					</div>
					<div class="form-group">
						<label for="motor">Numero de Motor:</label>
						<input type="number" class="form-control" name="motor">
					</div>
					<div class="form-group">
						<label for="chassis">Chasis:</label>
						<input type="number" class="form-control" name="chassis">
					</div>
					<div class="form-group">
						<label for="state">Estado:</label>
						<input type="text" class="form-control" name="state">
					</div>
					<input type="hidden" name="formName" value="reg-vehiculo">
					<button type="submit" class="btn btn-primary">Registrar</button>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="./back/master.js"></script>
</body>

</html>
