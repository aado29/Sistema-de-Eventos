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
					'display' => 'Correo electrónico'
				),
				'membersNumber' => array(
					'required' => TRUE,
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
				$sistem = new Sistem('group');
				
				try{
					$sistem->create(array(
						'name' => esacape(Input::get('name')),
						'type' => esacape(Input::get('type')),
						'description' => esacape(Input::get('description')),
						'phone' => esacape(Input::get('phone')),
						'address' => esacape(Input::get('address')),
						'email' => esacape(Input::get('email')),
						'members_number' => esacape(Input::get('membersNumber')),
						'state' => esacape(Input::get('state'))
					));
					
					Session::flash('home', 'El grupo ha sido registrado con exito!');
					Redirect::to('index.php');
					
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
		<div class="col-sm-offset-4 col-sm-4">
			<?php if (!empty($error)) {
				handlerMessage($error, 'danger');
			} ?>
			<h2>Grupo de Rescate</h2>
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
					<input name="phone" type="number" class="form-control" id="phone">
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
	</div>
</div>
<?php gettemplate('footer');