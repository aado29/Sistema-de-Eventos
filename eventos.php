<?php
include 'back/base.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Gestión de Eventos</title>
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
						<li class="active"><a href="eventos.php">Gestión de Eventos</a></li>
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
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-offset-4 col-sm-4">
				<h2>Gestionar Eventos</h2>
				<form id="form-evento" name="evento" method="post">
					<div class="form-group">
						<label for="eventType">Tipo de Evento:</label>
						<input type="text" class="form-control" name="eventType">
					</div>
					<div class="form-group">
						<label for="startDate">Fecha de inicio:</label>
						<input type="date" class="form-control" name="startDate">
					</div>
					<div class="form-group">
						<label for="dueDate">Fecha de fin:</label>
						<input type="date" class="form-control" name="dueDate">
					</div>
					<div class="form-group">
						<label for="place">Lugar:</label>
						<input type="text" class="form-control" name="place">
					</div>
					<div class="form-group">
						<label for="group">Grupo:</label>
						<select class="form-control" name="group">
							<option value="" disabled selected>Seleccione Grupo...</option>
				    			<?php $query=mysqli_query($conexion,"SELECT * FROM grupos");
				    					while ($reg=mysqli_fetch_array($query)) {
				    						echo'<option value="'.$reg["id_grupo"].'">'.$reg['nombre_g'].'</option>';
				    				 	}
				    			?>
						</select>
					</div>
					<div class="form-group">
						<label for="voluntary">Voluntario:</label>
						<select class="form-control" name="voluntary">
							<option value="" disabled selected>Seleccione Voluntario...</option>
				    			<?php $query=mysqli_query($conexion,"SELECT * FROM voluntarios");
				    					while ($reg=mysqli_fetch_array($query)) {
				    						echo'<option value="'.$reg["id_voluntario"].'">'.$reg['nombre_v'].'</option>';
				    				 	}
				    			?>
						</select>
					</div>
					<div class="form-group">
						<label for="team">Equipo:</label>
						<select class="form-control" name="team">
							<option value="" disabled selected>Seleccione Equipo...</option>
				    			<?php $query=mysqli_query($conexion,"SELECT * FROM equipos");
				    					while ($reg=mysqli_fetch_array($query)) {
				    						echo'<option value="'.$reg["id_equipo"].'">'.$reg['nombre_e'].'</option>';
				    				 	}
				    			?>
						</select>
					</div>
					<input type="hidden" name="formName" value="reg-evento">
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
