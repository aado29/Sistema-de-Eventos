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
				'eventType' => array(
					'required' => TRUE,
					'display' => 'Tipo de evento'
				),
				'startDate' => array(
					'required' => TRUE,
					'display' => 'Fecha de inicio'
				),
				'dueDate' => array(
					'required' => TRUE,
					'display' => 'Fecha de fin'
				),
				'place' => array(
					'required' => TRUE,
					'min' => 2,
					'max' => 50,
					'display' => 'Lugar'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('events');
				
				try{
					
					$sistem->create(array(
						'eventType' => esacape(Input::get('eventType')),
						'startDate' => esacape(Input::get('startDate')),
						'dueDate' => esacape(Input::get('dueDate')),
						'place' => esacape(Input::get('place')),
						'id_group' => esacape(Input::get('group')),
						'id_voluntary' => esacape(Input::get('voluntary')),
						'id_team' => esacape(Input::get('team'))
					));
					
					Session::flash('home', 'El evento ha sido registrado con exito!');
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
			<h2>Gestionar Eventos</h2>
			<?php if (!empty($error)) {
				handlerMessage($error, 'danger');
			} ?>			<form action="" method="post">
				<div class="form-group">
					<label for="eventType">Tipo de Evento:</label>
					<input name="eventType" type="text" class="form-control" id="eventType">
				</div>
				<div class="form-group">
					<label for="startDate">Fecha de inicio:</label>
					<input name="startDate" type="date" class="form-control" id="startDate">
				</div>
				<div class="form-group">
					<label for="dueDate">Fecha de fin:</label>
					<input name="dueDate" type="date" class="form-control" id="dueDate">
				</div>
				<div class="form-group">
					<label for="place">Lugar:</label>
					<input name="place" type="text" class="form-control" id="place">
				</div>
				<div class="form-group">
					<label for="group">Grupo:</label>
					<select name="group" class="form-control" id="group">
						<option>Grupo 1</option>
					</select>
				</div>
				<div class="form-group">
					<label for="voluntary">Voluntario:</label>
					<select name="voluntary" class="form-control" id="voluntary">
						<option>Voluntario 1</option>
					</select>
				</div>
				<div class="form-group">
					<label for="team">Equipo:</label>
					<select name="team" class="form-control" id="team">
						<option>Equipo 1</option>
					</select>
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate();?>">
				<input type="submit" class="btn btn-primary" value="Registrar"/>
			</form>
		</div>
	</div>
</div>
<?php gettemplate('footer');
