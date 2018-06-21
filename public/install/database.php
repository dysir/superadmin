<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	文件配置数据库链接后放置到 application/config 下
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	//数据库地址
	'hostname' => '{host}',
	//数据库用户名
	'username' => '{name}',
	//数据库密码
	'password' => '{pwd}',
	//数据库名
	'database' => '{dbname}',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
