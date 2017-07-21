<?php 
/**
* 
*/
class Relation {
	
	private $_db,
			$_data,
			$_type;

	public function __construct($type = null) {
		if (!is_null($type)) {
			$this->_type = $type;
		} else {
			$this->_type = 'events';
		}
		$this->_db = DB::getInstance();
	}

	public function update(array $arrIds, $ownerId, $type){

		if ($this->_type == 'events')
			$this->get(array('id_event', '=', $ownerId));
		else 
			$this->get(array('id_owner', '=', $ownerId));

		$results = $this->_data;
		foreach ($results as $result) {
			$types = ($this->_type == 'events') ? $result->partaker: $result->owner_type;
			if ($types == $type) {
				try {
					$this->delete($result->id);
				} catch (Exception $e) {
					throw new Exception($e->getMessage());
				}
			}
		}
		foreach ($arrIds as $id) {
			if ($this->_type == 'events') {
				$fields = array(
					'id_event' => $ownerId,
					'id_partaker' => $id,
					'partaker' => $type
				);
			} else {
				$fields = array(
					'id_equipment' => $id,
					'id_owner' => $ownerId,
					'owner_type' => $type
				);
			}
			if (!$this->_db->insert($this->_type.'_relations', $fields)) {
				throw new Exception("There was a problem creating in {$this->_type}_relations.");
			}
		}
	}

	public function create(array $arrIds, $ownerId, $type) {
		foreach ($arrIds as $id) {
			if ($this->_type == 'events') {
				$fields = array(
					'id_event' => $ownerId,
					'id_partaker' => $id,
					'partaker' => $type
				);
			} else {
				$fields = array(
					'id_equipment' => $id,
					'id_owner' => $ownerId,
					'owner_type' => $type
				);
			}
			if (!$this->_db->insert($this->_type.'_relations', $fields)) {
				throw new Exception("There was a problem creating in {$this->_type}_relations.");
			}
		}
	}

	public function delete($id = null) {
		if (!is_null($id)) {
			if (!$this->_db->delete($this->_type.'_relations', array('id', '=', $id))) {
				throw new Exception("There was a problem deleting in {$this->_type}_relations.");
			}
		} else {
			return false;
		}
	}

	public function get($arg = null) {
		if (!is_null($arg)) {
			$data = $this->_db->get($this->_type.'_relations', $arg);
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