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
				$field = (Input::get('field')) ? "LIKE ".Input::get('field'): '';
				$sql = "SELECT * FROM events WHERE id_events_type {$field}";
				$check = $db->query($sql);

				if($check->count()){
					$searchResults = $check->results();
				}
			}

			if (Input::get('delete')) {
				try {
					$sistem = new Sistem('events');
					$sistem->delete(escape(Input::get('id')));
				
					Session::flash('events', 'El evento ha sido eliminado con exito!');
					Redirect::to('eventos.php');
				} catch (Exception $e) {
					$error = $e->getMessage();
				}
			}
			
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'type' => array(
					'required' => true,
					'display' => 'Tipo de evento'
				),
				'description' => array(
					'required' => TRUE,
					'min' => 2,
					'max' => 200,
					'display' => 'Descripción'
				),
				'startDate' => array(
					'required' => TRUE,
					'display' => 'Fecha de inicio'
				),
				'place' => array(
					'required' => TRUE,
					'min' => 2,
					'max' => 100,
					'display' => 'Lugar'
				),
				'voluntary' => array(
					'array' => TRUE,
					'display' => 'Voluntario'
				),
				'results' => array(
					'max' => 1200,
					'display' => 'Resultados'
				),
			));

			if ($validation->passed()) {
				$sistem = new Sistem('events');
				$relation = new Relation('events');
				
				try{

					if (Input::get('create')) {
						$sistem->create(array(
							'id_events_type' => escape(Input::get('type')),
							'description' => escape(Input::get('description')),
							'startDate' => escape(Input::get('startDate')),
							'dueDate' => escape(Input::get('dueDate')),
							'startHour' => escape(Input::get('startHour')),
							'dueHour' => escape(Input::get('dueHour')),
							'place' => escape(Input::get('place')),
							'results' => escape(Input::get('results'))
						));
						$sistem->get(array('id', '>', 0));
						$results = $sistem->data();
						$id = $results[count($results)-1]->id;

						$relation->create(Input::get('group'), $id, 'group');
						$relation->create(Input::get('voluntary'), $id, 'voluntary');
						$relation->create(Input::get('equipment'), $id, 'equipment');
						
						Session::flash('events', 'El evento ha sido registrado con exito!');
					}

					if (Input::get('edit')) {
						$id = escape(Input::get('id'));
						$sistem->update(array(
							'id' => escape(Input::get('id')),
							'id_events_type' => escape(Input::get('type')),
							'description' => escape(Input::get('description')),
							'startDate' => escape(Input::get('startDate')),
							'dueDate' => escape(Input::get('dueDate')),
							'startHour' => escape(Input::get('startHour')),
							'dueHour' => escape(Input::get('dueHour')),
							'place' => escape(Input::get('place')),
							'results' => escape(Input::get('results'))
						), $id);

						$relation->update(Input::get('group'), $id, 'group');
						$relation->update(Input::get('voluntary'), $id, 'voluntary');
						$relation->update(Input::get('equipment'), $id, 'equipment');
						
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
				<?php if (Input::exists('get') && Input::get('new')) : ?>
					<div class="col-sm-offset-3 col-sm-6">
						<?php if (!empty($error)) {
							handlerMessage($error, 'danger');
						} ?>
						<h2>Gestionar Eventos <a href="?" class="btn btn-primary">Ver Eventos</a></h2>
						<form action="" method="post">
							<?php getTreeType('Tipo de Evento', 'type'); ?>
							<?php Input::build('Descripción', 'description', '', 'textarea'); ?>
							<?php Input::build('Fecha de inicio', 'startDate', '', 'date'); ?>
							<?php Input::build('Fecha de fin', 'dueDate', '', 'date'); ?>
							<?php Input::build('Hora de inicio', 'startHour', '', 'time'); ?>
							<?php Input::build('Hora de fin', 'dueHour', '', 'time'); ?>
							<?php Input::build('Lugar', 'place'); ?>
							<div class="form-group">
								<label for="group">Grupo:</label>
								<?php $sistem = new Sistem('groups_2'); ?>
								<select name="group[]" multiple class="form-control" id="group">
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
								<select name="voluntary[]" multiple class="form-control" id="voluntary">
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
								<label for="equipment">Equipamiento:</label>
								<?php $sistem = new Sistem('equipments'); ?>
								<select name="equipment[]" multiple class="form-control" id="equipment">
									<?php if ($sistem->get(array('id', '>', 0))) : ?>
										<?php foreach ($sistem->data() as $equipment) { ?>
											<option value="<?php echo $equipment->id; ?>"><?php echo $equipment->name; ?></option>
										<?php } ?>
									<?php else : ?>
										<option value="">No hay equipos registrados</option>
									<?php endif; ?>
								</select>
							</div>
							<?php Input::build('Resultados', 'results', '', 'textarea'); ?>
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" name="create" class="btn btn-primary" value="Registrar"/>
						</form>
					</div>
				<?php elseif (Input::exists('get') && Input::get('edit')) : ?>
					<div class="col-sm-offset-3 col-sm-6">
						<?php if (!empty($error)) {
							handlerMessage($error, 'danger');
						} ?>
						<?php $sistem = new Sistem('events');
						if ($sistem->get(array('id', '=', Input::get('edit')))) : 
							$event = $sistem->data()[0]; ?>
							<h2>Gestionar Eventos</h2>
							<form action="" method="post">
								<?php getTreeType('Tipo de Evento', 'type', $event->type); ?>
								<?php Input::build('Descripción', 'description', $event->description, 'textarea'); ?>
								<?php Input::build('Fecha de inicio', 'startDate', $event->startDate, 'date'); ?>
								<?php Input::build('Fecha de fin', 'dueDate', $event->dueDate, 'date'); ?>
								<?php Input::build('Hora de inicio', 'startHour', $event->startHour, 'time'); ?>
								<?php Input::build('Hora de fin', 'dueHour', $event->dueHour, 'time'); ?>
								<?php Input::build('Lugar', 'place', $event->place); ?>
								<div class="form-group">
									<label for="group">Grupo:</label>
									<?php $sistem = new Sistem('groups_2'); ?>
									<select name="group[]" multiple class="form-control" id="group">
										<?php if ($sistem->get(array('id', '>', 0))) :
										$relation = new Sistem('events_relations');
										$relation->get(array('id_event', '=', $event->id));
											foreach ($sistem->data() as $group) {
												$selected = '';
												foreach ($relation->data() as $select) {
													if ($select->partaker == 'group' && $select->id_partaker == $group->id) {
														$selected = 'selected';
														break;
													} ?>
												<?php } ?>
												<option <?php echo $selected; ?> value="<?php echo $group->id; ?>">
													<?php echo $group->name; ?>
												</option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay grupos registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<div class="form-group">
									<label for="voluntary">Voluntario:</label>
									<?php $sistem = new Sistem('volunteers'); ?>
									<select name="voluntary[]" multiple class="form-control" id="voluntary">
										<?php if ($sistem->get(array('id', '>', 0))) :
											$relation = new Sistem('events_relations');
											$relation->get(array('id_event', '=', $event->id));
											foreach ($sistem->data() as $voluntary) {
												$selected = '';
												foreach ($relation->data() as $select) {
													if ($select->partaker == 'voluntary' && $select->id_partaker == $voluntary->id) {
														$selected = 'selected';
														break;
													} ?>
												<?php } ?>
												<option <?php echo $selected; ?> value="<?php echo $voluntary->id; ?>">
													<?php echo $voluntary->firstName; ?> - <?php echo $voluntary->lastName; ?>
												</option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay valuntarios registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<div class="form-group">
									<label for="equipment">Equipamiento:</label>
									<?php $sistem = new Sistem('equipments'); ?>
									<select name="equipment[]" multiple class="form-control" id="equipment">
										<?php if ($sistem->get(array('id', '>', 0))) :
											$relation = new Sistem('events_relations');
											$relation->get(array('id_event', '=', $event->id));
											foreach ($sistem->data() as $equipment) {
												$selected = '';
												foreach ($relation->data() as $select) {
													if ($select->partaker == 'equipment' && $select->id_partaker == $equipment->id) {
														$selected = 'selected';
														break;
													} ?>
												<?php } ?>
												<option <?php echo $selected; ?> value="<?php echo $equipment->id; ?>">
													<?php echo $equipment->name; ?>
												</option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay equipos registrados</option>
										<?php endif; ?>
									</select>
								</div>
								<?php Input::build('Resultados', 'results', $event->results, 'textarea'); ?>
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
						<?php $sistem = new Sistem('events');
						if ($sistem->get(array('id', '=', Input::get('view')))) :
							$event = $sistem->data()[0]; ?>
							<div class="col-xs-12">
								<div class="row">
									<div class="pull-right noPrint">
										<?php if($user->hasPermission('admin')) { ?>
											<a href="?edit=<?php echo $event->id; ?>" class="btn btn-primary">Editar</a> 
										<?php } ?>
										<a href="?" class="btn btn-success">Ver Eventos</a>
										<a href="#" class="btn btn-success" onclick="window.print()">Imprimir</a>
									</div>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="row">
									<h2><?php echo getData($event->id_events_type, 'events_type', 'name'); ?></h2>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-xs-12">
								<div class="row">
									<h3>Lugar: </h3>
									<p><?php echo $event->place; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Fecha de inicio: </h3>
									<p><?php echo $event->startDate; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Hora de inicio: </h3>
									<p><?php echo $event->startHour; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Fecha de fin: </h3>
									<p><?php echo $event->dueDate; ?></p>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<h3>Hora de fin: </h3>
									<p><?php echo $event->dueHour; ?></p>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Grupos: </h3>
									<ul>
										<?php $relation = new Sistem('events_relations');
										$relation->get(array('id_event', '=', $event->id));
										foreach ($relation->data() as $select) {
											if ($select->partaker == 'group') { ?>
												<li><?php echo getData($select->id_partaker, 'groups_2', 'name'); ?></li>
											<?php }
										} ?>
									</ul>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Equipamientos: </h3>
									<ul>
										<?php $relation = new Sistem('events_relations');
										$relation->get(array('id_event', '=', $event->id));
										foreach ($relation->data() as $select) {
											if ($select->partaker == 'equipment') { ?>
												<li><?php echo getData($select->id_partaker, 'equipments', 'name'); ?></li>
											<?php }
										} ?>
									</ul>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<h3>Voluntarios: </h3>
									<ul>
										<?php $relation = new Sistem('events_relations');
										$relation->get(array('id_event', '=', $event->id));
										foreach ($relation->data() as $select) {
											if ($select->partaker == 'voluntary') { ?>
												<li><?php echo getData($select->id_partaker, 'volunteers', 'firstName'); ?> 
												<?php echo getData($select->id_partaker, 'volunteers', 'lastName'); ?></li>
											<?php }
										} ?>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-xs-12">
								<div class="row">
									<h3>Descripción: </h3>
									<p><?php echo $event->description; ?></p>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="row">
									<h3>Resultados: </h3>
									<p><?php echo ($event->results) ? $event->results: 'Vacío'; ?></p>
								</div>
							</div>
						<?php else : ?>
							<p>Perdido?</p>
							<a href="?" class="btn btn-primary">Ver Eventos</a>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="col-sm-12">
						<?php if (Session::exists('events')) {
							handlerMessage(Session::flash('events'), 'success');
						} ?>
						<h2 class="pull-left">Gestion de Eventos <?php if($user->hasPermission('admin')) { ?> <a href="?new=true" class="btn btn-primary">Nuevo Evento</a><?php } ?></h2>
						<form class="form-inline pull-right" action="" method="post">
							<?php getTreeType('Tipo de Evento', 'field'); ?>
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" name="search" class="btn btn-primary" value="Buscar"/>
						</form>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Tipo de evento</th>
									<th>Lugar</th>
									<th>Fecha de inicio</th>
									<th>Fecha de fin</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<?php if (!empty($searchResults)): ?>
								<tbody>
									<?php foreach ($searchResults as $event) { ?>
										<tr>
											<td><?php echo getData($event->id_events_type, 'events_type', 'name'); ?></td>
											<td><?php echo $event->place; ?></td>
											<td><?php echo $event->startDate; ?></td>
											<td><?php echo $event->dueDate; ?></td>
											<td>
												<?php if($user->hasPermission('admin')) { ?>
													<a href="?edit=<?php echo $event->id; ?>">Editar</a><br />
												<?php } ?>
												<a href="?view=<?php echo $event->id; ?>">Ver</a>
											<td>
										</tr>
									<?php } ?>
								</tbody>
							<?php else : ?>
								<tbody>
									<?php $sistem = new Sistem('events');
									if (!$sistem->get(array('id', '>', 0))) : ?>
										<tr>
											<td colspan="8"><h3><center>No hay registro</center></h3></td>
										</tr>
									<?php else :
										foreach ($sistem->data() as $event) { ?>
											<tr>
												<td><?php echo getData($event->id_events_type, 'events_type', 'name'); ?></td>
												<td><?php echo $event->place; ?></td>
												<td><?php echo $event->startDate; ?></td>
												<td><?php echo $event->dueDate; ?></td>
												<td>
													<?php if($user->hasPermission('admin')) { ?>
														<a href="?edit=<?php echo $event->id; ?>">Editar</a><br />
													<?php } ?>
													<a href="?view=<?php echo $event->id; ?>">Ver</a>
												<td>
											</tr>
										<?php } ?>
									<?php endif; ?>
								</tbody>
							<?php endif ?>
						</table>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>
<?php gettemplate('footer');
