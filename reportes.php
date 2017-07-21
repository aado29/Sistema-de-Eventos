<?php
	require_once 'core/init.php';

	$user = new User();
	if(!$user->isLoggedIn()) {
		Redirect::to('login.php');
	}
	if(!$user->hasPermission('admin')) {
		Redirect::to('eventos.php');
	}
	if (Input::exists()) {
		if (Token::check(Input::get('token'))) {
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'from' => array(
					'date_limit' => Input::get('to'),
					'display' => 'Día de inicio'
				),
				'to' => array(
					'display' => 'Día de fin'
				)
			));
			if ($validation->passed()) {
				if (!empty(Input::get('events')))
					$data = getEventsReport(Input::get('from'), Input::get('to'), Input::get('type'));
				if (!empty(Input::get('groups')))
					$data = getGroupsReport(Input::get('speciality'), Input::get('state'));
				if (!empty(Input::get('volunteers')))
					$data = getVolunteersReport(Input::get('group'), Input::get('profession'), Input::get('speciality'),Input::get('state'));
				if (!empty(Input::get('vehicles')))
					$data = getVehiclesReport(Input::get('type'), Input::get('state'));
				if (!empty(Input::get('equipments')))
					$data = getEquipmentsReport(Input::get('type'), Input::get('state'));
			} else {
				$errors = $validation->errors();
			}
		}
	}
	gettemplate('header'); 
