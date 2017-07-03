<?php
require_once 'core/init.php';
if (Input::exists()) {

	if (Token::check(Input::get('token'))) {
		
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
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

		if ($validation->passed()) {
			$user = new User();
			
			$salt = escape(Hash::salt(32));
			try{
				
				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'firstName' => Input::get('firstName'),
					'lastName' => Input::get('lastName'),
					'email' => Input::get('email'),
					'joined' => date('Y-m-d H:i:s'),
					'group' => 1
				));
				
				Session::flash('login', 'El usuario ha sido registrado con exito!');
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
		<div class="jumbotron">
			<div class="row">
				<div class="col-sm-offset-3 col-sm-6">
					<?php if (!empty($error)) {
						handlerMessage($error, 'danger');
					} ?>
					<h2>Registro de usuario</h2>
					<form action="" method="post">
						<div class="form-group">
							<label for="username">Nombre de usuario</label>
							<input class="form-control" type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">    
						</div>
						<div class="form-group">
							<label for="firstName">Nombre</label>
							<input class="form-control" type="text" name="firstName" id="firstName" value="<?php echo escape(Input::get('firstName')); ?>">    
						</div>
						<div class="form-group">
							<label for="lastName">Apellido</label>
							<input class="form-control" type="text" name="lastName" id="lastName" value="<?php echo escape(Input::get('lastName')); ?>">    
						</div>
						<div class="form-group">
							<label for="email">Correo Electrónico</label>
							<input class="form-control" type="email" name="email" id="email" value="<?php echo escape(Input::get('email')); ?>">    
						</div>
						<div class="form-group">
							<label for="password">Contraseña</label>
							<input class="form-control" type="password" name="password" id="password">    
						</div> 
						<div class="form-group">
							<label for="password_again">Repita su contraseña</label>
							<input class="form-control" type="password" name="password_again" id="password_again">    
						</div>
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
						<input class="btn btn-primary" type="submit" value="Resgistrar">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php gettemplate('footer');