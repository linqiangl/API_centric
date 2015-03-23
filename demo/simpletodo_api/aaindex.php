<?php
// 定义数据目录的路径
define('DATA_PATH', realpath(dirname(__FILE__).'/data'));

//引入我们的models
include_once 'models/TodoItem.php';

//在一个try-catch块中包含所有代码，来捕获所有可能的异常!
try {
	//获得在POST/GET request中的所有参数
	$params = $_REQUEST;
	//echo $_REQUEST;
	//echo urlencode(implode(" ",$params));
	//echo 'requestData=' . urlencode(serialize(array('topicID' => '101305598452')));
	
	//获取controller并把它正确的格式化使得第一个字母总是大写的
	$controller = ucfirst(strtolower($params['controller']));
	
	//获取action并把它正确的格式化，使它所有的字母都是小写的，并追加一个'Action'
	$action = strtolower($params['action']).'Action';

	//检查controller是否存在。如果不存在，抛出异常
	if( file_exists("controllers/{$controller}.php") ) {
		include_once "controllers/{$controller}.php";
	} else {
		throw new Exception('Controller is invalid.');
	}
	
	//创建一个新的controller实例，并把从request中获取的参数传给它
	$controller = new $controller($params);
	
	//检查controller中是否存在action。如果不存在，抛出异常。
	if( method_exists($controller, $action) === false ) {
		throw new Exception('Action is invalid.');
	}
	
	//执行action
	$result['data'] = $controller->$action();
	$result['success'] = true;
	
} catch( Exception $e ) {
	//捕获任何一次样并且报告问题
	$result = array();
	$result['success'] = false;
	$result['errormsg'] = $e->getMessage();
}

//回显调用API的结果
echo json_encode($result);
exit();