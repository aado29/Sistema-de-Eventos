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
				$sql = "SELECT * FROM groups_2 WHERE {$type} {$field}";
				$check = $db->query($sql);

				if($check->count()){
					$searchResults = $check->results();
				}
			}

			if (Input::get('delete')) {
				try {
					$sistem = new Sistem('groups_2');
					$sistem->delete(escape(Input::get('id')));
				
					Session::flash('groups', 'El grupo ha sido eliminado con exito!');
					Redirect::to('grupos.php');
				} catch (Exception $e) {
					$error = $e->getMessage();
				}
			}
			
			$validate = new Validate();
			$id_unique = (Input::get('id')) ? escape(Input::get('id')): 10000000;
			$validation = $validate->check($_POST, array(
				'name' => array(
					'required' => TRUE,
					'uniqueById' => array(
						'id' => $id_unique,
						'table' => 'groups_2'
					),
					'min' => 3,
					'max' => 20,
					'display' => 'Nombre'
				),
				'speciality' => array(
					'required' => TRUE,
					'min' => 3,
					'max' => 20,
					'display' => 'Especialidad'
				),
				'description' => array(
					'required' => TRUE,
					'min' => 3,
					'max' => 100,
					'display' => 'Descripción'
				),
				'phone' => array(
					'required' => TRUE,
					'numeric' => true,
					'min' => 11,
					'max' => 11,
					'display' => 'Telefono'
				),
				'address' => array(
					'required' => TRUE,
					'min' => 3,
					'max' => 100,
					'display' => 'Dirección'
				),
				'email' => array(
					'required' => TRUE,
					'max' => 50,
					'display' => 'Correo electrónico'
				),
				'membersNumber' => array(
					'required' => TRUE,
					'positive' => TRUE,
					'min' => 1,
					'max' => 99,
					'display' => 'Numero de Miembros'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('groups_2');
				$relation = new Relation('equipments');
				
				try{
					if (Input::get('create')) {
						$filePath = '';
						if ((Input::file('image')['name'] !== '')) {
							$file = new File(Input::file('image'));
							$filePath = $file->upload();
						}

						$sistem->create(array(
							'name' => escape(Input::get('name')),
							'speciality' => escape(Input::get('speciality')),
							'description' => escape(Input::get('description')),
							'phone' => escape(Input::get('phone')),
							'address' => escape(Input::get('address')),
							'email' => escape(Input::get('email')),
							'membersNumber' => escape(Input::get('membersNumber')),
							'image' => $filePath,
							'state' => escape(Input::get('state'))
						));

						$sistem->get(array('id', '>', 0));
						$results = $sistem->data();
						$id = $results[count($results)-1]->id;

						if (!empty(Input::get('equipment')))
							$relation->create(Input::get('equipment'), $id, 'group');
					
						Session::flash('groups', 'El grupo ha sido registrado con exito!');
					}

					if (Input::get('edit')) {
						$id = escape(Input::get('id'));

						if ((Input::file('image')['name'] !== '')) {
							$file = new File(Input::file('image'));
							$filePath = $file->upload();
						} else {
							$sistem->get(array('id', '=', $id));
							$results = $sistem->data();
							$filePath = $results[0]->image;
						}

						$sistem->update(array(
							'id' => escape(Input::get('id')),
							'name' => escape(Input::get('name')),
							'speciality' => escape(Input::get('speciality')),
							'description' => escape(Input::get('description')),
							'phone' => escape(Input::get('phone')),
							'address' => escape(Input::get('address')),
							'email' => escape(Input::get('email')),
							'membersNumber' => escape(Input::get('membersNumber')),
							'image' => $filePath,
							'state' => escape(Input::get('state'))
						), $id);

						if (!empty(Input::get('equipment')))
							$relation->update(Input::get('equipment'), $id, 'group');

						Session::flash('groups', 'El grupo ha sido modificado con exito!');
					}

					Redirect::to('grupos.php');
					
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
						<h2>Grupo de Rescate <a href="?" class="btn btn-primary">Ver Grupos</a></h2>
						<form action="" method="post" enctype="multipart/form-data">
							<?php Input::build('Logo', 'image', '', 'file'); ?>
							<?php Input::build('Nombre', 'name'); ?>
							<?php Input::build('Especialidad', 'speciality'); ?>
							<?php Input::build('Descripción', 'description'); ?>
							<?php Input::build('Telefono', 'phone', '', 'tel'); ?>
							<?php Input::build('Dirección', 'address'); ?>
							<?php Input::build('Correo electrónico', 'email', '', 'email'); ?>
							<?php Input::build('Numero de Miembros', 'membersNumber', '', 'number'); ?>
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
						<?php $sistem = new Sistem('groups_2');
						if ($sistem->get(array('id', '=', Input::get('edit')))) : 
							$group = $sistem->data()[0]; ?>
							<h2>Grupo de Rescate</h2>
							<form action="" method="post" enctype="multipart/form-data">
								<?php Input::build('Logo', 'image', '', 'file'); ?>
								<?php Input::build('Nombre', 'name', $group->name); ?>
								<?php Input::build('Especialidad', 'speciality', $group->speciality); ?>
								<?php Input::build('Descripción', 'description', $group->description); ?>
								<?php Input::build('Telefono', 'phone', $group->phone, 'tel'); ?>
								<?php Input::build('Dirección', 'address', $group->address); ?>
								<?php Input::build('Correo electrónico', 'email', $group->email, 'email'); ?>
								<?php Input::build('Numero de Miembros', 'membersNumber', $group->membersNumber, 'number'); ?>
								<div class="form-group">
									<label for="equipment">Equipamiento:</label>
									<?php $sistem = new Sistem('equipments'); ?>
									<select name="equipment[]" multiple class="form-control" id="equipment">
										<?php if ($sistem->get(array('id', '>', 0))) :
											$relation = new Sistem('equipments_relations');
											$relation->get(array('id_owner', '=', $group->id));
											foreach ($sistem->data() as $equipment) {
												$selected = '';
												foreach ($relation->data() as $select) {
													if ($select->owner_type == 'group' && $select->id_equipment == $equipment->id) {
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
								<?php Input::buildState(); ?>
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
						<?php $sistem = new Sistem('groups_2');
						if ($sistem->get(array('id', '=', Input::get('view')))) :
							$group = $sistem->data()[0]; ?>
							<div class="col-xs-12">
								<div class="row">
									<div class="pull-right noPrint">
										<?php if($user->hasPermission('admin')) { ?>
											<a href="?edit=<?php echo $group->id; ?>" class="btn btn-primary">Editar</a> 
										<?php } ?>
										<a href="?" class="btn btn-success">Ver Grupos</a>
										<a href="#" class="btn btn-success" onclick="window.print()">Imprimir</a>
									</div>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="row">
									<h2>Registro de Grupos</h2>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-xs-2">
								<div class="row">
									
									<img src="<?php echo $group->image; ?>" height="100" alt="">

								</div>
							</div><div class="col-xs-5">
								<div class="row">
									<h3>Nombre: </h3>
									<p><?php echo $group->name; ?></p>
								</div>
							</div>
							<div class="col-xs-5">
								<div class="row">
									<h3>Especialidad: </h3>
									<p><?php echo $group->speciality; ?></p>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="row">
									<h3>Descripción: </h3>
									<p><?php echo $group->description; ?></p>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<h3>Telefono: </h3>
									<p><?php echo $group->phone; ?></p>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<h3>Correo: </h3>
									<p><?php echo $group->email; ?></p>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="row">
									<h3>Dirección: </h3>
									<p><?php echo $group->address; ?></p>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<h3>Numero de Miembros: </h3>
									<p><?php echo $group->membersNumber; ?></p>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<h3>Estado: </h3>
									<p><?php echo ($group->state) ? 'Activo': 'Inactivo'; ?></p>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<h3>Equipamientos: </h3>
									<ul>
										<?php $relation = new Sistem('equipments_relations');
										$relation->get(array('id_owner', '=', $group->id));
										foreach ($relation->data() as $select) {
											if ($select->owner_type == 'group') { ?>
												<li><?php echo getData($select->id_equipment, 'equipments', 'name'); ?> - <?php echo getData($select->id_equipment, 'equipments', 'type'); ?></li>
											<?php }
										} ?>
									</ul>
								</div>
							</div>
						<?php else : ?>
							<p>Perdido?</p>
							<a href="?" class="btn btn-primary">Ver Grupos</a>
						<?php endif; ?>
				<?php else : ?>
					<div class="col-xs-12">
						<?php if (Session::exists('groups')) {
							handlerMessage(Session::flash('groups'), 'success');
						} ?>

						<h2 class="pull-left">Gestion de Grupos Voluntarios
							<?php if($user->hasPermission('admin')) { ?>
								<a href="?new=true" class="btn btn-primary">Nuevo Grupo</a>
							<?php } ?>
						</h2>
						<form class="form-inline pull-right" action="" method="post">
							<select class="form-control" name="type">
								<option value="name">Nombre</option>
								<option value="speciality">Epecialidad</option>
							</select>
							<?php Input::build('', 'field'); ?>
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" name="search" class="btn btn-primary" value="Buscar"/>
						</form>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Logo</th>
									<th>Nombre</th>
									<th>Especialidad</th>
									<th>Telefono</th>
									<th>Numero de miembros</th>
									<th>Estado</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<?php if (!empty($searchResults)): ?>
								<tbody>
									<?php foreach ($searchResults as $group) { ?>
										<tr>
											<td><img src="<?php echo $group->image; ?>" height="100" alt=""></td>
											<td><?php echo $group->name; ?></td>
											<td><?php echo $group->speciality; ?></td>
											<td><?php echo $group->phone; ?></td>
											<td><?php echo $group->membersNumber; ?></td>
											<td><?php echo ($group->state) ? 'Activo': 'Inactivo'; ?></td>
											<td>
												<?php if($user->hasPermission('admin')) { ?>
													<a href="?edit=<?php echo $group->id; ?>" class="noPrint">Editar</a><br />
												<?php } ?>
												<a href="?view=<?php echo $group->id; ?>" class="noPrint">Ver</a>
											</td>
									<?php } ?>
								</tbody>
							<?php else : ?>
								<tbody>
									<?php $sistem = new Sistem('groups_2');
									if (!$sistem->get(array('id', '>', 0))) : ?>
										<tr>
											<td colspan="9"><h3><center>No hay registro</center></h3></td>
										</tr>
									<?php else :
										foreach ($sistem->data() as $group) { ?>
											<tr>
												<td><img src="<?php echo $group->image; ?>" height="100" alt=""></td>
												<td><?php echo $group->name; ?></td>
												<td><?php echo $group->speciality; ?></td>
												<td><?php echo $group->phone; ?></td>
												<td><?php echo $group->membersNumber; ?></td>
												<td><?php echo ($group->state) ? 'Activo': 'Inactivo'; ?></td>
												<td>
													<?php if($user->hasPermission('admin')) { ?>
														<a href="?edit=<?php echo $group->id; ?>" class="noPrint">Editar</a><br />
													<?php } ?>
													<a href="?view=<?php echo $group->id; ?>" class="noPrint">Ver</a>
												</td>
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