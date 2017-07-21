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
				$field = (Input::get('field')) ? "LIKE '%".Input::get('field')."%'": '';
				$sql = "SELECT * FROM equipments WHERE name {$field}";
				$check = $db->query($sql);

				if($check->count()){
					$searchResults = $check->results();
				}
			}

			if (Input::get('delete')) {
				try {
					$sistem = new Sistem('equipments');
					$sistem->delete(escape(Input::get('id')));
				
					Session::flash('equipments', 'El equipo ha sido eliminado con exito!');
					Redirect::to('equipos.php');
				} catch (Exception $e) {
					$error = $e->getMessage();
				}
			}
			
			$validate = new Validate();
			$id_unique = (Input::get('id')) ? escape(Input::get('id')): 10000000;
			$validation = $validate->check($_POST, array(
				'name' => array(
					'required' => true,
					'min' => 3,
					'uniqueById' => array(
						'id' => $id_unique,
						'table' => 'equipments'
					),
					'max' => 50,
					'display' => 'Nombre'
				),
				'type' => array(
					'required' => true,
					'min' => 5,
					'max' => 50,
					'display' => 'Tipo'
				),
				'description' => array(
					'required' => true,
					'min' => 2,
					'max' => 100,
					'display' => 'Descripción'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('equipments');
				
				try{
					if (Input::get('create')) {
						$sistem->create(array(
							'name' => escape(Input::get('name')),
							'type' => escape(Input::get('type')),
							'description' => escape(Input::get('description')),
							'state' => escape(Input::get('state'))
						));
						
						Session::flash('equipments', 'El equipo ha sido registrado con exito!');
					}

					if (Input::get('edit')) {
						$sistem->update(array(
							'id' => escape(Input::get('id')),
							'name' => escape(Input::get('name')),
							'type' => escape(Input::get('type')),
							'description' => escape(Input::get('description')),
							'state' => escape(Input::get('state'))
						), escape(Input::get('id')));

						Session::flash('equipments', 'El equipo ha sido editado con exito!');
					}
					
					Redirect::to('equipos.php');

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
						<h2>Equipamientos <a href="?" class="btn btn-primary">Ver Equipamientos</a></h2>
						<form action="" method="post">
							<?php Input::build('Nombre', 'name'); ?>
							<div class="form-group">
								<label for="type">Tipo:</label>
								<select name="type" class="form-control" id="type">
									<option value="">Seleccione tipo</option>
									<?php $pos = array('Alpinismo', 'Rescate en agua', 'Estricamiento', 'Vialidad', 'Primeros Auxilios');
									foreach ($pos as $value) { ?>
										<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>
							<?php Input::build('Descripción', 'description'); ?>
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
						<?php $sistem = new Sistem('equipments');
						if ($sistem->get(array('id', '=', Input::get('edit')))) : 
							$equipment = $sistem->data()[0]; ?>
							<h2>Gestionar Equipamientos</h2>
							<form action="" method="post">
								<?php Input::build('Nombre', 'name', $equipment->name); ?>
								<div class="form-group">
								<label for="type">Tipo:</label>
								<select name="type" class="form-control" id="type">
									<option value="">Seleccione tipo</option>
									<?php $pos = array('Alpinismo', 'Rescate en agua', 'Estricamiento', 'Vialidad', 'Primeros Auxilios');
									foreach ($pos as $value) { 
										$selected = ($equipment->type === $value) ? 'selected' : '';?>
										<option <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>
								<?php Input::build('Descripción', 'description', $equipment->description); ?>
								<?php Input::buildState($equipment->state); ?>
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
						<?php $sistem = new Sistem('equipments');
						if ($sistem->get(array('id', '=', Input::get('view')))) :
							$equipment = $sistem->data()[0]; ?>
							<div class="col-xs-12">
								<div class="row">
									<div class="pull-right noPrint">
										<?php if($user->hasPermission('admin')) { ?>
											<a href="?edit=<?php echo $equipment->id; ?>" class="btn btn-primary">Editar</a> 
										<?php } ?>
										<a href="?" class="btn btn-success">Ver Equipamientos</a>
										<a href="#" class="btn btn-success" onclick="window.print()">Imprimir</a>
									</div>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="row">
									<h2>Registro de Equipamientos</h2>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Nombre: </h3>
									<p><?php echo $equipment->name; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Tipo: </h3>
									<p><?php echo $equipment->type; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Estado: </h3>
									<p><?php echo ($equipment->state) ? 'Activo': 'Inactivo'; ?></p>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<h3>Descripción: </h3>
									<p><?php echo $equipment->description; ?></p>
								</div>
							</div>
						<?php else : ?>
							<p>Perdido?</p>
							<a href="?" class="btn btn-primary">Ver Equipamientos</a>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="col-sm-12">
						<?php if (Session::exists('equipments')) {
							handlerMessage(Session::flash('equipments'), 'success');
						} ?>
						<h2 class="pull-left">Equipamientos 
						<?php if($user->hasPermission('admin')) { ?>
							<a href="?new=true" class="btn btn-primary">Nuevo Equipamiento</a>
						<?php } ?>
						</h2>
						<form class="form-inline pull-right" action="" method="post">
							<?php Input::build('Nombre', 'field'); ?>
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" name="search" class="btn btn-primary" value="Buscar"/>
						</form>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Tipo</th>
									<th>Descripción</th>
									<th>Estado</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<?php if (!empty($searchResults)): ?>
								<tbody>
									<?php foreach ($searchResults as $equipment) { ?>
										<tr>
											<td><?php echo $equipment->name; ?></td>
											<td><?php echo $equipment->type; ?></td>
											<td><?php echo $equipment->description; ?></td>
											<td><?php echo ($equipment->state) ? 'Activo': 'Inactivo'; ?></td>
											<td>
												<?php if($user->hasPermission('admin')) { ?>
													<a href="?edit=<?php echo $equipment->id; ?>">Editar</a><br />
												<?php } ?>
												<a href="?view=<?php echo $equipment->id; ?>">Ver</a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							<?php else : ?>
								<tbody>
									<?php $sistem = new Sistem('equipments');
									if (!$sistem->get(array('id', '>', 0))) : ?>
										<tr>
											<td colspan="4"><h3><center>No hay registro</center></h3></td>
										</tr>
									<?php else :
										foreach ($sistem->data() as $equipment) { ?>
											<tr>
												<td><?php echo $equipment->name; ?></td>
												<td><?php echo $equipment->type; ?></td>
												<td><?php echo $equipment->description; ?></td>
												<td><?php echo ($equipment->state) ? 'Activo': 'Inactivo'; ?></td>
												<td>
													<?php if($user->hasPermission('admin')) { ?>
														<a href="?edit=<?php echo $equipment->id; ?>">Editar</a><br />
													<?php } ?>
													<a href="?view=<?php echo $equipment->id; ?>">Ver</a>
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