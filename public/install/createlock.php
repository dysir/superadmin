<?php
file_put_contents("../lock", 1);
ajax(1 , null , "success");

function ajax($code, $data, $msg) {
	$info = array();
	$info['data'] = $data;
	$info['msg'] = $msg;
	$info['code'] = $code;
	if (isset($_REQUEST['callback'])) {
		// jsonp
		header('Content-Type: application/javascript;charset=utf-8');
		exit($_REQUEST['callback'] . '(' . json_encode($info) . ')');
	} else {
		// json
		header('Content-Type: application/json;charset=utf-8');
		exit(json_encode($info));
	}
}