<?php
$fiBool = function_exists("mysqli_connect");
if (!$fiBool) {
	ajax(-1, null, "缺少mysqli扩展");
}
$arrPost = $_POST;

if (empty($arrPost['dbname']) || empty($arrPost['host']) || empty($arrPost['name']) || empty($arrPost['pwd'])) {
	ajax(-1, null, "缺少参数");
}

$dbname = $arrPost['dbname'];
$name = $arrPost['name'];
$pwd = $arrPost['pwd'];
$host = $arrPost['host'];

$con = mysqli_connect($host, $name, $pwd);
if (mysqli_connect_errno($con)) {
	ajax(-1, null, "连接 MySQL 失败");
}

if (!$resDb = mysqli_query($con, "select * from information_schema.schemata where schema_name='{$dbname}'")) {
	ajax(-1, null, "错误描述: " . mysqli_error($con));
}
if (empty($resDb) || $resDb->num_rows <= 0) {
	if (!mysqli_query($con, "set names utf8")) {
		ajax(-1, null, "字符集设置失败 msg:" . mysqli_error($con));
	}

	if (!mysqli_query($con, "create database " . $arrPost['dbname'])) {
		ajax(-1, null, $arrPost['dbname'] . "数据库不存在且创建失败 msg:" . mysqli_error($con));
	}
}
if (!mysqli_query($con, "use {$dbname}")) {
	ajax(-1, null, "使用数据库失败 msg:" . mysqli_error($con));
}
if (!mysqli_query($con, "SET FOREIGN_KEY_CHECKS=0")) {
	ajax(-1, null, "取消外键约束失败 msg:" . mysqli_error($con));
}

$file = fopen("./super.sql", "r");
$arrSql = [];
$strOneSql = "";

while (!feof($file)) {
	$strline = trim(fgets($file));
	$arrLine = explode(" ", $strline);
	if(!empty($arrLine[0]) && in_array(strtolower( $arrLine[0]), ["drop","create","insert"])){
		$strOneSql = $strline;
		if(substr($strline, -1) ==";"){
			$arrSql[] = substr($strOneSql, 0,-1);
			$strOneSql = "";
		}
	}elseif(substr($strline, -1) ==";"){
		$strOneSql.=$strline;
		$arrSql[] = substr($strOneSql, 0,-1);
		$strOneSql = "";
	}elseif(!empty($strOneSql)){
		$strOneSql.=$strline;
	}
}


if(empty($arrSql)){
	ajax(-1 , null , "没有可执行语句");
}

foreach ($arrSql as $key => $value) {
	if (!mysqli_query($con, $value)) {
		ajax(-1, null, "语句失败：{$value},msg:" . mysqli_error($con));
	}
}

mysqli_close($con);

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

?>