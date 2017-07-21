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
				$sql = "SELECT * FROM volunteers WHERE {$type} {$field}";
				$check = $db->query($sql);

				if($check->count()){
					$searchResults = $check->results();
				}
			}

			if (Input::get('delete')) {
				try {
					$sistem = new Sistem('volunteers');
					$sistem->delete(escape(Input::get('id')));
				
					Session::flash('volunteers', 'El voluntario ha sido eliminado con exito!');
					Redirect::to('voluntarios.php');
				} catch (Exception $e) {
					$error = $e->getMessage();
				}
			}
			
			$validate = new Validate();
			$id_unique = (Input::get('id')) ? escape(Input::get('id')): 10000000;
			$validation = $validate->check($_POST, array(
				'ci' => array(
					'required' => true,
					'numeric' => true,
					'uniqueById' => array(
						'id' => $id_unique,
						'table' => 'volunteers'
					),
					'min' => 7,
					'max' => 9,
					'display' => 'Cedula de indentidad'
				),
				'firstName' => array(
					'required' => true,
					'name' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Nombres'
				),
				'lastName' => array(
					'required' => true,
					'name' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Apellidos'
				),
				'birthday' => array(
					'required' => true,
					'ageMin' => true,
					'ageMax' => true,
					'display' => 'Fecha de nacimiento'
				),
				'phone' => array(
					'required' => true,
					'numeric' => true,
					'min' => 11,
					'max' => 11,
					'display' => 'Telefono'
				),
				'email' => array(
					'required' => true,
					'min' => 5,
					'max' => 50,
					'display' => 'Correo electónico'
				),
				'profession' => array(
					'required' => true,
					'min' => 5,
					'max' => 20,
					'display' => 'Profesión'
				),
				'employment' => array(
					'min' => 2,
					'max' => 20,
					'display' => 'Ocupación'
				),
				'group' => array(
					'required' => true,
					'display' => 'Grupo'
				),
				'position' => array(
					'required' => true,
					'display' => 'Cargo'
				),
				'speciality' => array(
					'min' => 5,
					'max' => 20,
					'display' => 'Especialidad'
				)
			));

			if ($validation->passed()) {

				$sistem = new Sistem('volunteers');
				$relation = new Relation('equipments');

				try{
					if (Input::get('create')) {
						$filePath = '';
						if (!empty(Input::file('photo'))) {
							$file = new File(Input::file('photo'));
							$filePath = $file->upload();
						}

						$sistem->create(array(
							'photo' => $filePath,
							'ci' => escape(Input::get('ci')),
							'firstName' => escape(Input::get('firstName')),
							'lastName' => escape(Input::get('lastName')),
							'gender' => escape(Input::get('gender')),
							'birthday' => escape(Input::get('birthday')),
							'address' => escape(Input::get('address')),
							'phone' => escape(Input::get('phone')),
							'email' => escape(Input::get('email')),
							'profession' => escape(Input::get('profession')),
							'employment' => escape(Input::get('employment')),
							'sizeShirt' => escape(Input::get('sizeShirt')),
							'sizePants' => escape(Input::get('sizePants')),
							'sizeShoes' => escape(Input::get('sizeShoes')),
							'id_group' => escape(Input::get('group')),
							'position' => escape(Input::get('position')),
							'speciality' => escape(Input::get('speciality')),
							'state' => escape(Input::get('state'))
						));
						$sistem->get(array('id', '>', 0));
						$results = $sistem->data();
						$id = $results[count($results)-1]->id;

						$relation->create(Input::get('equipment'), $id, 'voluntary');
					
						Session::flash('volunteers', 'El voluntario ha sido registrado con exito!');
					}

					if (Input::get('edit')) {
						$id = escape(Input::get('id'));

						if ((Input::file('photo')['name'] !== '')) {
							$file = new File(Input::file('photo'));
							$filePath = $file->upload();
						} else {
							$sistem->get(array('id', '=', $id));
							$results = $sistem->data();
							$filePath = $results[0]->photo;
						}

						$sistem->update(array(
							'id' => escape(Input::get('id')),
							'photo' => $filePath,
							'ci' => escape(Input::get('ci')),
							'firstName' => escape(Input::get('firstName')),
							'lastName' => escape(Input::get('lastName')),
							'gender' => escape(Input::get('gender')),
							'birthday' => escape(Input::get('birthday')),
							'address' => escape(Input::get('address')),
							'phone' => escape(Input::get('phone')),
							'email' => escape(Input::get('email')),
							'profession' => escape(Input::get('profession')),
							'employment' => escape(Input::get('employment')),
							'sizeShirt' => escape(Input::get('sizeShirt')),
							'sizePants' => escape(Input::get('sizePants')),
							'sizeShoes' => escape(Input::get('sizeShoes')),
							'id_group' => escape(Input::get('group')),
							'position' => escape(Input::get('position')),
							'speciality' => escape(Input::get('speciality')),
							
							'state' => escape(Input::get('state'))
						), $id);

						$relation->update(Input::get('equipment'), $id, 'voluntary');

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
						<h2>Registro de Voluntarios <a href="?" class="btn btn-primary">Ver Voluntarios</a></h2>
						<form action="" method="post" enctype="multipart/form-data">
							<?php Input::build('Foto', 'photo', '', 'file'); ?>
							<?php Input::build('Cedula', 'ci', '', 'number'); ?>
							<?php Input::build('Nombres', 'firstName'); ?>
							<?php Input::build('Apellidos', 'lastName'); ?>
							<div class="form-group">
								<label for="gender">Genero:</label>
								<select name="gender" class="form-control" id="gender">
									<?php $genders = array('Masculino', 'Femenino', 'Otro');
									foreach ($genders as $gender) { ?>
										<option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
									<?php } ?>
								</select>
							</div>
							<?php Input::build('Fecha de nacimiento', 'birthday', '', 'date'); ?>
							<?php Input::build('Dirección', 'address', '', 'textarea'); ?>
							<?php Input::build('Telefono', 'phone', '', 'tel'); ?>
							<?php Input::build('Correo electónico', 'email', '', 'email'); ?>
							<?php Input::build('Profesión', 'profession'); ?>
							<?php Input::build('Ocupación', 'employment'); ?>
							<div class="form-group">
								<label for="sizeShirt">Talla de camisa:</label>
								<select name="sizeShirt" class="form-control" id="sizeShirt">
									<option value="">Seleccione talla</option>
									<?php $sizes = array('SS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL');
									for ($i = 0; $i < count($sizes); $i++) { ?>
										<option value="<?php echo $sizes[$i]; ?>"><?php echo $sizes[$i]; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="sizePants">Talla de pantalon:</label>
								<select name="sizePants" class="form-control" id="sizePants">
									<option value="">Seleccione talla</option>
									<?php for ($i = 20; $i < 52; $i = $i+2) { ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="sizeShoes">Talla de zapatos:</label>
								<select name="sizeShoes" class="form-control" id="sizeShoes">
									<option value="">Seleccione talla</option>
									<?php for ($i = 30; $i < 46; $i++) { ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
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
							<div class="form-group">
								<label for="position">Cargo:</label>
								<select name="position" class="form-control" id="position">
									<option value="">Seleccione cargo</option>
									<?php $pos = array('Directivo', 'Miembro', 'Aspirante');
									foreach ($pos as $value) { ?>
										<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>
							<?php Input::build('Especialidad', 'speciality'); ?>
							
							<div class="form-group">
								<label for="equipment">Equipamiento:</label>
								<?php $sistem = new Sistem('equipments'); ?>
								<select name="equipment[]" multiple class="form-control" id="equipment">
									<?php if ($sistem->get(array('id', '>', 0))) : ?>
										<?php foreach ($sistem->data() as $equipment) {?>
											<option value="<?php echo $equipment->id; ?>"><?php echo $equipment->name; ?> - <?php echo $equipment->type; ?></option>
										<?php } ?>
									<?php else : ?>
										<option value="">No hay equipos registrados</option>
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
						<?php $sistem = new Sistem('volunteers');
						if ($sistem->get(array('id', '=', Input::get('edit')))) : 
							$voluntary = $sistem->data()[0]; ?>
							<h2>Edicion de Voluntario</h2>
							<form action="" method="post" enctype="multipart/form-data">
								<?php Input::build('Foto', 'photo', '', 'file'); ?>
								<?php Input::build('Cedula', 'ci', $voluntary->ci, 'number'); ?>
								<?php Input::build('Nombres', 'firstName', $voluntary->firstName); ?>
								<?php Input::build('Apellidos', 'lastName', $voluntary->lastName); ?>
								<div class="form-group">
									<label for="gender">Genero:</label>
									<select name="gender" class="form-control" id="gender">
										<?php $genders = array('Masculino', 'Femenino', 'Otro');
										foreach ($genders as $gender) {
											$selected = ($voluntary->gender === $gender) ? 'selected' : '';?>
											<option <?php echo $selected; ?> value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
										<?php } ?>
									</select>
								</div>
								<?php Input::build('Fecha de nacimiento', 'birthday', $voluntary->birthday, 'date'); ?>
								<?php Input::build('Dirección', 'address', $voluntary->address, 'textarea'); ?>
								<?php Input::build('Telefono', 'phone', $voluntary->phone, 'tel'); ?>
								<?php Input::build('Correo electónico', 'email', $voluntary->email, 'email'); ?>
								<?php Input::build('Profesión', 'profession', $voluntary->profession); ?>
								<?php Input::build('Ocupación', 'employment', $voluntary->employment); ?>
								<div class="form-group">
									<label for="sizeShirt">Talla de camisa:</label>
									<select name="sizeShirt" class="form-control" id="sizeShirt">
										<option value="">Seleccione talla</option>
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
										<option value="">Seleccione talla</option>
										<?php for ($i = 20; $i < 52; $i = $i+2) { 
											$selected = ($voluntary->sizePants == $i) ? 'selected' : '';?>
											<option <?php echo $selected; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label for="sizeShoes">Talla de zapatos:</label>
									<select name="sizeShoes" class="form-control" id="sizeShoes">
										<option value="">Seleccione talla</option>
										<?php for ($i = 30; $i < 46; $i++) { 
											$selected = ($voluntary->sizeShoes == $i) ? 'selected' : '';?>
											<option <?php echo $selected; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label for="group">Grupo:</label>
									<?php $sistem = new Sistem('groups_2'); ?>
									<select name="group" class="form-control" id="group">
										<option value="">Seleccione grupo</option>
										<?php if ($sistem->get(array('id', '>', 0))) : ?>
											<?php foreach ($sistem->data() as $group) { 
												$selected = ($voluntary->id_group === $group->id) ? 'selected' : '';?>
												<option <?php echo $selected; ?> value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay grupos registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<div class="form-group">
									<label for="position">Cargo:</label>
									<select name="position" class="form-control" id="position">
										<option value="">Seleccione cargo</option>
										<?php $pos = array('Directivo', 'Miembro', 'Aspirante');
										foreach ($pos as $value) { 
											$selected = ($voluntary->position === $value) ? 'selected' : ''; ?>
											<option <?php echo $selected ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
										<?php } ?>
									</select>
								</div>
								<?php Input::build('Especialidad', 'speciality', $voluntary->speciality); ?>
								<div class="form-group">
									<label for="equipment">Equipamiento:</label>
									<?php $sistem = new Sistem('equipments'); ?>
									<select name="equipment[]" multiple class="form-control" id="equipment">
										<?php if ($sistem->get(array('id', '>', 0))) :
											$relation = new Sistem('equipments_relations');
											$relation->get(array('id_owner', '=', $voluntary->id));
											foreach ($sistem->data() as $equipment) {
												$selected = '';
												foreach ($relation->data() as $select) {
													if ($select->owner_type == 'voluntary' && $select->id_equipment == $equipment->id) {
														$selected = 'selected';
														break;
													} ?>
												<?php } ?>
												<option <?php echo $selected; ?> value="<?php echo $equipment->id; ?>">
													<?php echo $equipment->name; ?> - <?php echo $equipment->type; ?>
												</option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay equipos registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<?php Input::buildState($voluntary->state); ?>
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
						<?php $sistem = new Sistem('volunteers');
						if ($sistem->get(array('id', '=', Input::get('view')))) :
							$voluntary = $sistem->data()[0]; ?>
							<div class="col-xs-12">
								<div class="row">
									<div class="pull-right noPrint">
										<?php if($user->hasPermission('admin')) { ?>
											<a href="?edit=<?php echo $voluntary->id; ?>" class="btn btn-primary">Editar</a> 
										<?php } ?>
										<a href="?" class="btn btn-success">Ver Voluntarios</a>
										<a href="#" class="btn btn-success" onclick="window.print()">Imprimir</a>
									</div>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="row">
									<h2>Registro de Voluntarios</h2>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-xs-12">
								<div class="row">
									<h3>Datos Personales: </h3>
								</div>
							</div>
							<div class="col-xs-2">
								<div class="row">
									<img src="<?php echo $voluntary->photo; ?>" height="100" alt="">
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Nombres: </h3>
									<p><?php echo $voluntary->firstName; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Apellidos: </h3>
									<p><?php echo $voluntary->lastName; ?></p>
								</div>
							</div>
							<div class="col-xs-2">
								<div class="row">
									<h3>Genero: </h3>
									<p><?php echo $voluntary->gender; ?></p>
								</div>
							</div>
							<div class="col-xs-2">
								<div class="row">
									<h3>Cedula de identidad: </h3>
									<p><?php echo $voluntary->ci; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Fecha de nacimiento: </h3>
									<p><?php echo ($voluntary->birthday !== '0000-00-00') ? $voluntary->birthday: 'No registrado'; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Dirección: </h3>
									<p><?php echo $voluntary->address; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Teléfono: </h3>
									<p><?php echo $voluntary->phone; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Correo eletrónico: </h3>
									<p><?php echo $voluntary->email; ?></p>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Talla de franela: </h3>
									<p><?php echo ($voluntary->sizeShirt) ? $voluntary->sizeShirt: 'Vacío'; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Talla de pantalones: </h3>
									<p><?php echo ($voluntary->sizePants) ? $voluntary->sizePants: 'Vacío'; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Talla de zapatos: </h3>
									<p><?php echo ($voluntary->sizeShoes) ? $voluntary->sizeShoes: 'Vacío'; ?></p>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="row">
									<h3>Datos Profesionales: </h3>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<h3>Prefesión: </h3>
									<p><?php echo ($voluntary->profession) ? $voluntary->profession: 'Vacío'; ?></p>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<h3>Ocupación: </h3>
									<p><?php echo ($voluntary->employment) ? $voluntary->employment: 'Vacío'; ?></p>
								</div>
							</div>

							
							<div class="col-xs-12">
								<div class="row">
									<h3>Datos de Grupo: </h3>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Grupo: </h3>
									<p><?php echo getData($voluntary->id_group, 'groups_2', 'name'); ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Cargo: </h3>
									<p><?php echo $voluntary->position; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Especialidad: </h3>
									<p><?php echo ($voluntary->speciality) ? $voluntary->speciality: 'Vacío'; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Estado: </h3>
									<p><?php echo ($voluntary->state) ? 'Activo': 'Inactivo'; ?></p>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="row">
									<h3>Otros Datos: </h3>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<?php $sistem = new Sistem('vehicles');
									$sistem->get(array('id', '>', 0));
									$posee = 'No';
									foreach ($sistem->data() as $vehicle) {
									 	if ($vehicle->id_voluntary == $voluntary->id) {
									 		$posee = 'Sí';
									 		break;
									 	}
									} ?>
									<h3>Posee vehiculo: </h3>
									<p><?php echo $posee; ?></p>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<h3>Equipamientos: </h3>
									<ul>
										<?php $relation = new Sistem('equipments_relations');
										$relation->get(array('id_owner', '=', $voluntary->id));
										foreach ($relation->data() as $select) {
											if ($select->owner_type == 'voluntary') { ?>
												<li><?php echo getData($select->id_equipment, 'equipments', 'name'); ?> - <?php echo getData($select->id_equipment, 'equipments', 'type'); ?></li>
											<?php }
										} ?>
									</ul>
								</div>
							</div>
						<?php else : ?>
							<p>Perdido?</p>
							<a href="?" class="btn btn-primary">Ver Voluntarios</a>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="col-sm-12">
						<?php if (Session::exists('volunteers')) {
							handlerMessage(Session::flash('volunteers'), 'success');
						} ?>
						<h2 class="pull-left">Gestion de Voluntarios 
							<?php if($user->hasPermission('admin')) { ?>
								<a href="?new=true" class="btn btn-primary">Nuevo Voluntario</a>
							<?php } ?>
						</h2>
						<form class="form-inline pull-right" action="" method="post">
							<select class="form-control" name="type">
								<option value="firstName">Nombre</option>
								<option value="lastName">Apellido</option>
								<option value="ci">Cedula de indentidad</option>
							</select>
							<?php Input::build('', 'field'); ?>
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" name="search" class="btn btn-primary" value="Buscar"/>
						</form>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Foto</th>
									<th>Cedula</th>
									<th>Nombre</th>
									<th>Apellido</th>
									<th>Dirección</th>
									<th>Telefono</th>
									<th>Grupo</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<?php if (!empty($searchResults)): ?>
								<tbody>
									<?php foreach ($searchResults as $voluntary) { ?>
										<tr>
											<td><img src="<?php echo $voluntary->photo; ?>" height="100" alt=""></td>
											<td><?php echo $voluntary->ci; ?></td>
											<td><?php echo $voluntary->firstName; ?></td>
											<td><?php echo $voluntary->lastName; ?></td>
											<td><?php echo $voluntary->address; ?></td>
											<td><?php echo $voluntary->phone; ?></td>
											<td><?php echo getData($voluntary->id_group, 'groups_2', 'name'); ?></th>
											<td>
												<?php if($user->hasPermission('admin')) { ?>
													<a href="?edit=<?php echo $voluntary->id; ?>">Editar</a><br />
												<?php } ?>
											<a href="?view=<?php echo $voluntary->id; ?>">Ver</a></td>
										</tr>
									<?php } ?>
								</tbody>
							<?php else : ?>
								<tbody>
									<?php $sistem = new Sistem('volunteers');
									if (!$sistem->get(array('id', '>', 0))) : ?>
										<tr>
											<td colspan="18"><h3><center>No hay registro</center></h3></td>
										</tr>
									<?php else :
										foreach ($sistem->data() as $voluntary) { ?>
											<tr>
												<td><img src="<?php echo $voluntary->photo; ?>" height="100" alt=""></td>
												<td><?php echo $voluntary->ci; ?></td>
												<td><?php echo $voluntary->firstName; ?></td>
												<td><?php echo $voluntary->lastName; ?></td>
												<td><?php echo $voluntary->address; ?></td>
												<td><?php echo $voluntary->phone; ?></td>
												<td><?php echo getData($voluntary->id_group, 'groups_2', 'name'); ?></th>
												<td>
													<?php if($user->hasPermission('admin')) { ?>
														<a href="?edit=<?php echo $voluntary->id; ?>">Editar</a><br />
													<?php } ?>
												<a href="?view=<?php echo $voluntary->id; ?>">Ver</a></td>
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