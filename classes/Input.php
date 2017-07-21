<?php
/**
 * Description of Input
 *
 * @author Alberto Diaz
 */
class Input {

	public static function exists($type = 'post'){
		switch ($type) {
			case 'post':
				return (!empty($_POST)) ? TRUE : FALSE;
				break;
			case 'get' :
				return (!empty($_GET) ? TRUE : FALSE);
				break;
			default:
				return FALSE;
				break;
		}
	}
	
	public static function get($item){
		if(isset ($_GET[$item])){
			return $_GET[$item];
		}
		else if(isset($_POST[$item])){
			return $_POST[$item];
		}
		return '';
	}

	public static function file($item) {
		if(isset ($_FILES[$item])){
			return $_FILES[$item];
		}
		return array();
	}

	public static function build($label, $name, $value = '', $type = 'text'){
		$output = '';
		$output .= '<div class="form-group">';
			$output .= '<label for="'. $name .'">'. $label .':</label>';
			if ($type == 'textarea') {
				$output .= '<textarea rows="4" name="'. $name .'" class="form-control" id="'. $name .'">'. $value .'</textarea>';
			} else {
				$output .= '<input name="'. $name .'" type="'. $type .'" class="form-control" id="'. $name .'" value="'. $value .'">';
			}
		$output .= '</div>';
		echo $output;
	}

	public static function buildState($currentState = null) {
		$output = '';
		$output .= '<div class="form-group">';
			$output .= '<label for="state">Estado:</label>';
			$output .= '<select class="form-control" name="state" id="state">';
				if (!is_null($currentState)) {
					if ($currentState == 1) {
						$output .= '<option value="1" selected>Activo</option>';
						$output .= '<option value="0">Inactivo</option>';
					}
					if ($currentState == 0) {
						$output .= '<option value="1">Activo</option>';
						$output .= '<option value="0" selected>Inactivo</option>';
					}
				} else {
					$output .= '<option value="1">Activo</option>';
					$output .= '<option value="0">Inactivo</option>';
				}
			$output .= '</select>';
		$output .= '</div>';
		echo $output;
	}
}
