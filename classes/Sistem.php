<?php

/**
 * Description of Sistem
 *
 * @author Alberto Diaz
 */
class Sistem {

	private $_db,
			$_data,
			$_type;

	public function __construct($type = null) {
		if (!is_null($type)) {
			$this->_type = $type;
		} else {
			$this->_type = 'team';
		}
		$this->_db = DB::getInstance();
	}

	public function update($fields = array(), $id = null){     
		if(!$this->_db->update($this->_type, $id, $fields)){
		   throw new Exception("There was a problem updating in {$this->_type}.");
		}
	}

	public function create($fields = array()) {
		if (!$this->_db->insert($this->_type, $fields)) {
			throw new Exception("There was a problem creating in {$this->_type}.");
		}
	}

	public function delete($id = null) {
		if (!is_null($id)) {
			if (!$this->_db->delete($this->_type, array('id', '=', $id))) {
				throw new Exception("There was a problem deleting in {$this->_type}.");
			}
		} else {
			return false;
		}
	}

	public function getByDate($date = null) {
		if (!is_null($date)) {
			$sql = "SELECT * from $this->_type WHERE startDate = '{$date}'";
			$data = $this->_db->query($sql);
			if ($data->count())
				return $data->results();
		}
		return false;
	}

	public function getBetweenDates($date = null, $_date = null) {
		if (is_null($date) || is_null($_date)) {
			return false;
		} else {
			$sql = "SELECT * from $this->_type WHERE startDate BETWEEN '{$date}' AND '{$_date}'";
			$data = $this->_db->query($sql);
			if ($data->count())
				return $data->results();
		}
		return false;
	}

	public function getById($id = null) {
		if (!is_null($id)) {
			$data = $this->_db->get($this->_type, array('id', '=', $id));
			if ($data->count())
				return $data->first();
			else
				return false;
		}
		return false;
	}

	public function get($arg = null) {
		if (!is_null($arg)) {
			$data = $this->_db->get($this->_type, $arg);
			if ($data->count()) {
				$this->_data = $data->results();
				return true;
			}
		} else {
			return false;
		}
	}

	public function data() {
		return $this->_data;
	}

}
