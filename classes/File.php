<?php 
/**
 * Description of File
 *
 * @author Alberto Diaz
 */
class File { 	

	private $_error = array(),
			$_passed = false,
			$_destination = './uploads/',
			$_fileName = '',
			$_maxSize = '5242880', // 5mb
			$_allowedExtensions = array('image/jpeg','image/png','image/gif'),
			$_printError = TRUE,
			$_file = null,
			$_path = null;

	public function __construct($file) {
		$this->_file = $file;
		$this->_fileName = Token::generate().'.jpg';
	}

	public function setDestination($newDestination) {
		$this->_destination = $newDestination;
	}

	public function setFileName($newFileName) {
		$this->_fileName = $newFileName;
	}

	public function setPrintError($newValue) {
		$this->_printError = $newValue;
	}

	public function setMaxSize($newSize) {
		$this->_maxSize = $newSize;
	}

	public function setAllowedExtensions($newExtensions) {
		if (is_array($newExtensions)) {
			$this->_allowedExtensions = $newExtensions;
		} else {
			$this->_allowedExtensions = array($newExtensions);
		}
	}

	public function upload() {
		$this->validate($this->_file);
		if (count($this->_errors)) {
			$destinationPath = $this->_destination.$this->_fileName;
			if (move_uploaded_file($this->_file['tmp_name'], $destinationPath)) {
				$this->_path = $destinationPath;
				$this->_passed = true;
			} else {
				$this->addError("La imagen no se pudo cargar!");
			}
		}
		return $this;
	}

	public function delete() {
		if (file_exists($this->_file)) {
			if (unlink($this->_file))
				$this->_passed = true;
			else
				$this->addError("La imagen no se pudo eliminar.");
		} else {
			$this->addError("Archivo no encontrado! No se pudo eliminar: {$this->_file}.");
		}
	}

	public function validate() {

		//check file exist
		if (!empty($this->_file['name'])) {
			$this->addError("Archivo no encontrado.");
		}

		//check allowed extensions
		if (!in_array($this->getExtension($this->_file), $this->_allowedExtensions)) {
			$this->addError("La extencion de la imagen no es válida.");
		}

		//check file size
		if ($this->_file['size'] > $this->_maxSize) {
			$this->addError("Limite de tamaño exedido. Limite: {$this->_maxSize} Mb.");
		}
	}

	private function getExtension() {
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$ext = finfo_file($finfo, $this->_file['tmp_name']);
		finfo_close($finfo);
		return $ext;
	}
	
	private function addError($error){
		$this->_errors[] = $error;
	}

	public function getPath(){
		return $this->_path;
	}

	public function errors(){
		return $this->_errors;
	}

	public function passed(){
		return $this->_passed;
	}
 
}