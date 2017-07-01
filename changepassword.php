<?php
require_once 'core/init.php';
$user = new User();

if(!$user->isLoggedIn()){
	Redirect::to('index.php');
}
if (Input::exists()) {
	if(Token::check(Input::get('token'))){
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
		   'password_current' => array(
			   'required' => true,
			   'min' => 6
		   ),
			'password_new' => array(
				'required' => true,
				'min' => 6
			),
			'password_new_again' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'password_new'
			)
		));
		if($validation->passed()){
			if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password){
				echo 'Your current password is wrong';
			}else{
				$salt = Hash::salt(32);
				$user->update(array(
					'password' => Hash::make(Input::get('password_new'), $salt),
					'salt' => $salt
				));
				Session::flash('home', 'Your password has been changed!');
				Redirect::to('index.php');
			}
		}else{
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
				<div class="col-sm-offset-3 col-sm-6">
				<h2>Recuperar Contraseña</h2>
				<form action="" method="post">
					<div class="form-group">
						<label for="password_current">Contraseña actual</label>
						<input class="form-control" type="password" name="password_current" id="password_current">
					</div>
					<div class="form-group">
						<label for="password_new">Nueva contraseña</label>
						<input class="form-control" type="password" name="password_new" id="password_new">
					</div>
					<div class="form-group">
						<label for="password_new_again">Repita su nueva contraseña</label>
						<input class="form-control" type="password" name="password_new_again" id="password_new_again">
					</div>
					<input type="hidden" name="token" value="<?php echo Token::generate();?>">
					<input class="btn btn-primary" type="submit" value="Change">
				</form>
			</div>
		</div>
	</div>
</div>
<?php gettemplate('footer');