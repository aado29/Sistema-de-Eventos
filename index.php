<?php
require_once 'core/init.php';

$user = new User();
if(!$user->isLoggedIn()) {
	Redirect::to('login.php');
}
gettemplate('header');

gettemplate('footer');