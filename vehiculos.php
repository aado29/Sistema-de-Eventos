<?php
	require_once 'core/init.php';
	$user = new User();

	if(!$user->isLoggedIn()){
		Redirect::to('login.php');
	}

	if (Input::exists()) {

		if (Token::check(Input::get('token'))) {

			if (Input::get('search')) {
				$db = DB::getInstance();
				$type = Input::get('type');
				$field = (Input::get('field')) ? "LIKE '%".Input::get('field')."%'": '';
				if ($type == 'owner') {
					$sql = "SELECT * FROM volunteers WHERE firstName {$field} OR lastName {$field}";
					$check = $db->query($sql);

					if($check->count()){
						$volunteers = $check->results();
						$searchResults = array();
						foreach ($volunteers as $voluntary) {
							$result = $db->get('vehicles', array('id_voluntary', '=', $voluntary->id));
							if ($result->count()) {
								$searchResults[] = $db->first();
							}
						}
					}
				} else {
					$sql = "SELECT * FROM vehicles WHERE {$type} {$field}";
					$check = $db->query($sql);

					if($check->count()){
						$searchResults = $check->results();
					}
				}
			}

			if (Input::get('delete')) {
				try {
					$sistem = new Sistem('vehicles');
					$sistem->delete(escape(Input::get('id')));
				
					Session::flash('vehicles', 'El Vehículo ha sido eliminado con exito!');
					Redirect::to('vehiculos.php');
				} catch (Exception $e) {
					$error = $e->getMessage();
				}
			}
			
			$validate = new Validate();
			$id_unique = (Input::get('id')) ? escape(Input::get('id')): 10000000;
			$validation = $validate->check($_POST, array(
				'plate' => array(
					'required' => true,
					'uniqueById' => array(
						'id' => $id_unique,
						'table' => 'vehicles'
					),
					'min' => 6,
					'max' => 7,
					'display' => 'Placa'
				),
				'brand' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Marca'
				),
				'model' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Modelo'
				),
				'color' => array(
					'required' => true,
					'min' => 3,
					'max' => 10,
					'display' => 'Color'
				),
				'year' => array(
					'required' => true,
					'min' => 4,
					'max' => 4,
					'display' => 'Año'
				),
				'bodywork' => array(
					'uniqueById' => array(
						'id' => $id_unique,
						'table' => 'vehicles'
					),
					'display' => 'Carroceria'
				),
				'motor' => array(
					'uniqueById' => array(
						'id' => $id_unique,
						'table' => 'vehicles'
					),
					'display' => 'Motor'
				),
				'chassis' => array(
					'uniqueById' => array(
						'id' => $id_unique,
						'table' => 'vehicles'
					),
					'display' => 'Chasis'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('vehicles');
				
				try{
					if (Input::get('create')) {
						$sistem->create(array(
							'type' => escape(Input::get('type')),
							'plate' => escape(Input::get('plate')),
							'brand' => escape(Input::get('brand')),
							'model' => escape(Input::get('model')),
							'color' => escape(Input::get('color')),
							'year' => escape(Input::get('year')),
							'bodywork' => escape(Input::get('bodywork')),
							'motor' => escape(Input::get('motor')),
							'chassis' => escape(Input::get('chassis')),
							'id_voluntary' => escape(Input::get('voluntary')),
							'state' => escape(Input::get('state'))
						));

						Session::flash('vehicles', 'El Vehículo ha sido registrado con exito!');
					}

					if (Input::get('edit')) {
						$sistem->update(array(
							'id' => escape(Input::get('id')),
							'type' => escape(Input::get('type')),
							'plate' => escape(Input::get('plate')),
							'brand' => escape(Input::get('brand')),
							'model' => escape(Input::get('model')),
							'color' => escape(Input::get('color')),
							'year' => escape(Input::get('year')),
							'bodywork' => escape(Input::get('bodywork')),
							'motor' => escape(Input::get('motor')),
							'chassis' => escape(Input::get('chassis')),
							'id_voluntary' => escape(Input::get('voluntary')),
							'state' => escape(Input::get('state'))
						), escape(Input::get('id')));

						Session::flash('vehicles', 'El Vehículo ha sido modificado con exito!');
					}

					Redirect::to('vehiculos.php');
					
				} catch (Exception $e) {
					$error = $e->getMessage();
				}
				
			} else {
				$error = $validation->errors();
			}
		}
	}
	
	gettemplate('header');
