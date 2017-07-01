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
				'plate' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Placa'
				),
				'brand' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Marca'
				),
				'model' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Modelo'
				),
				'color' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Color'
				),
				'year' => array(
					'required' => true,
					'min' => 2,
					'max' => 4,
					'display' => 'Año'
				),
				'bodywork' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Carrocería'
				),
				'motor' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Motor'
				),
				'chassis' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Chasis'
				),
				'state' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Estado'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('vehicle');
				
				try{
					
					$sistem->create(array(
						'plate' => esacape(Input::get('plate')),
						'brand' => esacape(Input::get('brand')),
						'model' => esacape(Input::get('model')),
						'color' => esacape(Input::get('color')),
						'year' => esacape(Input::get('year')),
						'bodywork' => esacape(Input::get('bodywork')),
						'motor' => esacape(Input::get('motor')),
						'chassis' => esacape(Input::get('chassis')),
						'state' => esacape(Input::get('state'))
					));
					
					Session::flash('home', 'El Vehículo ha sido registrado con exito!');
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
			<h2>Vehículos</h2>
			<form action="" method="post">
				<div class="form-group">
					<label for="plate">Placa:</label>
					<input name="plate" type="text" class="form-control" id="plate">
				</div>
				<div class="form-group">
					<label for="brand">Marca:</label>
					<input name="brand" type="text" class="form-control" id="brand">
				</div>
				<div class="form-group">
					<label for="model">Modelo:</label>
					<input name="model" type="text" class="form-control" id="model">
				</div>
				<div class="form-group">
					<label for="color">Color:</label>
					<input name="color" type="text" class="form-control" id="color">
				</div>
				<div class="form-group">
					<label for="year">Año:</label>
					<input name="year" type="number" class="form-control" id="year">
				</div>
				<div class="form-group">
					<label for="bodywork">Numero de carrocería:</label>
					<input name="bodywork" type="number" class="form-control" id="bodywork">
				</div>
				<div class="form-group">
					<label for="motor">Numero de Motor:</label>
					<input name="motor" type="number" class="form-control" id="motor">
				</div>
				<div class="form-group">
					<label for="chassis">Chasis:</label>
					<input name="chassis" type="number" class="form-control" id="chassis">
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
