<?php
/**
 * Description of Validation
 *
 * @author Alberto Diaz
 */
class Validate {

	private $_passed = false, 
			$_errors = array(),
			$_db = null;
	public function __construct() {
		$this->_db = DB::getInstance();
	}
	public function check($source, $items = array()){
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				
				$value = trim($source[$item]);
				$item = escape($item);
				$displayName = $item;
				if(!empty($items[$item]['display'])) {
					$displayName = $items[$item]['display'];
				}
				
				if(($rule === 'required' && empty($value)) || ($rule === 'array' && count($value))){
					$this->addError("{$displayName} es obligatorio");
				}  else if(!empty ($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$displayName} debe tener un minimo de {$rule_value} caracteres.");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$displayName} debe tener un maximo de {$rule_value} caracteres.");
							}
							break;
						case 'matches':
							if($value != $source[$rule_value]){
								$display = $rule_value;
								if(!empty($items[$rule_value]['display'])) {
									$display = $items[$rule_value]['display'];
								}
								$this->addError("{$display} debe ser igual a {$displayName}");
							}
							break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value ));
							if($check->count()){
								$this->addError("{$displayName} ya existe.");
							}
							break;
						case 'uniqueById':
							$sql = "SELECT * FROM {$rule_value['table']} WHERE {$item} = '{$value}' AND id != {$rule_value['id']}";
                            $check = $this->_db->query($sql);
                            if($check->count()){
                                $this->addError("{$displayName} ya se ecuentra registrado.");
                            }
							break;
						case 'date_limit':
							if(strtotime($value) > strtotime($rule_value))
								$this->addError("Hay un error en {$displayName}.");
							break;
						case 'name':
							if ($rule_value)
								if (!preg_match("/^[a-z ñáéíóú ,.'-]+$/i", $value))
									$this->addError("El {$displayName} es invalido.");
							break;
						case 'numeric':
							if(!is_numeric($value)){
								$this->addError("{$displayName} debe ser en numeros.");
							}
							break;
						case 'ageMin':
							if ($rule_value) {
								$diffAge = intval((strtotime("now") - strtotime($value)));
								if (($diffAge / 31536000) < 18)
									$this->addError("{$displayName} debe se mayor a 18 años.");
							}
							break;
						case 'ageMax':
							if ($rule_value) {
								$diffAge = intval((strtotime("now") - strtotime($value)));
								if (($diffAge / 31536000) >= 80)
									$this->addError("{$displayName} debe se menor a 80 años.");
							}
							break;
						case 'positive':
							if ($rule_value) {
								if ($value < 0)
									$this->addError("{$displayName} debe ser un numero positivo.");
							}
							break;
					}
				}
			}
		}
		if(empty($this->_errors)){
			$this->_passed = true;
		}
		return $this;
	}
	
	private function addError($error){
		$this->_errors[] = $error;
	}
	
	public function errors(){
		return $this->_errors;
	}
	
	public function passed(){
		return $this->_passed;
	}
}
