<?php
include 'back/base.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Voluntarios</title>
	<link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
	<div class="container center">
		<div class="row">
			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">Sistema</a>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="eventos.php">Gestión de Eventos</a></li>
						<li><a href="grupos.php">Grupos de Rescate</a></li>
						<li class="active"><a href="voluntarios.php">Voluntarios</a></li>
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
				<h2>Voluntarios</h2>
				<form id="form-voluntario" name="voluntario" method="post">
					<div class="form-group">
						<label for="ci">Cedula:</label>
						<input type="number" class="form-control" name="ci">
					</div>
					<div class="form-group">
						<label for="firstName">Nombre:</label>
						<input type="text" class="form-control" name="firstName">
					</div>
					<div class="form-group">
						<label for="lastName">Apellido:</label>
						<input type="text" class="form-control" name="lastName">
					</div>
					<div class="form-group">
						<label for="address">Dirección:</label>
						<input type="text" class="form-control" name="address">
					</div>
					<div class="form-group">
						<label for="phone">Telefono:</label>
						<input type="number" class="form-control" name="phone">
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" name="email">
					</div>
					<div class="form-group">
						<label for="sizeShirt">Talla de camisa:</label>
						<select class="form-control" name="sizeShirt">
							<option>SS</option>
							<option>S</option>
							<option>M</option>
							<option>L</option>
							<option>XL</option>
						</select>
					</div>
					<div class="form-group">
						<label for="sizePants">Talla de pantalon:</label>
						<select class="form-control" name="sizePants">
							<option>30</option>
							<option>32</option>
							<option>34</option>
							<option>36</option>
							<option>38</option>
							<option>40</option>
						</select>
					</div>
					<div class="form-group">
						<label for="sizeShoes">Talla de zapatos:</label>
						<select class="form-control" name="sizeShoes">
							<option>34</option>
							<option>35</option>
							<option>36</option>
							<option>37</option>
							<option>38</option>
							<option>39</option>
							<option>40</option>
							<option>41</option>
							<option>42</option>
							<option>43</option>
							<option>44</option>
						</select>
					</div>
					<div class="form-group">
						<label for="position">Cargo:</label>
						<input type="text" class="form-control" name="position">
					</div>
					<div class="form-group">
						<label for="profession">Profeción:</label>
						<input type="text" class="form-control" name="profession">
					</div>
					<div class="form-group">
						<label for="speciality">Especialidad:</label>
						<input type="text" class="form-control" name="speciality">
					</div>
					<div class="form-group">
						<label for="employment">Ocupación:</label>
						<input type="text" class="form-control" name="employment">
					</div>
					<div class="form-group">
						<label for="group">Equipo:</label>
						<select class="form-control" name="group">
							<option value="" disabled selected>Seleccione Equipo...</option>
				    			<?php $query=mysqli_query($conexion,"SELECT * FROM equipos");
				    					while ($reg=mysqli_fetch_array($query)) {
				    						echo'<option value="'.$reg["id_equipo"].'">'.$reg['nombre_e'].'</option>';
				    				 	}
				    			?>
						</select>
					</div>
					<div class="form-group">
						<label for="vehicle">Vehículo:</label>
						<select class="form-control" name="vehicle">
							<option value="" disabled selected>Seleccione Vehiculo...</option>
				    			<?php $query=mysqli_query($conexion,"SELECT * FROM vehiculos");
				    					while ($reg=mysqli_fetch_array($query)) {
				    						echo'<option value="'.$reg["id_vehiculo"].'">'.$reg['marca'].' - '.$reg['modelo'].'</option>';
				    				 	}
				    			?>
						</select>
					</div>
					<div class="form-group">
						<label for="type">Tipo:</label>
						<input type="text" class="form-control" name="type">
					</div>
					<div class="form-group">
						<label for="state">Estado:</label>
						<input type="text" class="form-control" name="state">
					</div>
					<input type="hidden" name="formName" value="reg-voluntario">
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
