<?php
session_start();
include_once 'apicaller.php';

$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', 'http://192.168.73.190/simpletodo_api/');

$todo_items = $apicaller->sendRequest(array(
	'controller' => 'todo',
	'action' => 'read',
	'username' => $_SESSION['username'],
	'userpass' => $_SESSION['userpass']
));

echo '';
var_dump($todo_items);

?>