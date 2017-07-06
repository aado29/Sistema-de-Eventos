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
				'ci' => array(
					'required' => true,
					'min' => 7,
					'max' => 8,
					'display' => 'Cedula de indentidad'
				),
				'firstName' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Nombre'
				),
				'lastName' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Apellido'
				),
				'address' => array(
					'required' => true,
					'min' => 2,
					'max' => 100,
					'display' => 'Dirección'
				),
				'phone' => array(
					'required' => true,
					'min' => 2,
					'max' => 11,
					'display' => 'Telefono'
				),
				'email' => array(
					'required' => true,
					'min' => 2,
					'max' => 50,
					'display' => 'Correo electónico'
				),
				'sizeShirt' => array(
					'required' => true,
					'max' => 2,
					'display' => 'Talla de franela'
				),
				'sizePants' => array(
					'required' => true,
					'max' => 2,
					'display' => 'Talla de pantalones'
				),
				'sizeShoes' => array(
					'required' => true,
					'max' => 2,
					'display' => 'Talla de zapatos'
				),
				'position' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Cargo'
				),
				'profession' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Profeción'
				),
				'speciality' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Especialidad'
				),
				'employment' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Ocupación'
				),
				'team' => array(
					'required' => true,
					'max' => 11,
					'display' => 'Equipo'
				),
				'vehicle' => array(
					'required' => true,
					'max' => 11,
					'display' => 'Vehículo'
				),
				'type' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Tipo'
				),
				'state' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Estado'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('volunteers');
				
				try{
					if (escape(Input::get('create')) === 'Registrar') {
						$sistem->create(array(
							'ci' => escape(Input::get('ci')),
							'firstName' => escape(Input::get('firstName')),
							'lastName' => escape(Input::get('lastName')),
							'address' => escape(Input::get('address')),
							'phone' => escape(Input::get('phone')),
							'email' => escape(Input::get('email')),
							'sizeShirt' => escape(Input::get('sizeShirt')),
							'sizePants' => escape(Input::get('sizePants')),
							'sizeShoes' => escape(Input::get('sizeShoes')),
							'position' => escape(Input::get('position')),
							'profession' => escape(Input::get('profession')),
							'speciality' => escape(Input::get('speciality')),
							'employment' => escape(Input::get('employment')),
							'id_team' => escape(Input::get('team')),
							'id_vehicle' => escape(Input::get('vehicle')),
							'type' => escape(Input::get('type')),
							'state' => escape(Input::get('state'))
						));
					
						Session::flash('volunteers', 'El voluntario ha sido registrado con exito!');
					}

					if (escape(Input::get('edit')) === 'Editar') {
						$sistem->update(array(
							'id' => escape(Input::get('id')),
							'ci' => escape(Input::get('ci')),
							'firstName' => escape(Input::get('firstName')),
							'lastName' => escape(Input::get('lastName')),
							'address' => escape(Input::get('address')),
							'phone' => escape(Input::get('phone')),
							'email' => escape(Input::get('email')),
							'sizeShirt' => escape(Input::get('sizeShirt')),
							'sizePants' => escape(Input::get('sizePants')),
							'sizeShoes' => escape(Input::get('sizeShoes')),
							'position' => escape(Input::get('position')),
							'profession' => escape(Input::get('profession')),
							'speciality' => escape(Input::get('speciality')),
							'employment' => escape(Input::get('employment')),
							'id_team' => escape(Input::get('team')),
							'id_vehicle' => escape(Input::get('vehicle')),
							'type' => escape(Input::get('type')),
							'state' => escape(Input::get('state'))
						), escape(Input::get('id')));

						Session::flash('volunteers', 'El voluntario ha sido modificado con exito!');
					}

					Redirect::to('voluntarios.php');
					
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
						<h2>Voluntarios <a href="?" class="btn btn-primary">Ver Voluntarios</a></h2>
						<form action="" method="post">
							<div class="form-group">
								<label for="ci">Cedula:</label>
								<input name="ci" type="number" class="form-control" id="ci">
							</div>
							<div class="form-group">
								<label for="firstName">Nombre:</label>
								<input name="firstName" type="text" class="form-control" id="firstName">
							</div>
							<div class="form-group">
								<label for="lastName">Apellido:</label>
								<input name="lastName" type="text" class="form-control" id="lastName">
							</div>
							<div class="form-group">
								<label for="address">Dirección:</label>
								<input name="address" type="text" class="form-control" id="address">
							</div>
							<div class="form-group">
								<label for="phone">Telefono:</label>
								<input name="phone" type="tel" class="form-control" id="phone">
							</div>
							<div class="form-group">
								<label for="email">Correo electónico:</label>
								<input name="email" type="email" class="form-control" id="email">
							</div>
							<div class="form-group">
								<label for="sizeShirt">Talla de camisa:</label>
								<select name="sizeShirt" class="form-control" id="sizeShirt">
									<?php $sizes = array('SS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL');
									for ($i = 0; $i < count($sizes); $i++) { ?>
										<option value="<?php echo $sizes[$i]; ?>"><?php echo $sizes[$i]; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="sizePants">Talla de pantalon:</label>
								<select name="sizePants" class="form-control" id="sizePants">
									<?php for ($i = 20; $i < 52; $i = $i+2) { ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="sizeShoes">Talla de zapatos:</label>
								<select name="sizeShoes" class="form-control" id="sizeShoes">
									<?php for ($i = 30; $i < 46; $i++) { ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="position">Cargo:</label>
								<input name="position" type="text" class="form-control" id="position">
							</div>
							<div class="form-group">
								<label for="profession">Profeción:</label>
								<input name="profession" type="text" class="form-control" id="profession">
							</div>
							<div class="form-group">
								<label for="speciality">Especialidad:</label>
								<input name="speciality" type="text" class="form-control" id="speciality">
							</div>
							<div class="form-group">
								<label for="employment">Ocupación:</label>
								<input name="employment" type="text" class="form-control" id="employment">
							</div>
							<div class="form-group">
								<label for="team">Equipo:</label>
								<?php $sistem = new Sistem('teams'); ?>
								<select name="team" class="form-control" id="team">
									<?php if ($sistem->get(array('id', '>', 0))) : ?>
										<?php foreach ($sistem->data() as $team) { ?>
											<option value="<?php echo $team->id; ?>"><?php echo $team->name; ?></option>
										<?php } ?>
									<?php else : ?>
										<option value="">No hay equipos registrados</option>
									<?php endif; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="vehicle">Vehículo:</label>
								<?php $sistem = new Sistem('vehicles'); ?>
								<select name="vehicle" class="form-control" id="vehicle">
									<?php if ($sistem->get(array('id', '>', 0))) : ?>
										<?php foreach ($sistem->data() as $vehicle) { ?>
											<option value="<?php echo $vehicle->id; ?>"><?php echo $vehicle->model; ?> - <?php echo $vehicle->plate; ?></option>
										<?php } ?>
									<?php else : ?>
										<option value="">No hay vehiculos registrados</option>
									<?php endif; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="type">Tipo:</label>
								<input name="type" type="text" class="form-control" id="type">
							</div>
							<div class="form-group">
								<label for="state">Estado:</label>
								<input name="state" type="text" class="form-control" id="state">
							</div>
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" name="create" class="btn btn-primary" value="Registrar"/>
						</form>
					</div>
				<?php elseif (Input::exists('get') && Input::get('edit')) : ?>
					<div class="col-sm-offset-3 col-sm-6">
						<?php if (!empty($error)) {
							handlerMessage($error, 'danger');
						} ?>
						<?php $sistem = new Sistem('volunteers');
						if ($sistem->get(array('id', '=', Input::get('edit')))) : 
							$voluntary = $sistem->data()[0]; ?>
							<h2>Voluntarios</h2>
							<form action="" method="post">
								<div class="form-group">
									<label for="ci">Cedula:</label>
									<input name="ci" type="number" class="form-control" id="ci" value="<?php echo $voluntary->ci; ?>">
								</div>
								<div class="form-group">
									<label for="firstName">Nombre:</label>
									<input name="firstName" type="text" class="form-control" id="firstName" value="<?php echo $voluntary->firstName; ?>">
								</div>
								<div class="form-group">
									<label for="lastName">Apellido:</label>
									<input name="lastName" type="text" class="form-control" id="lastName" value="<?php echo $voluntary->lastName; ?>">
								</div>
								<div class="form-group">
									<label for="address">Dirección:</label>
									<input name="address" type="text" class="form-control" id="address" value="<?php echo $voluntary->address; ?>">
								</div>
								<div class="form-group">
									<label for="phone">Telefono:</label>
									<input name="phone" type="tel" class="form-control" id="phone" value="<?php echo $voluntary->phone; ?>">
								</div>
								<div class="form-group">
									<label for="email">Correo electónico:</label>
									<input name="email" type="email" class="form-control" id="email" value="<?php echo $voluntary->email; ?>">
								</div>
								<div class="form-group">
									<label for="sizeShirt">Talla de camisa:</label>
									<select name="sizeShirt" class="form-control" id="sizeShirt">
										<?php $sizes = array('SS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL');
										for ($i = 0; $i < count($sizes); $i++) { 
											$selected = ($voluntary->sizeShirt === $sizes[$i]) ? 'selected' : '';?>
											<option <?php echo $selected; ?> value="<?php echo $sizes[$i]; ?>"><?php echo $sizes[$i]; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label for="sizePants">Talla de pantalon:</label>
									<select name="sizePants" class="form-control" id="sizePants">
										<?php for ($i = 20; $i < 52; $i = $i+2) { 
											$selected = ($voluntary->sizePants == $i) ? 'selected' : '';?>
											<option <?php echo $selected; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label for="sizeShoes">Talla de zapatos:</label>
									<select name="sizeShoes" class="form-control" id="sizeShoes">
										<?php for ($i = 30; $i < 46; $i++) { 
											$selected = ($voluntary->sizeShoes == $i) ? 'selected' : '';?>
											<option <?php echo $selected; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label for="position">Cargo:</label>
									<input name="position" type="text" class="form-control" id="position" value="<?php echo $voluntary->position; ?>">
								</div>
								<div class="form-group">
									<label for="profession">Profeción:</label>
									<input name="profession" type="text" class="form-control" id="profession" value="<?php echo $voluntary->profession; ?>">
								</div>
								<div class="form-group">
									<label for="speciality">Especialidad:</label>
									<input name="speciality" type="text" class="form-control" id="speciality" value="<?php echo $voluntary->speciality; ?>">
								</div>
								<div class="form-group">
									<label for="employment">Ocupación:</label>
									<input name="employment" type="text" class="form-control" id="employment" value="<?php echo $voluntary->employment; ?>">
								</div>
								<div class="form-group">
									<label for="team">Equipo:</label>
									<?php $sistem = new Sistem('teams'); ?>
									<select name="team" class="form-control" id="team">
										<?php if ($sistem->get(array('id', '>', 0))) : ?>
											<?php foreach ($sistem->data() as $team) { 
												$selected = ($voluntary->id_team === $team->id) ? 'selected' : '';?>
												<option <?php echo $selected; ?> value="<?php echo $team->id; ?>"><?php echo $team->name; ?></option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay equipos registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<div class="form-group">
									<label for="vehicle">Vehículo:</label>
									<?php $sistem = new Sistem('vehicles'); ?>
									<select name="vehicle" class="form-control" id="vehicle" value="<?php echo $voluntary->id_vehicle; ?>">
										<?php if ($sistem->get(array('id', '>', 0))) : ?>
											<?php foreach ($sistem->data() as $vehicle) { 
												$selected = ($voluntary->id_vehicle === $vehicle->id) ? 'selected' : '';?>
												<option <?php echo $selected; ?> value="<?php echo $vehicle->id; ?>"><?php echo $vehicle->model; ?> - <?php echo $vehicle->plate; ?></option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay vehiculos registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<div class="form-group">
									<label for="type">Tipo:</label>
									<input name="type" type="text" class="form-control" id="type" value="<?php echo $voluntary->type; ?>">
								</div>
								<div class="form-group">
									<label for="state">Estado:</label>
									<input name="state" type="text" class="form-control" id="state" value="<?php echo $voluntary->state; ?>">
								</div>
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
				<?php else : ?>
					<div class="col-sm-12">
						<?php if (Session::exists('volunteers')) {
							handlerMessage(Session::flash('volunteers'), 'success');
						} ?>
						<h2>Voluntarios <a href="?new=true" class="btn btn-primary">Nuevo Voluntario</a></h2>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Cedula</th>
									<th>Nombre</th>
									<th>Apellido</th>
									<th>Dirección</th>
									<th>Telefono</th>
									<th>Correo electronico</th>
									<th>Talla de franela</th>
									<th>Talla de pantalones</th>
									<th>Talla de zapatos</th>
									<th>Cargo</th>
									<th>Profesión</th>
									<th>Especialidad</th>
									<th>Ocupación</th>
									<th>Equipo</th>
									<th>Vehículo</th>
									<th>Tipo</th>
									<th>Estado</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php $sistem = new Sistem('volunteers');
								if (!$sistem->get(array('id', '>', 0))) : ?>
									<tr>
										<td colspan="8"><h3><center>No hay registro</center></h3></td>
									</tr>
								<?php else :
									foreach ($sistem->data() as $voluntary) { ?>
										<tr>
											<td><?php echo $voluntary->ci; ?></td>
											<td><?php echo $voluntary->firstName; ?></td>
											<td><?php echo $voluntary->lastName; ?></td>
											<td><?php echo $voluntary->address; ?></td>
											<td><?php echo $voluntary->phone; ?></td>
											<td><?php echo $voluntary->email; ?></td>
											<td><?php echo $voluntary->sizeShirt; ?></td>
											<td><?php echo $voluntary->sizePants; ?></td>
											<td><?php echo $voluntary->sizeShoes; ?></td>
											<td><?php echo $voluntary->position; ?></td>
											<td><?php echo $voluntary->profession; ?></td>
											<td><?php echo $voluntary->speciality; ?></td>
											<td><?php echo $voluntary->employment; ?></td>
											<td><?php echo getData($voluntary->id_team, 'teams', 'name'); ?></td>
											<td><?php echo getData($voluntary->id_vehicle, 'vehicles', 'plate'); ?> - <?php echo getData($voluntary->id_vehicle, 'vehicles', 'model'); ?></td>
											<td><?php echo $voluntary->type; ?></td>
											<td><?php echo $voluntary->state; ?></td>
											<td><a href="?edit=<?php echo $voluntary->id; ?>">editar</a><td>
										</tr>
									<?php } ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php gettemplate('footer');