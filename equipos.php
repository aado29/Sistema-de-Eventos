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
				$sistem = new Sistem('team');
				
				try{
					
					$sistem->create(array(
						'name' => esacape(Input::get('name')),
						'description' => esacape(Input::get('description')),
						'state' => esacape(Input::get('state'))
					));
					
					Session::flash('home', 'El equipo ha sido registrado con exito!');
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
			<h2>Equipos</h2>
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
				<input type="submit" class="btn btn-primary" value="Registrar"/>
			</form>
		</div>
	</div>
</div>
<?php gettemplate('footer');