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
				'name' => array(
					'required' => TRUE,
					'min' => 2,
					'max' => 50,
					'display' => 'Tipo de evento'
				),
				'startDate' => array(
					'required' => TRUE,
					'display' => 'Fecha de inicio'
				),
				'dueDate' => array(
					'required' => TRUE,
					'display' => 'Fecha de fin'
				),
				'place' => array(
					'required' => TRUE,
					'min' => 2,
					'max' => 100,
					'display' => 'Lugar'
				),
				'voluntary' => array(
					'required' => TRUE,
					'display' => 'Voluntarios'
				),
				'team' => array(
					'required' => TRUE,
					'display' => 'Equipo'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('events');
				
				try{

					if (Input::get('create') === 'Registrar') {
						$sistem->create(array(
							'name' => escape(Input::get('name')),
							'startDate' => escape(Input::get('startDate')),
							'dueDate' => escape(Input::get('dueDate')),
							'place' => escape(Input::get('place')),
							'id_group' => escape(Input::get('group')),
							'id_voluntary' => escape(Input::get('voluntary')),
							'id_team' => escape(Input::get('team'))
						));
						
						Session::flash('events', 'El evento ha sido registrado con exito!');
					}

					if (Input::get('edit') === 'Editar') {
						$sistem->update(array(
							'id' => escape(Input::get('id')),
							'name' => escape(Input::get('name')),
							'startDate' => escape(Input::get('startDate')),
							'dueDate' => escape(Input::get('dueDate')),
							'place' => escape(Input::get('place')),
							'id_group' => escape(Input::get('group')),
							'id_voluntary' => escape(Input::get('voluntary')),
							'id_team' => escape(Input::get('team'))
						), escape(Input::get('id')));
						
						Session::flash('events', 'El evento ha sido modificado con exito!');
					}

					Redirect::to('eventos.php');
					
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
									<th>Nombre</th>
									<th>Fecha de inicio</th>
									<th>Fecha de fin</th>
									<th>Lugar</th>
									<th>Grupo</th>
									<th>Valuntario</th>
									<th>Equipo</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php $sistem = new Sistem('events');
								if (!$sistem->get(array('id', '>', 0))) : ?>
									<tr>
										<td colspan="8"><h3><center>No hay registro</center></h3></td>
									</tr>
								<?php else :
									foreach ($sistem->data() as $event) { ?>
										<tr>
											<td><?php echo $event->name; ?></td>
											<td><?php echo $event->startDate; ?></td>
											<td><?php echo $event->dueDate; ?></td>
											<td><?php echo $event->place; ?></td>
											<td><?php echo getData($event->id_group, 'groups_2', 'name'); ?></td>
											<td><?php echo getData($event->id_voluntary, 'volunteers', 'firstName'); ?> <?php echo getData($event->id_voluntary, 'volunteers', 'lastName'); ?></td>
											<td><?php echo getData($event->id_team, 'teams', 'name'); ?></td>
											<td><a href="?edit=<?php echo $event->id; ?>">editar</a><td>
										</tr>
									<?php } ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				<?php elseif (Input::exists('get') && Input::get('edit')) : ?>
					<div class="col-sm-offset-3 col-sm-6">
						<?php $sistem = new Sistem('events');
						if ($sistem->get(array('id', '=', Input::get('edit')))) : 
							$event = $sistem->data()[0]; ?>
							<h2>Gestionar Eventos</h2>
							<form action="" method="post">
								<div class="form-group">
									<label for="name">Tipo de Evento:</label>
									<input name="name" type="text" class="form-control" id="name" value="<?php echo $event->name; ?>">
								</div>
								<div class="form-group">
									<label for="startDate">Fecha de inicio:</label>
									<input name="startDate" type="date" class="form-control" id="startDate" value="<?php echo $event->startDate; ?>">
								</div>
								<div class="form-group">
									<label for="dueDate">Fecha de fin:</label>
									<input name="dueDate" type="date" class="form-control" id="dueDate" value="<?php echo $event->dueDate; ?>">
								</div>
								<div class="form-group">
									<label for="place">Lugar:</label>
									<input name="place" type="text" class="form-control" id="place" value="<?php echo $event->place; ?>">
								</div>
								<div class="form-group">
									<label for="group">Grupo:</label>
									<?php $sistem = new Sistem('groups_2'); ?>
									<select name="group" class="form-control" id="group">
										<?php if ($sistem->get(array('id', '>', 0))) : ?>
											<?php foreach ($sistem->data() as $group) { 
												$selected = ($event->id_group === $group->id) ? 'selected' : '';?>
												<option <?php echo $selected; ?> value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay grupos registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<div class="form-group">
									<label for="voluntary">Voluntario:</label>
									<?php $sistem = new Sistem('volunteers'); ?>
									<select name="voluntary" class="form-control" id="voluntary">
										<?php if ($sistem->get(array('id', '>', 0))) : ?>
											<?php foreach ($sistem->data() as $voluntary) { 
												$selected = ($event->id_voluntary === $voluntary->id) ? 'selected' : '';?>
												<option <?php echo $selected; ?> value="<?php echo $voluntary->id; ?>"><?php echo $voluntary->firstName; ?> - <?php echo $voluntary->lastName; ?></option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay valuntarios registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<div class="form-group">
									<label for="team">Equipo:</label>
									<?php $sistem = new Sistem('teams'); ?>
									<select name="team" class="form-control" id="team">
										<?php if ($sistem->get(array('id', '>', 0))) : ?>
											<?php foreach ($sistem->data() as $team) { 
												$selected = ($event->id_team === $team->id) ? 'selected' : '';?>
												<option <?php echo $selected; ?> value="<?php echo $team->id; ?>"><?php echo $team->name; ?></option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay equipos registrados</option>
										<?php endif; ?>
									</select>
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
						<?php if (Session::exists('events')) {
							handlerMessage(Session::flash('events'), 'success');
						} ?>
						<h2>Gestionar Eventos <a href="?show=true" class="btn btn-primary">Ver Eventos</a></h2>
						<form action="" method="post">
							<div class="form-group">
								<label for="name">Tipo de Evento:</label>
								<input name="name" type="text" class="form-control" id="name">
							</div>
							<div class="form-group">
								<label for="startDate">Fecha de inicio:</label>
								<input name="startDate" type="date" class="form-control" id="startDate">
							</div>
							<div class="form-group">
								<label for="dueDate">Fecha de fin:</label>
								<input name="dueDate" type="date" class="form-control" id="dueDate">
							</div>
							<div class="form-group">
								<label for="place">Lugar:</label>
								<input name="place" type="text" class="form-control" id="place">
							</div>
							<div class="form-group">
								<label for="group">Grupo:</label>
								<?php $sistem = new Sistem('groups_2'); ?>
								<select name="group" class="form-control" id="group">
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
								<label for="voluntary">Voluntario:</label>
								<?php $sistem = new Sistem('volunteers'); ?>
								<select name="voluntary" class="form-control" id="voluntary">
									<?php if ($sistem->get(array('id', '>', 0))) : ?>
										<?php foreach ($sistem->data() as $voluntary) { ?>
											<option value="<?php echo $voluntary->id; ?>"><?php echo $voluntary->firstName; ?> - <?php echo $voluntary->lastName; ?></option>
										<?php } ?>
									<?php else : ?>
										<option value="">No hay valuntarios registrados</option>
									<?php endif; ?>
								</select>
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
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" name="create" class="btn btn-primary" value="Registrar"/>
						</form>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>
<?php gettemplate('footer');
