<?php

/**
 * Description of Sistem
 *
 * @author Alberto Diaz
 */
class Sistem {

    private $_db,
            $_data
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
            throw new Exception("There was a problem updating in {$rule_value}.");
        }
    }

    public function create($fields = array()) {
        if (!is_null($table)) { 
            if (!$this->_db->insert($this->_type, $fields)) {
                throw new Exception("There was a problem creating in {$rule_value}.");
            }
        } else {
            return false;
        }
    }

    public function delete($id = null) {
        if (!is_null($id)) {
            if (!$this->_db->insert($this->_type, $fields)) {
                throw new Exception("There was a problem creating in {$rule_value}.");
            }
        } else {
            return false;
        }
    }

    public function get($arg = null {
        if (!is_null($arg)) {
            $data = $this->_db->get($this->_type, $arg);
            if ($data->count()) {
                $this->_data = $data->first();
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
