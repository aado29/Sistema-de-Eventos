<?php
/**
 * Description of Redirect
 *
 * @author Alberto Diaz
 */
class Redirect {

    public static function to($location = NULL){
        if($location){
            if(is_numeric($location)){
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Foound');
                        include 'includes/errors/404.php';
                        exit();
                    break;
                }
            }
            header('Location: '. $location);
            exit();
        }
    }
}
