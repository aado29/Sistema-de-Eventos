<?php
require_once 'core/init.php';

$user = new User();
if(!$user->isLoggedIn()) {
	Redirect::to('login.php');
}
gettemplate('header');
if (Session::exists('home')) {
	handlerMessage(Session::flash('home'), 'success');
}?>

<div class="container">
	<div class="row">
		<div class="jumbotron">
			<div class="row">
				<div class="col-sm-12">
					<center><h2>Bienvenido, <?php echo $user->data()->firstName.' '.$user->data()->lastName; ?></h2></center>
					<br />
					<div class="col-sm-4">
						<div class="row">
							<center><h2><a href="eventos.php">Eventos</a></h2></center>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="row">
							<center><h2><a href="grupos.php">Grupos Voluntarios</a></h2></center>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="row">
							<center><h2><a href="voluntarios.php">Voluntarios</a></h2></center>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<center><h2><a href="vehiculos.php">Vehículos</a></h2></center>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<center><h2><a href="equipos.php">Equipamientos</a></h2></center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<? gettemplate('footer');