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
