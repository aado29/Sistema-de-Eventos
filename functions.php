<?php

	function escape($string){
		return htmlentities($string, ENT_QUOTES, 'UTF-8');
	}

	function gettemplate($template = null) {
		if (!is_null($template)) {
			include 'templates/'.$template.'.php';
			return true;
		} else {
			return false;
		}
	}

	function handlerMessage($messages = array(), $type = 'success') {
		$output = '';
		$output .= '<div class="alert alert-'.$type.' alert-dismissable fade in">';
		$output .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
		switch (gettype($messages)) {
			case 'array':
				foreach ($messages as $message) {
					$output .= '<strong>'.$message.'</strong><br />';
				}
				break;
			default:
				$output .= '<strong>'.$messages.'</strong><br />';
				break;
		}
		$output .= '</div>';
		echo $output;
	}

	function getData($id = null, $table = null, $field = 'id') {
		if (!is_null($id)) {
			$sistem = new Sistem($table);
			if ($sistem->get(array('id', '=', $id))) {
				$result = $sistem->data()[0];
				return $result->$field;
			}
		}
		return 'No existente';
	}

	function getEventsReport($from = null, $to = null, $type) {
		if (is_null($from) || is_null($to))
			return array();
		$db = DB::getInstance();
		$t = (!empty($type)) ? "id_events_type LIKE {$type}": "";
		$d = (!empty($from) && !empty($to)) ? "startDate BETWEEN '{$from}' AND '{$to}'": "";
		$a = (!empty($t) && !empty($d)) ? "AND": "";
		$sql = "SELECT * from events WHERE {$t} {$a} {$d}";
		$results = $db->query($sql);
		if ($results->count()) {
			return $results->results();
		} else {
			return false;
		}
	}

	function getGroupsReport($speciality = null, $status = null) {
		if (is_null($speciality) || is_null($status))
			return array();
		$db = DB::getInstance();
		$t = (!empty($speciality)) ? "speciality LIKE '{$speciality}'": "";
		$d = (!empty($status) ) ? "state LIKE {$status}": "";
		$a = (!empty($t) && !empty($d)) ? "AND": "";
		$sql = "SELECT * from groups_2 WHERE {$t} {$a} {$d}";
		$results = $db->query($sql);
		if ($results->count()) {
			return $results->results();
		} else {
			return false;
		}

	}

	function getVehiclesReport($type = null, $status = null) {
		if (is_null($type) || is_null($status))
			return array();
		$db = DB::getInstance();
		$t = (!empty($type)) ? "type LIKE '{$type}'": "";
		$d = "state LIKE {$status}";
		$a = (!empty($t) && !empty($d)) ? "AND": "";
		$sql = "SELECT * from vehicles WHERE {$t} {$a} {$d}";
		$results = $db->query($sql);
		if ($results->count()) {
			return $results->results();
		} else {
			return false;
		}
	}

	function getEquipmentsReport($type = null, $status = null) {
		if (is_null($type) || is_null($status))
			return array();
		$db = DB::getInstance();
		$t = (!empty($type)) ? "type LIKE '{$type}'": "";
		$d = "state LIKE {$status}";
		$a = (!empty($t) && !empty($d)) ? "AND": "";
		$sql = "SELECT * from equipments WHERE {$t} {$a} {$d}";
		$results = $db->query($sql);
		if ($results->count()) {
			return $results->results();
		} else {
			return false;
		}
	}

	function getVolunteersReport($group = null, $proffession = null, $speciality = null, $state = null) {
		if (is_null($group) || is_null($proffession)|| is_null($speciality)|| is_null($state))
			return array();
		$db = DB::getInstance();
		$g = (!empty($group)) ? "id_group LIKE {$group}": "";
		$p = (!empty($proffession)) ? "proffession LIKE '{$proffession}'": "";
		$sp = (!empty($speciality)) ? "speciality LIKE '{$speciality}'": "";
		$st = "state LIKE {$state}";
		$a = (!empty($g) && !empty($st)) ? "AND": "";
		$sql = "SELECT * from volunteers WHERE {$g} {$a} {$st}";
		echo $sql;
		$results = $db->query($sql);
		if ($results->count()) {
			return $results->results();
		} else {
			return false;
		}
	}

	function getTreeType($label, $fieldName) {
		$sistem = new Sistem('events_type');
		$sistem->get(array('id', '>', 0));
		$data = $sistem->data();
		$output = '<div class="form-group">';
			$output .= '<label for="' . $fieldName . '">' . $label . '</label>';
			$output .= '<select class="form-control" name="' . $fieldName . '" id="' . $fieldName . '">';
				$output .= '<option value="">Seleccione '. $label .'</option>';
				$output .= treeToHTML(buildTree($data));
			$output .= '</select>';
		$output .= '</div>';
		echo $output;
	}

	function treeToHTML(array $elements, $pass = 0) {
		$output = '';
		foreach ($elements as $element) {
			$disabled = (!array_key_exists('children', $element)) ? '' : 'disabled';
			$output .= '<option value="' . $element['id'] . '" ' . $disabled .'>';
				$output .= str_repeat('- ', $pass) . $element['name'];
			$output .= '</option>';
			if (array_key_exists('children', $element)) {
				$output .= treeToHTML($element['children'], $pass + 1);
			}
		}
		return $output;
	}

	function buildTree(array $elements, $parentId = 0) {
		$branch = array();
		foreach ($elements as $element) {
			$element = array(
				'id' => $element->id,
				'name' => $element->name,
				'parent_id' => $element->parent_id
			);
			if ($element['parent_id'] == $parentId) {
				$children = buildTree($elements, $element['id']);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}
		return $branch;
	}

	function buildInputText($label, $name, $value = '', $type = 'text') {
		$output = '';
		$output .= '<div class="form-group">';
			$output .= '<label for="'. $name .'">'. $label .':</label>';
			$output .= '<input name="'. $name .'" type="'. $type .'" class="form-control" id="'. $name .'" value="'. $value .'">';
		$output .= '</div>';
		echo $output;
	}