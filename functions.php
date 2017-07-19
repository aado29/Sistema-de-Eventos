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

	function getReportByDate($date = null) {
		if (is_null($date))
			$date = date('Y-m-d');
		$sistem = new Sistem('events');
		return $sistem->getByDate($date);
	}

	function getReportByRangeDate($date = null, $date_ = null) {
		if (is_null($date) || is_null($date_))
			return array();
		$sistem = new Sistem('events');
		return $sistem->getBetweenDates($date, $date_);
	}

	function getTreeType($fieldName, $label) {
		$sistem = new Sistem('events_type');
		$sistem->get(array('id', '>', 0));
		$data = $sistem->data();
		$output = '<div class="form-group">';
			$output .= '<label for="' . $fieldName . '">' . $label . '</label>';
			$output .= '<select class="form-control" name="' . $fieldName . '" id="' . $fieldName . '">';
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