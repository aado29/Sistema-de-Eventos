<?php 
/**
 * Description of File
 *
 * @author Alberto Diaz
 */
class File { 	

	private $_file = '',
			$_fileName,
			$_destination = './uploads/';

	public function __construct($file) {
		$this->_file = $file;
		$this->_fileName = Token::generate().'.jpg';
	}

	public function upload() {
		$destinationPath = $this->_destination.$this->_fileName;
		if (move_uploaded_file($this->_file['tmp_name'], $destinationPath)) {
			return $destinationPath;
		}
	}
 
}