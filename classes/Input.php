<?php
/**
 * Description of Input
 *
 * @author Alberto Diaz
 */
class Input {

    public static function exists($type = 'post'){
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? TRUE : FALSE;
                break;
            case 'get' :
                return (!empty($_GET) ? TRUE : FALSE);
                break;
            default:
                return FALSE;
                break;
        }
    }
    
    public static function get($item){
        if(isset ($_GET[$item])){
            return $_GET[$item];
        }
        else if(isset($_POST[$item])){
            return $_POST[$item];
        }
        return '';
    }

    public static function file($item) {
        if(isset ($_FILES[$item])){
            return $_FILES[$item];
        }
        return array();
    }
}
