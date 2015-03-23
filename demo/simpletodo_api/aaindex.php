<?php
// ��������Ŀ¼��·��
define('DATA_PATH', realpath(dirname(__FILE__).'/data'));

//�������ǵ�models
include_once 'models/TodoItem.php';

//��һ��try-catch���а������д��룬���������п��ܵ��쳣!
try {
	//�����POST/GET request�е����в���
	$params = $_REQUEST;
	//echo $_REQUEST;
	//echo urlencode(implode(" ",$params));
	//echo 'requestData=' . urlencode(serialize(array('topicID' => '101305598452')));
	
	//��ȡcontroller��������ȷ�ĸ�ʽ��ʹ�õ�һ����ĸ���Ǵ�д��
	$controller = ucfirst(strtolower($params['controller']));
	
	//��ȡaction��������ȷ�ĸ�ʽ����ʹ�����е���ĸ����Сд�ģ���׷��һ��'Action'
	$action = strtolower($params['action']).'Action';

	//���controller�Ƿ���ڡ���������ڣ��׳��쳣
	if( file_exists("controllers/{$controller}.php") ) {
		include_once "controllers/{$controller}.php";
	} else {
		throw new Exception('Controller is invalid.');
	}
	
	//����һ���µ�controllerʵ�������Ѵ�request�л�ȡ�Ĳ���������
	$controller = new $controller($params);
	
	//���controller���Ƿ����action����������ڣ��׳��쳣��
	if( method_exists($controller, $action) === false ) {
		throw new Exception('Action is invalid.');
	}
	
	//ִ��action
	$result['data'] = $controller->$action();
	$result['success'] = true;
	
} catch( Exception $e ) {
	//�����κ�һ�������ұ�������
	$result = array();
	$result['success'] = false;
	$result['errormsg'] = $e->getMessage();
}

//���Ե���API�Ľ��
echo json_encode($result);
exit();