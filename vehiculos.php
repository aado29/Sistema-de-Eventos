<?php
	require_once 'core/init.php';
	$user = new User();

	if(!$user->isLoggedIn()){
		Redirect::to('index.php');
	}

	if (Input::exists()) {

		if (Token::check(Input::get('token'))) {
			
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'plate' => array(
					'required' => true,
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
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Carrocería'
				),
				'motor' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Motor'
				),
				'chassis' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Chasis'
				),
				'state' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Estado'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('vehicles');
				
				try{
					if (Input::get('create') === 'Registrar') {
						$sistem->create(array(
							'plate' => escape(Input::get('plate')),
							'brand' => escape(Input::get('brand')),
							'model' => escape(Input::get('model')),
							'color' => escape(Input::get('color')),
							'year' => escape(Input::get('year')),
							'bodywork' => escape(Input::get('bodywork')),
							'motor' => escape(Input::get('motor')),
							'chassis' => escape(Input::get('chassis')),
							'state' => escape(Input::get('state'))
						));

						Session::flash('vehicles', 'El Vehículo ha sido registrado con exito!');
					}

					if (Input::get('edit') === 'Editar') {
						$sistem->update(array(
							'id' => escape(Input::get('id')),
							'plate' => escape(Input::get('plate')),
							'brand' => escape(Input::get('brand')),
							'model' => escape(Input::get('model')),
							'color' => escape(Input::get('color')),
							'year' => escape(Input::get('year')),
							'bodywork' => escape(Input::get('bodywork')),
							'motor' => escape(Input::get('motor')),
							'chassis' => escape(Input::get('chassis')),
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
				<?php if (Input::exists('get') && Input::get('show')) : ?>
					<div class="col-sm-12">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Placa</th>
									<th>Marca</th>
									<th>Modelo</th>
									<th>Color</th>
									<th>Año</th>
									<th>Carroceria</th>
									<th>Motor</th>
									<th>Chasis</th>
									<th>Estado</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php $sistem = new Sistem('vehicles');
								if (!$sistem->get(array('id', '>', 0))) : ?>
									<tr>
										<td colspan="8"><h3><center>No hay registro</center></h3></td>
									</tr>
								<?php else :
									foreach ($sistem->data() as $vehicle) { ?>
										<tr>
											<td><?php echo $vehicle->plate; ?></td>
											<td><?php echo $vehicle->brand; ?></td>
											<td><?php echo $vehicle->model; ?></td>
											<td><?php echo $vehicle->color; ?></td>
											<td><?php echo $vehicle->year; ?></td>
											<td><?php echo $vehicle->bodywork; ?></td>
											<td><?php echo $vehicle->motor; ?></td>
											<td><?php echo $vehicle->chassis; ?></td>
											<td><?php echo $vehicle->state; ?></td>
											<td><a href="?edit=<?php echo $vehicle->id; ?>">editar</a><td>
										</tr>
									<?php } ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				<?php elseif (Input::exists('get') && Input::get('edit')) : ?>
					<div class="col-sm-offset-3 col-sm-6">
						<?php $sistem = new Sistem('vehicles');
						if ($sistem->get(array('id', '=', Input::get('edit')))) : 
							$vehicles = $sistem->data()[0]; ?>
							<h2>Vehículos</h2>
							<form action="" method="post">
								<div class="form-group">
									<label for="plate">Placa:</label>
									<input name="plate" type="text" class="form-control" id="plate" value="<?php echo $vehicles->plate; ?>">
								</div>
								<div class="form-group">
									<label for="brand">Marca:</label>
									<input name="brand" type="text" class="form-control" id="brand" value="<?php echo $vehicles->brand; ?>">
								</div>
								<div class="form-group">
									<label for="model">Modelo:</label>
									<input name="model" type="text" class="form-control" id="model" value="<?php echo $vehicles->model; ?>">
								</div>
								<div class="form-group">
									<label for="color">Color:</label>
									<input name="color" type="text" class="form-control" id="color" value="<?php echo $vehicles->color; ?>">
								</div>
								<div class="form-group">
									<label for="year">Año:</label>
									<input name="year" type="number" class="form-control" id="year" value="<?php echo $vehicles->year; ?>">
								</div>
								<div class="form-group">
									<label for="bodywork">Numero de carrocería:</label>
									<input name="bodywork" type="number" class="form-control" id="bodywork" value="<?php echo $vehicles->bodywork; ?>">
								</div>
								<div class="form-group">
									<label for="motor">Numero de Motor:</label>
									<input name="motor" type="number" class="form-control" id="motor" value="<?php echo $vehicles->motor; ?>">
								</div>
								<div class="form-group">
									<label for="chassis">Chasis:</label>
									<input name="chassis" type="number" class="form-control" id="chassis" value="<?php echo $vehicles->chassis; ?>">
								</div>
								<div class="form-group">
									<label for="state">Estado:</label>
									<input name="state" type="text" class="form-control" id="state" value="<?php echo $vehicles->state; ?>">
								</div>
								<input type="hidden" name="id" value="<?php echo Input::get('edit');?>">
								<input type="hidden" name="token" value="<?php echo Token::generate();?>">
								<input type="submit" name="edit" class="btn btn-primary" value="Editar"/>
							</form>
						<?php else :
							if (!empty($error)) {
								handlerMessage($error, 'danger');
							} 
						endif;?>
					</div>
				<?php else : ?>
					<div class="col-sm-offset-3 col-sm-6">
						<?php if (!empty($error)) {
							handlerMessage($error, 'danger');
						} ?>
						<?php if (Session::exists('vehicles')) {
							handlerMessage(Session::flash('vehicles'), 'success');
						} ?>
						<h2>Vehículos <a href="?show=true" class="btn btn-primary">Ver Vehículos</a></h2>
						<form action="" method="post">
							<div class="form-group">
								<label for="plate">Placa:</label>
								<input name="plate" type="text" class="form-control" id="plate">
							</div>
							<div class="form-group">
								<label for="brand">Marca:</label>
								<input name="brand" type="text" class="form-control" id="brand">
							</div>
							<div class="form-group">
								<label for="model">Modelo:</label>
								<input name="model" type="text" class="form-control" id="model">
							</div>
							<div class="form-group">
								<label for="color">Color:</label>
								<input name="color" type="text" class="form-control" id="color">
							</div>
							<div class="form-group">
								<label for="year">Año:</label>
								<input name="year" type="number" class="form-control" id="year">
							</div>
							<div class="form-group">
								<label for="bodywork">Numero de carrocería:</label>
								<input name="bodywork" type="number" class="form-control" id="bodywork">
							</div>
							<div class="form-group">
								<label for="motor">Numero de Motor:</label>
								<input name="motor" type="number" class="form-control" id="motor">
							</div>
							<div class="form-group">
								<label for="chassis">Chasis:</label>
								<input name="chassis" type="number" class="form-control" id="chassis">
							</div>
							<div class="form-group">
								<label for="state">Estado:</label>
								<input name="state" type="text" class="form-control" id="state">
							</div>
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" name="create" class="btn btn-primary" value="Registrar"/>
						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php gettemplate('footer');