?>
<div class="container">
	<div class="row">
		<div class="jumbotron">
			<div class="row">
				<?php if (Input::exists('get') && Input::get('new')) : ?>
					<div class="col-sm-offset-3 col-sm-6">
						<?php if (!empty($error)) {
							handlerMessage($error, 'danger');
						} ?>
						<h2>Vehículos <a href="?" class="btn btn-primary">Ver Vehículos</a></h2>
						<form action="" method="post">
							<div class="form-group">
								<label for="type">Tipo:</label>
								<select name="type" class="form-control" id="type">
									<option value="">Seleccione tipo</option>
									<?php $pos = array('Coupe', 'Sedan', 'Deportivo', 'Camioneta', 'Camion', 'Bus', 'Moto','Cuatrimoto');
									foreach ($pos as $value) { ?>
										<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>
							<?php Input::build('Placa', 'plate'); ?>
							<?php Input::build('Marca', 'brand'); ?>
							<?php Input::build('Modelo', 'model'); ?>
							<?php Input::build('Color', 'color'); ?>
							<?php Input::build('Año', 'year', '', 'number'); ?>
							<?php Input::build('Numero de carrocería', 'bodywork', '', 'number'); ?>
							<?php Input::build('Numero de Motor', 'motor', '', 'number'); ?>
							<?php Input::build('Chasis', 'chassis', '', 'number'); ?>
							<div class="form-group">
								<label for="voluntary">Propietario:</label>
								<?php $sistem = new Sistem('volunteers'); ?>
								<select name="voluntary" class="form-control" id="voluntary">
									<?php if ($sistem->get(array('id', '>', 0))) : ?>
										<?php foreach ($sistem->data() as $voluntary) { ?>
											<option value="<?php echo $voluntary->id; ?>"><?php echo $voluntary->firstName.' '.$voluntary->lastName; ?></option>
										<?php } ?>
									<?php else : ?>
										<option value="">No hay voluntarios registrados</option>
									<?php endif; ?>
								</select>
							</div>
							<?php Input::buildState(); ?>
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" name="create" class="btn btn-primary" value="Registrar"/>
						</form>
					</div>
				<?php elseif (Input::exists('get') && Input::get('edit')) : ?>
					<div class="col-sm-offset-3 col-sm-6">
						<?php if (!empty($error)) {
							handlerMessage($error, 'danger');
						} ?>
						<?php $sistem = new Sistem('vehicles');
						if ($sistem->get(array('id', '=', Input::get('edit')))) : 
							$vehicles = $sistem->data()[0]; ?>
							<h2>Vehículos</h2>
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
								<?php Input::build('Placa', 'plate', $vehicles->plate); ?>
								<?php Input::build('Marca', 'brand', $vehicles->brand); ?>
								<?php Input::build('Modelo', 'model', $vehicles->model); ?>
								<?php Input::build('Color', 'color', $vehicles->color); ?>
								<?php Input::build('Año', 'year', $vehicles->year, 'number'); ?>
								<?php Input::build('Numero de carrocería', 'bodywork', $vehicles->bodywork, 'number'); ?>
								<?php Input::build('Numero de Motor', 'motor', $vehicles->motor, 'number'); ?>
								<?php Input::build('Chasis', 'chassis', $vehicles->chassis, 'number'); ?>
								<div class="form-group">
									<label for="voluntary">Propietario:</label>
									<?php $sistem = new Sistem('volunteers'); ?>
									<select name="voluntary" class="form-control" id="voluntary">
										<?php if ($sistem->get(array('id', '>', 0))) : ?>
											<?php foreach ($sistem->data() as $voluntary) { 
												$selected = ($vehicles->id_voluntary === $voluntary->id) ? 'selected' : '';?>
												<option <?php echo $selected; ?> value="<?php echo $voluntary->id; ?>"><?php echo $voluntary->firstName.' '.$voluntary->lastName; ?></option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay voluntarios registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<?php Input::buildState($vehicles->state); ?>
								<input type="hidden" name="id" value="<?php echo Input::get('edit');?>">
								<input type="hidden" name="token" value="<?php echo Token::generate();?>">
								<input type="submit" name="edit" class="btn btn-primary" value="Editar"/>
								<input type="submit" name="delete" class="btn btn-danger pull-right" value="Eliminar"/>
							</form>
						<?php else :
							if (!empty($error)) {
								handlerMessage($error, 'danger');
							} 
						endif;?>
					</div>
				<?php elseif (Input::exists('get') && Input::get('view')) : ?>
					<div class="col-sm-12">
						<?php $sistem = new Sistem('vehicles');
						if ($sistem->get(array('id', '=', Input::get('view')))) :
							$vehicle = $sistem->data()[0]; ?>
							<div class="col-xs-12">
								<div class="row">
									<div class="pull-right noPrint">
										<?php if($user->hasPermission('admin')) { ?>
											<a href="?edit=<?php echo $vehicle->id; ?>" class="btn btn-primary">Editar</a> 
										<?php } ?>
										<a href="?" class="btn btn-success">Ver Vehiculos</a>
										<a href="#" class="btn btn-success" onclick="window.print()">Imprimir</a>
									</div>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="row">
									<h2>Registro de Vehiculos</h2>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Propietario: </h3>
									<p><?php echo getData($vehicle->id_voluntary, 'volunteers', 'firstName').' '.getData($vehicle->id_voluntary, 'volunteers', 'lastName'); ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Tipo: </h3>
									<p><?php echo $vehicle->type; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Placa: </h3>
									<p><?php echo $vehicle->plate; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Marca: </h3>
									<p><?php echo $vehicle->brand; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Modelo: </h3>
									<p><?php echo $vehicle->model; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Color: </h3>
									<p><?php echo $vehicle->color; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Año: </h3>
									<p><?php echo $vehicle->year; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Carroceria: </h3>
									<p><?php echo $vehicle->bodywork; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Motor: </h3>
									<p><?php echo $vehicle->motor; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Chasis: </h3>
									<p><?php echo $vehicle->chassis; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Estado: </h3>
									<p><?php echo ($vehicle->state) ? 'Activo': 'Inactivo'; ?></p>
								</div>
							</div>
						<?php else : ?>
							<p>Perdido?</p>
							<a href="?" class="btn btn-primary">Ver Vehiculos</a>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="col-sm-12">
						<?php if (Session::exists('vehicles')) {
							handlerMessage(Session::flash('vehicles'), 'success');
						} ?>
						<h2 class="pull-left">Vehículos 
						<?php if($user->hasPermission('admin')) { ?>
							<a href="?new=true" class="btn btn-primary">Nuevo Vehículo</a>
						<?php } ?>
						</h2>
						<form class="form-inline pull-right" action="" method="post">
							<select name="type" class="form-control">
								<option value="owner">Propietario</option>
								<option value="plate">Placa</option>
							</select>
							<?php Input::build('', 'field'); ?>
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" name="search" class="btn btn-primary" value="Buscar"/>
						</form>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Propietario</th>
									<th>Tipo</th>
									<th>Placa</th>
									<th>Marca</th>
									<th>Modelo</th>
									<th>Color</th>
									<th>Año</th>
									<th>Estado</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<?php if (!empty($searchResults)): ?>
								<tbody>
									<?php foreach ($searchResults as $vehicle) { ?>
										<tr>
											<td><?php echo getData($vehicle->id_voluntary, 'volunteers', 'firstName').' '.getData($vehicle->id_voluntary, 'volunteers', 'lastName'); ?></td>
											<td><?php echo $vehicle->type; ?></td>
											<td><?php echo $vehicle->plate; ?></td>
											<td><?php echo $vehicle->brand; ?></td>
											<td><?php echo $vehicle->model; ?></td>
											<td><?php echo $vehicle->color; ?></td>
											<td><?php echo $vehicle->year; ?></td>
											<td><?php echo ($vehicle->state) ? 'Activo': 'Inactivo'; ?></td>
											<td>
												<?php if($user->hasPermission('admin')) { ?>
													<a href="?edit=<?php echo $vehicle->id; ?>">Editar</a>
												<?php } ?>
												<a href="?view=<?php echo $vehicle->id; ?>">Ver</a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							<?php else : ?>
								<tbody>
									<?php $sistem = new Sistem('vehicles');
									if (!$sistem->get(array('id', '>', 0))) : ?>
										<tr>
											<td colspan="10"><h3><center>No hay registro</center></h3></td>
										</tr>
									<?php else :
										foreach ($sistem->data() as $vehicle) { ?>
											<tr>
												<td><?php echo getData($vehicle->id_voluntary, 'volunteers', 'firstName').' '.getData($vehicle->id_voluntary, 'volunteers', 'lastName'); ?></td>
												<td><?php echo $vehicle->type; ?></td>
												<td><?php echo $vehicle->plate; ?></td>
												<td><?php echo $vehicle->brand; ?></td>
												<td><?php echo $vehicle->model; ?></td>
												<td><?php echo $vehicle->color; ?></td>
												<td><?php echo $vehicle->year; ?></td>
												<td><?php echo ($vehicle->state) ? 'Activo': 'Inactivo'; ?></td>
												<td>
													<?php if($user->hasPermission('admin')) { ?>
														<a href="?edit=<?php echo $vehicle->id; ?>">Editar</a>
													<?php } ?>
													<a href="?view=<?php echo $vehicle->id; ?>">Ver</a>
												</td>
											</tr>
										<?php } ?>
									<?php endif; ?>
								</tbody>
							<?php endif; ?>
						</table>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php gettemplate('footer');
