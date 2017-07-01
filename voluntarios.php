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
				'ci' => array(
					'required' => true,
					'min' => 7,
					'max' => 8,
					'display' => 'Cedula de indentidad'
				),
				'firstName' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Nombre'
				),
				'lastName' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Apellido'
				),
				'address' => array(
					'required' => true,
					'min' => 2,
					'max' => 100,
					'display' => 'Dirección'
				),
				'phone' => array(
					'required' => true,
					'min' => 2,
					'max' => 11,
					'display' => 'Telefono'
				),
				'email' => array(
					'required' => true,
					'min' => 2,
					'max' => 50,
					'display' => 'Correo electónico'
				),
				'sizeShirt' => array(
					'required' => true,
					'display' => 'Talla de franela'
				),
				'sizePants' => array(
					'required' => true,
					'display' => 'Talla de pantalones'
				),
				'sizeShoes' => array(
					'required' => true,
					'display' => 'Talla de zapatos'
				),
				'position' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Cargo'
				),
				'profession' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Profeción'
				),
				'speciality' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Especialidad'
				),
				'employment' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Ocupación'
				),
				'group' => array(
					'required' => true,
					'display' => 'Equipo'
				),
				'vehicle' => array(
					'required' => true,
					'display' => 'Vehículo'
				),
				'type' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Tipo'
				),
				'state' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'display' => 'Estado'
				)
			));

			if ($validation->passed()) {
				$sistem = new Sistem('volunteers');
				
				try{
					
					$sistem->create(array(
						'ci' => esacape(Input::get('ci')),
						'firstName' => esacape(Input::get('firstName')),
						'lastName' => esacape(Input::get('lastName')),
						'address' => esacape(Input::get('address')),
						'phone' => esacape(Input::get('phone')),
						'email' => esacape(Input::get('email')),
						'sizeShirt' => esacape(Input::get('sizeShirt')),
						'sizePants' => esacape(Input::get('sizePants')),
						'sizeShoes' => esacape(Input::get('sizeShoes')),
						'position' => esacape(Input::get('position')),
						'profession' => esacape(Input::get('profession')),
						'speciality' => esacape(Input::get('speciality')),
						'employment' => esacape(Input::get('employment')),
						'group' => esacape(Input::get('group')),
						'vehicle' => esacape(Input::get('vehicle')),
						'type' => esacape(Input::get('type')),
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
			<h2>Voluntarios</h2>
			<form action="" method="post">
				<div class="form-group">
					<label for="ci">Cedula:</label>
					<input name="ci" type="number" class="form-control" id="ci">
				</div>
				<div class="form-group">
					<label for="firstName">Nombre:</label>
					<input name="firstName" type="text" class="form-control" id="firstName">
				</div>
				<div class="form-group">
					<label for="lastName">Apellido:</label>
					<input name="lastName" type="text" class="form-control" id="lastName">
				</div>
				<div class="form-group">
					<label for="address">Dirección:</label>
					<input name="address" type="text" class="form-control" id="address">
				</div>
				<div class="form-group">
					<label for="phone">Telefono:</label>
					<input name="phone" type="number" class="form-control" id="phone">
				</div>
				<div class="form-group">
					<label for="email">Correo electónico:</label>
					<input name="email" type="email" class="form-control" id="email">
				</div>
				<div class="form-group">
					<label for="sizeShirt">Talla de camisa:</label>
					<select name="sizeShirt" class="form-control" id="sizeShirt">
						<option>SS</option>
						<option>S</option>
						<option>M</option>
						<option>L</option>
						<option>XL</option>
					</select>
				</div>
				<div class="form-group">
					<label for="sizePants">Talla de pantalon:</label>
					<select name="sizePants" class="form-control" id="sizePants">
						<option>30</option>
						<option>32</option>
						<option>34</option>
						<option>36</option>
						<option>38</option>
						<option>40</option>
					</select>
				</div>
				<div class="form-group">
					<label for="sizeShoes">Talla de zapatos:</label>
					<select name="sizeShoes" class="form-control" id="sizeShoes">
						<option>34</option>
						<option>35</option>
						<option>36</option>
						<option>37</option>
						<option>38</option>
						<option>39</option>
						<option>40</option>
						<option>41</option>
						<option>42</option>
						<option>43</option>
						<option>44</option>
					</select>
				</div>
				<div class="form-group">
					<label for="position">Cargo:</label>
					<input name="position" type="text" class="form-control" id="position">
				</div>
				<div class="form-group">
					<label for="profession">Profeción:</label>
					<input name="profession" type="text" class="form-control" id="profession">
				</div>
				<div class="form-group">
					<label for="speciality">Especialidad:</label>
					<input name="speciality" type="text" class="form-control" id="speciality">
				</div>
				<div class="form-group">
					<label for="employment">Ocupación:</label>
					<input name="employment" type="text" class="form-control" id="employment">
				</div>
				<div class="form-group">
					<label for="group">Equipo:</label>
					<select name="group" class="form-control" id="group">
						<option>Equipo 1</option>
					</select>
				</div>
				<div class="form-group">
					<label for="vehicle">Vehículo:</label>
					<select name="vehicle" class="form-control" id="vehicle">
						<option>Vehículo 1</option>
					</select>
				</div>
				<div class="form-group">
					<label for="type">Tipo:</label>
					<input name="type" type="text" class="form-control" id="type">
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