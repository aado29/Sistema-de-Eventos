<?php 
	require_once 'core/init.php';
	$user = new User();
	if($user->isLoggedIn()){
		Redirect::to('index.php');
	}
	if(Input::exists()){
		if(Token::check(Input::get('token'))){
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username' => array(
					'required' => true,
					'display' => 'Nombre de usuario'
				),
				'password' => array(
					'required' => true,
					'display' => 'Contraseña'
				)
			));
			if($validation->passed()){

				$user = new User();
				$remember = (Input::get('remember')) === 'on' ? true : false;
				
				$login = $user->login(Input::get('username'), Input::get('password'), $remember);
				
				if($login){
					Redirect::to('index.php');
				}else{
					$error = 'Inicio de sesión fallido!';
				}
			}  else {
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
				<?php if (!empty($error)) {
					handlerMessage($error, 'danger');
				} ?>
				<?php if (Session::exists('login')) {
					handlerMessage(Session::flash('login'), 'success');
				} ?>
				<div class="col-sm-offset-3 col-sm-6">
					<h2>Iniciar sesión</h2>
					<form action="" method="post">
						<div class="form-group">
							<label for="username">Nombre de usuario</label>
							<input class="form-control" type="text" name="username" id="username" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="password">Contraseña</label>
							<input class="form-control" type="password" name="password" id="password" autocomplete="off">
						</div>
						<!-- <div class="form-group">
							<label for="remember">
								<input type="checkbox" name="remember" id="remember"> Recordar mi sesión
							</label>
						</div> -->
						<input type="hidden" name="token" value="<?php echo Token::generate();?>">
						<input class="btn btn-primary" type="submit" value="Iniciar Sesión">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
gettemplate('footer'); ?>