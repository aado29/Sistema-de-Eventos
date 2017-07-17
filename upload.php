<?php
require_once 'core/init.php';
if (Input::exists()) {

	if (Token::check(Input::get('token'))) {

		$file = new File(Input::file('photo'));
		$file->upload();

		if ($file->passed()) {
			die($file->getPath());
		}
		else {
			foreach ($file->errors() as $error) {
				echo $error.'</br>';
			}
			die(':(');
		}
	}
}
gettemplate('header');
?>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="photo">Foto</label>
		<input class="form-control" type="file" name="photo" id="photo">
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" name="create" class="btn btn-primary" value="Registrar">
</form>
<?php gettemplate('footer');