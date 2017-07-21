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
			<div class="col-xs-3"><img src="assets/images/logo_pc.jpeg" class="img-responsive logo" alt=""></div>
			<div class="col-xs-6">
				<center class="title">
					<h4>REPUBLICA BOLIVARIANA DE VENEZUELA<br />
					ESTADO ZULIA MUNICIPIO MARACAIBO<br />
					DIRECCION MUNICIPAL DE PROTECCION CIVIL <br />
					Y ADMINISTRACION DE DESASTRES<br />
					SISTEMA DE IFMORMACION WEB<br />
					GESTION DE EVENTOS</h4>
				</center>
			</div>
			<div class="col-xs-3"><img src="assets/images/logo_az.jpeg" class="pull-right img-responsive logo" alt=""></div>
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
						<?php if($user->hasPermission('admin')) { ?>
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