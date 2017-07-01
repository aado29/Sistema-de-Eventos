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
