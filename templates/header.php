<?php $user = new User(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?php echo Config::get('template/name'); ?></title>
	<link rel="stylesheet" type="text/css" href="assets/lib/bootstrap/dist/css/bootstrap.min.css" media="all">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<style media="print">
		.noPrint { display: none; }
	</style>
</head>

<body>
	<div class="container">
		<div class="row navtop">
			<div class="col-xs-3"><img src="assets/images/logo_pc.png" class="img-responsive logo" alt=""></div>
			<div class="col-xs-6">
				<center class="title">
					<h4 class="capitalize">republica bolivariana de venezuela<br/>
					estado zulia municipio maracaibo<br/>
					direccion municipal de proteccion civil<br/>
					y administracion de desastres<br/>
					sistema de informacion web<br/>
					gestion de eventos</h4>
				</center>
			</div>
			<div class="col-xs-3"><img src="assets/images/logo_az.png" class="pull-right img-responsive logo" alt=""></div>
		</div>
		<div class="row">
			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<!-- <div class="navbar-header">
						<a class="navbar-brand" href="./index.php"><?php echo Config::get('template/name'); ?></a>
					</div> -->
					<ul class="nav navbar-nav">
						<li><a href="eventos.php">Eventos</a></li>
						<li><a href="grupos.php">Grupos Voluntarios</a></li>
						<li><a href="voluntarios.php">Voluntarios</a></li>
						<li><a href="vehiculos.php">Vehiculos</a></li>
						<li><a href="equipos.php">Equipamientos</a></li>
						<?php if ($user->isLoggedIn() && $user->hasPermission('admin')) { ?>
							<li><a href="reportes.php">Reportes</a></li>
							<li><a href="usuarios.php">Usuarios</a></li>
						<?php } ?>
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