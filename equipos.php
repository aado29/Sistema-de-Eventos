<?php
	require_once 'core/init.php';
	$user = new User();

	if(!$user->isLoggedIn()){
		Redirect::to('index.php');
	}

	if (Input::exists()) {

		if (Token::check(Input::get('token'))) {

			if (Input::get('delete')) {
				try {
					$sistem = new Sistem('teams');
					$sistem->delete(escape(Input::get('id')));
				
					Session::flash('teams', 'El equipo ha sido eliminado con exito!');
					Redirect::to('equipos.php');
				} catch (Exception $e) {
					$error = $e->getMessage();
				}
			}
			
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'name' => array(
					'required' => TRUE,
					'min' => 3,
					'max' => 50,
					'display' => 'Nombre'
				),
				'description' => array(
					'required' => TRUE,
					'min' => 2,
					'max' => 100,
					'display' => 'Descripción'
				),
				'state' => array(
					'required' => TRUE,
					'min' => 2,
					'max' => 50,
					'display' => 'Estado'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('teams');
				
				try{
					if (Input::get('create')) {
						$sistem->create(array(
							'name' => escape(Input::get('name')),
							'description' => escape(Input::get('description')),
							'state' => escape(Input::get('state'))
						));
						
						Session::flash('teams', 'El equipo ha sido registrado con exito!');
					}

					if (Input::get('edit')) {
						$sistem->update(array(
							'id' => escape(Input::get('id')),
							'name' => escape(Input::get('name')),
							'description' => escape(Input::get('description')),
							'state' => escape(Input::get('state'))
						), escape(Input::get('id')));

						Session::flash('teams', 'El equipo ha sido editado con exito!');
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
						<h2>Equipos <a href="?" class="btn btn-primary">Ver Equipos</a></h2>
						<form action="" method="post">
							<div class="form-group">
								<label for="name">Name:</label>
								<input name="name" type="text" class="form-control" id="name">
							</div>
							<div class="form-group">
								<label for="description">Description:</label>
								<input name="description" type="text" class="form-control" id="description">
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
						<?php $sistem = new Sistem('teams');
						if ($sistem->get(array('id', '=', Input::get('edit')))) : 
							$team = $sistem->data()[0]; ?>
							<h2>Gestionar Eventos</h2>
							<form action="" method="post">
								<div class="form-group">
									<label for="name">Name:</label>
									<input name="name" type="text" class="form-control" id="name" value="<?php echo $team->name; ?>">
								</div>
								<div class="form-group">
									<label for="description">Description:</label>
									<input name="description" type="text" class="form-control" id="description" value="<?php echo $team->description; ?>">
								</div>
								<div class="form-group">
									<label for="state">Estado:</label>
									<input name="state" type="text" class="form-control" id="state" value="<?php echo $team->state; ?>">
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
						<?php if (Session::exists('teams')) {
							handlerMessage(Session::flash('teams'), 'success');
						} ?>
						<h2>Equipos <a href="?new=true" class="btn btn-primary">Nuevo Equipo</a></h2>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Descripción</th>
									<th>Estado</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php $sistem = new Sistem('teams');
								if (!$sistem->get(array('id', '>', 0))) : ?>
									<tr>
										<td colspan="4"><h3><center>No hay registro</center></h3></td>
									</tr>
								<?php else :
									foreach ($sistem->data() as $team) { ?>
										<tr>
											<td><?php echo $team->name; ?></td>
											<td><?php echo $team->description; ?></td>
											<td><?php echo $team->state; ?></td>
											<td><a href="?edit=<?php echo $team->id; ?>">editar</a><td>
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