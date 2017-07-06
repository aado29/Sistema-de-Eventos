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
					'min' => 3,
					'max' => 20,
					'display' => 'Nombre'
				),
				'type' => array(
					'required' => TRUE,
					'min' => 3,
					'max' => 20,
					'display' => 'Tipo'
				),
				'description' => array(
					'required' => TRUE,
					'min' => 3,
					'max' => 100,
					'display' => 'Descripción'
				),
				'phone' => array(
					'required' => TRUE,
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
					'min' => 1,
					'max' => 99,
					'display' => 'Numero de Miembros'
				),
				'state' => array(
					'required' => TRUE,
					'min' => 3,
					'max' => 20,
					'display' => 'Estado'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('groups_2');
				
				try{
					if (escape(Input::get('create')) === 'Registrar') {
						$sistem->create(array(
							'name' => escape(Input::get('name')),
							'type' => escape(Input::get('type')),
							'description' => escape(Input::get('description')),
							'phone' => escape(Input::get('phone')),
							'address' => escape(Input::get('address')),
							'email' => escape(Input::get('email')),
							'membersNumber' => escape(Input::get('membersNumber')),
							'state' => escape(Input::get('state'))
						));
					
						Session::flash('groups', 'El grupo ha sido registrado con exito!');
					}

					if (escape(Input::get('edit')) === 'Editar') {
						$sistem->update(array(
							'id' => escape(Input::get('id')),
							'name' => escape(Input::get('name')),
							'type' => escape(Input::get('type')),
							'description' => escape(Input::get('description')),
							'phone' => escape(Input::get('phone')),
							'address' => escape(Input::get('address')),
							'email' => escape(Input::get('email')),
							'membersNumber' => escape(Input::get('membersNumber')),
							'state' => escape(Input::get('state'))
						), escape(Input::get('id')));

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
						<form action="" method="post">
							<div class="form-group">
								<label for="name">Nombre:</label>
								<input name="name" type="text" class="form-control" id="name">
							</div>
							<div class="form-group">
								<label for="type">Tipo:</label>
								<input name="type" type="text" class="form-control" id="type">
							</div>
							<div class="form-group">
								<label for="description">Descripción:</label>
								<input name="description" type="text" class="form-control" id="description">
							</div>
							<div class="form-group">
								<label for="phone">Telefono:</label>
								<input name="phone" type="tel" class="form-control" id="phone">
							</div>
							<div class="form-group">
								<label for="address">Dirección:</label>
								<input name="address" type="text" class="form-control" id="address">
							</div>
							<div class="form-group">
								<label for="email">Correo electrónico:</label>
								<input name="email" type="email" class="form-control" id="email">
							</div>
							<div class="form-group">
								<label for="membersNumber">Numero de Miembros:</label>
								<input name="membersNumber" type="number" class="form-control" id="membersNumber">
							</div>
							<div class="form-group">
								<label for="state">Estado:</label>
								<input name="state" type="text" class="form-control" id="state">
							</div>
							<input type="hidden" name="token" value="<?php echo Token::generate();?>">
							<input type="submit" class="btn btn-primary" value="Registrar"/>
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
							<form action="" method="post">
								<div class="form-group">
									<label for="name">Nombre:</label>
									<input name="name" type="text" class="form-control" id="name" value="<?php echo $group->name; ?>">
								</div>
								<div class="form-group">
									<label for="type">Tipo:</label>
									<input name="type" type="text" class="form-control" id="type" value="<?php echo $group->type; ?>">
								</div>
								<div class="form-group">
									<label for="description">Descripción:</label>
									<input name="description" type="text" class="form-control" id="description" value="<?php echo $group->description; ?>">
								</div>
								<div class="form-group">
									<label for="phone">Telefono:</label>
									<input name="phone" type="tel" class="form-control" id="phone" value="<?php echo $group->phone; ?>">
								</div>
								<div class="form-group">
									<label for="address">Dirección:</label>
									<input name="address" type="text" class="form-control" id="address" value="<?php echo $group->address; ?>">
								</div>
								<div class="form-group">
									<label for="email">Correo electrónico:</label>
									<input name="email" type="email" class="form-control" id="email" value="<?php echo $group->email; ?>">
								</div>
								<div class="form-group">
									<label for="membersNumber">Numero de Miembros:</label>
									<input name="membersNumber" type="number" class="form-control" id="membersNumber" value="<?php echo $group->membersNumber; ?>">
								</div>
								<div class="form-group">
									<label for="state">Estado:</label>
									<input name="state" type="text" class="form-control" id="state" value="<?php echo $group->state; ?>">
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
						<?php if (Session::exists('groups')) {
							handlerMessage(Session::flash('groups'), 'success');
						} ?>
						<h2>Grupo de Rescate <a href="?new=true" class="btn btn-primary">Nuevo Grupo</a></h2>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Tipo</th>
									<th>Descripción</th>
									<th>Telefono</th>
									<th>Dirección</th>
									<th>Correo electronico</th>
									<th>Numero de miembros</th>
									<th>Estado</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php $sistem = new Sistem('groups_2');
								if (!$sistem->get(array('id', '>', 0))) : ?>
									<tr>
										<td colspan="8"><h3><center>No hay registro</center></h3></td>
									</tr>
								<?php else :
									foreach ($sistem->data() as $group) { ?>
										<tr>
											<td><?php echo $group->name; ?></td>
											<td><?php echo $group->type; ?></td>
											<td><?php echo $group->description; ?></td>
											<td><?php echo $group->phone; ?></td>
											<td><?php echo $group->address; ?></td>
											<td><?php echo $group->email; ?></td>
											<td><?php echo $group->membersNumber; ?></td>
											<td><?php echo $group->state; ?></td>
											<td><a href="?edit=<?php echo $group->id; ?>">editar</a><td>
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