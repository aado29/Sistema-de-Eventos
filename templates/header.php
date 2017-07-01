<?php $user = new User(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?php echo Config::get('template/name'); ?></title>
	<link rel="stylesheet" type="text/css" href="assets/lib/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>

<body>
	<div class="container">
		<div class="row">
			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="./index.php"><?php echo Config::get('template/name'); ?></a>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="eventos.php">Gestión de Eventos</a></li>
						<li><a href="grupos.php">Grupos de Rescate</a></li>
						<li><a href="voluntarios.php">Voluntarios</a></li>
						<li><a href="vehiculos.php">Vehiculos</a></li>
						<li><a href="equipos.php">Equipos</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php if (!$user->isLoggedIn()) { ?>
							<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Iniciar Sesión</a></li>
						<?php } else { ?>
							<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión</a></li>
						<?php } ?>
					</ul>
				</div>
			</nav>
		</div>
	</div>