<?php

$arrPost = $_POST;

if (empty($arrPost['dbname']) || empty($arrPost['host']) || empty($arrPost['name']) || empty($arrPost['pwd'])) {
	ajax(-1, null, "缺少参数");
}

$dbname = $arrPost['dbname'];
$name = $arrPost['name'];
$pwd = $arrPost['pwd'];
$host = $arrPost['host'];
$dbfile = file_get_contents("./database.php");

$dbfile = str_replace("{host}", $host, $dbfile);
$dbfile = str_replace("{name}", $name, $dbfile);
$dbfile = str_replace("{pwd}", $pwd, $dbfile);
$dbfile = str_replace("{dbname}", $dbname, $dbfile);
file_put_contents("../../application/config/database.php", $dbfile);

ajax(1 ,null , "success");

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