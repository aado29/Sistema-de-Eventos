<?php
	require_once 'core/init.php';

	$user = new User();
	if(!$user->isLoggedIn()) {
		Redirect::to('login.php');
	}
	if (Input::exists()) {
		if (Token::check(Input::get('token'))) {
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'date' => array(
					'date_limit' => date('Y-m-d'),
					'display' => 'Día'
				),
				'from' => array(
					'date_limit' => Input::get('to'),
					'display' => 'Día de inicio'
				),
				'to' => array(
					'date_limit' => date('Y-m-d'),
					'display' => 'Día de fin'
				)
			));
			if ($validation->passed()) {
				// if ($user->hasPermission('admin')) {
					$choice = Input::get('choice');
					if ($choice == 'date') {
						$data = getReportByDate(Input::get('date'));
					}
					if ($choice == 'range') {
						$data = getReportByRangeDate(Input::get('from'), Input::get('to'));
					}
			} else {
				$errors = $validation->errors();
			}
		}
	}
	gettemplate('header'); 
?>
<div class="container">
	<div class="row">
		<div class="jumbotron">
			<div class="row">
				<div class="col-sm-offset-3 col-sm-6 noPrint">
					<?php if (!empty($error)) {
						handlerMessage($error, 'danger');
					} ?>
					<h2>Reportes</h2>
					<form action="" method="post">
						<div class="form-group">
							<label for="inputBy">Realiazar por:</label>
							<select name="choice" class="form-control form-control-lg" id="report-type">
								<option value="date">Evento (Día)</option>
								<option value="range">Evento (Rango)</option>
							</select>
						</div>
						<div id="report-day-input">
							<div class="form-group">
								<label for="inputDate">Día</label>
								<input name="date" type="date" id="inputDate" class="date-picker form-control" placeholder="Ej: <?php echo date('Y-m-d') ?>" <?php if(!empty(Input::get('date'))) echo 'value="'.Input::get('date').'"' ?>>
							</div>
						</div>

						<div id="report-range-input" >
							<div class="form-group">
								<label for="inputFrom">Rango: De </label>
								<input name="from" type="date" id="inputFrom" class="date-picker form-control" placeholder="Ej: <?php echo date('Y-m-d') ?>" <?php if(!empty(Input::get('from'))) echo 'value="'.Input::get('from').'"' ?>>
							</div>
							<div class="form-group">
								<label for="inputTo">Hasta </label>
								<input name="to" type="date" id="inputTo" class="date-picker form-control" placeholder="Ej: <?php echo date('Y-m-d') ?>" <?php if(!empty(Input::get('to'))) echo 'value="'.Input::get('to').'"' ?>>
							</div>
						</div>
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
						<input type="submit" name="create" class="btn btn-primary" value="Registrar">
						<br />
						<br />
					</form>
				</div>
				<div class="col-sm-12">
					<?php if (Input::exists() && empty($errors)) { ?>
						<?php if (!empty($data)) { ?>
							<div class="table-responsive">
								<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Identificacion</th>
											<th>Nombre</th>
											<th>Lugar</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($data as $value) { ?>
										<tr>
											<td><?php echo $value->id;?></td>
											<td><?php echo $value->name;?></td>
											<td><?php echo $value->place;?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<input class="btn btn-md btn-success btn-block noPrint" type="button" onClick="window.print()" value="Imprimir">
							</div>

					<?php } else {
							echo '<center><p>no se encontraron resultados</p></center>';
						} 
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php gettemplate('footer');