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

			if (Input::get('delete')) {
				try {
					$sistem = new Sistem('users');
					$sistem->delete(escape(Input::get('id')));
				
					Session::flash('users', 'El usuario ha sido eliminado con exito!');
					Redirect::to('usuarios.php');
				} catch (Exception $e) {
					$error = $e->getMessage();
				}
			}
			
			$validate = new Validate();
			if (Input::get('create')) {
				$validation = $validate->check($_POST, array(
					'ci' => array(
						'required' => TRUE,
						'min' => 7,
						'max' => 8,
						'unique' => 'users',
						'display' => 'Cedula'
					),
					'username' => array(
						'required' => TRUE,
						'min' => 3,
						'max' => 20,
						'unique' => 'users',
						'display' => 'Nombre de usuario'
					),
					'firstName' => array(
						'required' => TRUE,
						'min' => 2,
						'max' => 50,
						'display' => 'Nombre'
					),
					'lastName' => array(
						'required' => TRUE,
						'min' => 2,
						'max' => 50,
						'display' => 'Apellido'
					),
					'email' => array(
						'required' => TRUE,
						'min' => 2,
						'max' => 50,
						'unique' => 'users',
						'display' => 'Correo electrónico'
					),
					'phone' => array(
						'required' => TRUE,
						'min' => 11,
						'max' => 11,
						'display' => 'Telefono'
					),
					'group' => array(
						'required' => TRUE,
						'display' => 'Tipo de usuario'
					),
					'password' => array(
						'required' => TRUE,
						'min' => 6,
						'display' => 'Contraseña'
					),
					'password_again' => array(
						'required' => TRUE,
						'matches' => 'password',
						'display' => 'Contraseña 2'
					)
				));
			}
			if (Input::get('edit')) {
				$id_unique = (Input::get('id')) ? escape(Input::get('id')): 10000000;
				$validation = $validate->check($_POST, array(
					'ci' => array(
						'required' => TRUE,
						'min' => 7,
						'max' => 8,
						'uniqueById' => array(
							'id' => $id_unique,
							'table' => 'users'
						),
						'display' => 'Cedula'
					),
					'username' => array(
						'required' => TRUE,
						'min' => 3,
						'max' => 20,
						'display' => 'Nombre de usuario'
					),
					'firstName' => array(
						'required' => TRUE,
						'min' => 2,
						'max' => 50,
						'display' => 'Nombre'
					),
					'lastName' => array(
						'required' => TRUE,
						'min' => 2,
						'max' => 50,
						'display' => 'Apellido'
					),
					'email' => array(
						'required' => TRUE,
						'min' => 2,
						'max' => 50,
						'display' => 'Correo electrónico'
					),
					'phone' => array(
						'required' => TRUE,
						'min' => 11,
						'max' => 11,
						'display' => 'Telefono'
					),
					'group' => array(
						'required' => TRUE,
						'display' => 'Tipo de usuario'
					)
				));
			}

			if ($validation->passed()) {
				$user = new User();
			
				$salt = escape(Hash::salt(32));
				
				try{
					if (Input::get('create')) {
						$user->create(array(
							'ci' => escape(Input::get('ci')),
							'username' => escape(Input::get('username')),
							'password' => Hash::make(Input::get('password'), $salt),
							'salt' => $salt,
							'firstName' => escape(Input::get('firstName')),
							'lastName' => escape(Input::get('lastName')),
							'email' => escape(Input::get('email')),
							'phone' => escape(Input::get('phone')),
							'joined' => date('Y-m-d H:i:s'),
							'group' => escape(Input::get('group'))
						));
						
						Session::flash('users', 'El usuario ha sido registrado con exito!');
					}

					if (Input::get('edit')) {
						$user->update(array(
							'ci' => escape(Input::get('ci')),
							'username' => escape(Input::get('username')),
							'firstName' => escape(Input::get('firstName')),
							'lastName' => escape(Input::get('lastName')),
							'email' => escape(Input::get('email')),
							'phone' => escape(Input::get('phone'))
							//'group' => escape(Input::get('group'))
						), escape(Input::get('id')));

						Session::flash('users', 'El usuario ha sido modificado con exito!');
					}

					Redirect::to('usuarios.php');

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
						<h2>Gestionar usuarios <a href="?" class="btn btn-primary">Ver Usuarios</a></h2>
						<form action="" method="post">
							<?php Input::build('Cedula', 'ci', '', 'number'); ?>
							<?php Input::build('Nombre de Usuario', 'username'); ?>
							<?php Input::build('Nombres', 'firstName'); ?>
							<?php Input::build('Apellidos', 'lastName'); ?>
							<?php Input::build('Correo electónico', 'email', '', 'email'); ?>
							<?php Input::build('Telefono', 'phone', '', 'tel'); ?>
							
							<div class="form-group">
								<label for="group">Tipo:</label>
								<?php $sistem = new Sistem('groups'); ?>
								<select name="group" class="form-control" id="group">
									<?php if ($sistem->get(array('id', '>', 0))) : ?>
										<?php foreach ($sistem->data() as $group) { ?>
											<option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
										<?php } ?>
									<?php else : ?>
										<option value="">No hay equipos registrados</option>
									<?php endif; ?>
								</select>
							</div>
							<?php Input::build('Contraseña', 'password', '', 'password'); ?>
							<?php Input::build('Repita su contraseña', 'password_again', '', 'password'); ?>
							<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
							<input type="submit" name="create" class="btn btn-primary" value="Registrar">
						</form>
					</div>
				<?php elseif (Input::exists('get') && Input::get('edit')) : ?>
					<div class="col-sm-offset-3 col-sm-6">
						<?php if (!empty($error)) {
							handlerMessage($error, 'danger');
						} ?>
						<?php $sistem = new Sistem('users');
						if ($sistem->get(array('id', '=', Input::get('edit')))) : 
							$user = $sistem->data()[0]; ?>
							<h2>Gestionar Usuarios</h2>
							<form action="" method="post">

								<?php Input::build('Cedula', 'ci', $user->ci, 'number') ?>
								<?php Input::build('Nombre de Usuario', 'username', $user->username); ?>
								<?php Input::build('Nombres', 'firstName', $user->firstName); ?>
								<?php Input::build('Apellidos', 'lastName', $user->lastName); ?>
								<?php Input::build('Correo electónico', 'email', $user->email, 'email'); ?>
								<?php Input::build('Telefono', 'phone', $user->phone, 'tel'); ?>
								
								<div class="form-group">
									<label for="group">Tipo:</label>
									<?php $sistem = new Sistem('groups'); ?>
									<select name="group" class="form-control" id="group">
										<?php if ($sistem->get(array('id', '>', 0))) : ?>
											<?php foreach ($sistem->data() as $group) { 
												$selected = ($user->group === $group->id) ? 'selected' : '';?>
												<option <?php echo $selected; ?> value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
											<?php } ?>
										<?php else : ?>
											<option value="">No hay grupo registrados</option>
										<?php endif; ?>
									</select>
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
						<?php if (Session::exists('users')) {
							handlerMessage(Session::flash('users'), 'success');
						} ?>
						<h2>Gestionar usuarios <a href="?new=true" class="btn btn-primary">Nuevo Usuario</a></h2>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Cedula</th>
									<th>Nombre</th>
									<th>Apellido</th>
									<th>Telefono</th>
									<th>Correo electronico</th>
									<th>Tipo</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php $sistem = new Sistem('users');
								if (!$sistem->get(array('id', '>', 0))) : ?>
									<tr>
										<td colspan="7"><h3><center>No hay registro</center></h3></td>
									</tr>
								<?php else :
									foreach ($sistem->data() as $user) { ?>
										<tr>
											<td><?php echo $user->ci; ?></td>
											<td><?php echo $user->firstName; ?></td>
											<td><?php echo $user->lastName; ?></td>
											<td><?php echo $user->phone; ?></td>
											<td><?php echo $user->email; ?></td>
											<td><?php echo getData($user->group, 'groups', 'name'); ?></td>
											<td><a href="?edit=<?php echo $user->id; ?>">editar</a><td>
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