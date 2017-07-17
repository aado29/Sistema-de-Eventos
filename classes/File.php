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
			$_maxSize = '1048576',
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
		if (empty($this->_errors)) {
			$destinationPath = $this->_destination.$this->_fileName;
			if (move_uploaded_file($this->_file['tmp_name'], $destinationPath)) {
				$this->_path = $destinationPath;
				$this->_passed = true;
			} else {
				$this->addError("File couldn't be uploaded!");
			}
		}
		return $this;
	}

	public function delete() {
		if (file_exists($this->_file)) {
			if (unlink($this->_file))
				$this->_passed = true;
			else
				$this->addError("File couldn't deleted!");
		} else {
			$this->addError("File not found! It couldn't deleted: {$this->_file}.");
		}
	}

	public function validate() {

		//check file exist
		if (empty($this->_file['name'])) {
			$this->addError("No file found.");
		}

		//check allowed extensions
		if (!in_array($this->getExtension($this->_file), $this->_allowedExtensions)) {
			$this->addError("Extension is not allowed.");
		}

		//check file size
		if ($this->_file['size'] > $this->_maxSize) {
			$this->addError("Max File Size Exceeded. Limit: {$this->_maxSize} bytes.");
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