?>
<div class="container">
	<div class="row">
		<div class="jumbotron">
			<?php if (Input::exists('get') && Input::get('reportType')) : ?>
				<?php if (Input::get('reportType') == 'events') : ?>
					<div class="row">
						<div class="col-sm-offset-3 col-sm-6 noPrint">
							<?php if (!empty($errors)) {
								handlerMessage($errors, 'danger');
							} ?>
							<h2>Reportes de Eventos</h2>
							<form action="" method="post">
								<div class="form-group">
									<label for="inputFrom">Rango (De) </label>
									<input name="from" type="date" id="inputFrom" class="date-picker form-control" placeholder="Ej: <?php echo date('Y-m-d') ?>" <?php if(!empty(Input::get('from'))) echo 'value="'.Input::get('from').'"' ?>>
								</div>
								<div class="form-group">
									<label for="inputTo">Rango (Hasta) </label>
									<input name="to" type="date" id="inputTo" class="date-picker form-control" placeholder="Ej: <?php echo date('Y-m-d') ?>" <?php if(!empty(Input::get('to'))) echo 'value="'.Input::get('to').'"' ?>>
								</div>
								<?php getTreeType('Tipo', 'type'); ?>
								<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
								<input type="submit" name="events" class="btn btn-primary" value="Generar">
								<br />
								<br />
							</form>
						</div>
						<div class="col-sm-12">
							<?php if (Input::exists() && empty($errors)) { ?>
								<?php if (!empty($data)) { ?>
									<div class="table-responsive">
										<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Tipo</th>
													<th>Lugar</th>
													<th>Opciones</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data as $value) { ?>
												<tr>
													<td><?php echo getData($value->id_events_type, 'events_type', 'name'); ?></td>
													<td><?php echo $value->place;?></td>
													<td><a href="eventos.php?view=<?php echo $value->id; ?>">Ver</a></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
										<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
									</div>

							<?php } else {
									echo '<center><p>no se encontraron resultados</p></center>';
								} 
							} ?>
						</div>
					</div>
				<?php elseif (Input::get('reportType') == 'groups') : ?>
					<div class="row">
						<div class="col-sm-offset-3 col-sm-6 noPrint">
							<?php if (!empty($errors)) {
								handlerMessage($errors, 'danger');
							} ?>
							<h2>Reportes de Grupo</h2>
							<form action="" method="post">
								<?php Input::build('Especialidad', 'speciality'); ?>
								<?php Input::buildState(); ?>
								<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
								<input type="submit" name="groups" class="btn btn-primary" value="Generar">
								<br />
								<br />
							</form>
						</div>
						<div class="col-sm-12">
							<?php if (Input::exists() && empty($errors)) { ?>
								<?php if (!empty($data)) { ?>
									<div class="table-responsive">
										<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Especialidad</th>
													<th>Estado</th>
													<th>Opciones</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data as $value) { ?>
												<tr>
													<td><?php echo $value->speciality; ?></td>
													<td><?php echo ($value->state) ? 'Activo': 'Inactivo'; ?></td>
													<td><a href="grupos.php?view=<?php echo $value->id; ?>">Ver</a></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
										<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
									</div>

							<?php } else {
									echo '<center><p>no se encontraron resultados</p></center>';
								} 
							} ?>
						</div>
					</div>
				<?php elseif (Input::get('reportType') == 'volunteers') : ?>
					<div class="row">
						<div class="col-sm-offset-3 col-sm-6 noPrint">
							<?php if (!empty($errors)) {
								handlerMessage($errors, 'danger');
							} ?>
							<h2>Reportes de Voluntarios</h2>
							<form action="" method="post">
								<div class="form-group">
									<label for="group">Grupo:</label>
									<?php $sistem = new Sistem('groups_2'); ?>
									<select name="group" class="form-control" id="group">
										<option value="">Seleccione grupo</option>
										<?php if ($sistem->get(array('id', '>', 0))) : ?>
											<?php foreach ($sistem->data() as $group) { ?>
												<option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay grupos registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<?php Input::build('Profesión', 'profession'); ?>
								<?php Input::build('Especialidad', 'speciality'); ?>
								<?php Input::buildState(); ?>
								<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
								<input type="submit" name="volunteers" class="btn btn-primary" value="Generar">
								<br />
								<br />
							</form>
						</div>
						<div class="col-sm-12">
							<?php if (Input::exists() && empty($errors)) { ?>
								<?php if (!empty($data)) { ?>
									<div class="table-responsive">
										<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Cedula</th>
													<th>Nombres</th>
													<th>Apellidos</th>
													<th>Profesion</th>
													<th>Gupo</th>
													<th>Especialidad</th>
													<th>Estado</th>
													<th>Opciones</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data as $value) { ?>
												<tr>
													<td><?php echo $value->ci; ?></td>
													<td><?php echo $value->firstName; ?></td>
													<td><?php echo $value->lastName; ?></td>
													<td><?php echo $value->profession; ?></td>
													<td><?php echo $value->id_group; ?></td>
													<td><?php echo $value->speciality; ?></td>
													<td><?php echo ($value->state) ? 'Activo': 'Inactivo'; ?></td>
													<td><a href="voluntarios.php?view=<?php echo $value->id; ?>">Ver</a></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
										<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
									</div>

							<?php } else {
									echo '<center><p>no se encontraron resultados</p></center>';
								} 
							} ?>
						</div>
					</div>
				<?php elseif (Input::get('reportType') == 'vehicles') : ?>
					<div class="row">
						<div class="col-sm-offset-3 col-sm-6 noPrint">
							<?php if (!empty($errors)) {
								handlerMessage($errors, 'danger');
							} ?>
							<h2>Reportes de Vehiculos</h2>
							<form action="" method="post">
								<div class="form-group">
									<label for="type">Tipo:</label>
									<select name="type" class="form-control" id="type">
										<option value="">Seleccione tipo</option>
										<?php $pos = array('Coupe', 'Sedan', 'Deportivo', 'Camioneta', 'Camión', 'Bus', 'Moto','Cuatrimoto');
										foreach ($pos as $value) { 
											$selected = ($vehicles->type === $value) ? 'selected' : ''; ?>
											<option <?php echo $selected ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
										<?php } ?>
									</select>
								</div>
								<?php Input::buildState(); ?>
								<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
								<input type="submit" name="vehicles" class="btn btn-primary" value="Generar">
								<br />
								<br />
							</form>
						</div>
						<div class="col-sm-12">
							<?php if (Input::exists() && empty($errors)) { ?>
								<?php if (!empty($data)) { ?>
									<div class="table-responsive">
										<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Tipo</th>
													<th>Placa</th>
													<th>Marca</th>
													<th>Modelo</th>
													<th>Color</th>
													<th>Año</th>
													<th>Carroceria</th>
													<th>Motor</th>
													<th>Chasis</th>
													<th>Propietario</th>
													<th>Estado</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data as $value) { ?>
												<tr>
													<td><?php echo $value->type; ?></td>
													<td><?php echo $value->plate; ?></td>
													<td><?php echo $value->brand; ?></td>
													<td><?php echo $value->model; ?></td>
													<td><?php echo $value->color; ?></td>
													<td><?php echo $value->year; ?></td>
													<td><?php echo $value->bodywork; ?></td>
													<td><?php echo $value->motor; ?></td>
													<td><?php echo $value->chassis; ?></td>
													<td><?php echo getData($value->id_voluntary, 'volunteers', 'firstName').' '.getData($value->id_voluntary, 'volunteers', 'lastName'); ?></td>
													<td><?php echo ($value->state) ? 'Activo': 'Inactivo'; ?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
										<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
									</div>

							<?php } else {
									echo '<center><p>no se encontraron resultados</p></center>';
								} 
							} ?>
						</div>
					</div>
				<?php elseif (Input::get('reportType') == 'equipments') : ?>
					<div class="row">
						<div class="col-sm-offset-3 col-sm-6 noPrint">
							<?php if (!empty($errors)) {
								handlerMessage($errors, 'danger');
							} ?>
							<h2>Reportes de Equipamiento</h2>
							<form action="" method="post">
								<div class="form-group">
									<label for="type">Tipo:</label>
									<select name="type" class="form-control" id="type">
										<option value="">Seleccione tipo</option>
										<?php $pos = array('Alpinismo', 'Rescate en agua', 'Estricamiento', 'Vialidad', 'Primeros Auxilios');
										foreach ($pos as $value) { 
											$selected = ($equipments->type === $value) ? 'selected' : ''; ?>
											<option <?php echo $selected ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
										<?php } ?>
									</select>
								</div>
								<?php Input::buildState(); ?>
								<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
								<input type="submit" name="equipments" class="btn btn-primary" value="Generar">
								<br />
								<br />
							</form>
						</div>
						<div class="col-sm-12">
							<?php if (Input::exists() && empty($errors)) { ?>
								<?php if (!empty($data)) { ?>
									<div class="table-responsive">
										<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Nombre</th>
													<th>Tipo</th>
													<th>Descripción</th>
													<th>Estado</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data as $value) { ?>
												<tr>
													<td><?php echo $value->name; ?></td>
													<td><?php echo $value->type; ?></td>
													<td><?php echo $value->description; ?></td>
													<td><?php echo ($value->state) ? 'Activo': 'Inactivo'; ?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
										<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
									</div>

							<?php } else {
									echo '<center><p>no se encontraron resultados</p></center>';
								} 
							} ?>
						</div>
					</div>
				<?php else : ?>
					<p>nada.</p>
				<?php endif; ?>
			<?php else : ?>
				<div class="row">
					<div class="col-sm-12">
						<center><h1>Reportes</h1></center>
						<br />
						<div class="col-sm-4">
							<div class="row">
								<center><h2><a href="?reportType=events">Eventos</a></h2></center>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="row">
								<center><h2><a href="?reportType=groups">Grupos de Rescate</a></h2></center>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="row">
								<center><h2><a href="?reportType=volunteers">Valuntarios</a></h2></center>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<center><h2><a href="?reportType=vehicles">Vehiculos</a></h2></center>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<center><h2><a href="?reportType=equipments">Equipos</a></h2></center>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php gettemplate('footer');