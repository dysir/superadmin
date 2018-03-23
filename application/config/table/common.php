<?php
$config = array(
	/*
		        公共描述字段 优先搜索表配置 如不存在搜素公共配置
	*/
	"_global" => array(
		//数据库字段描述
		"colmunvalue" => array(

		),
	),
	'user' => array(
		'status' => array(
			'colmunvalue' => array(
				'2' => '正常',
				'3' => '锁定',
			),
		),
		'user_level' => array(
			'colmunvalue' => array(
				'1' => '普通用户',
				'2' => '普通管理员',
				'4' => '管理员',
				'8' => '超级管理员',
			),
		),
	),
	'plat_menu' => array(
		'status' => array(
			'colmunvalue' => array(
				'1' => '显示',
				'2' => '不显示',
			),
		),
	),
	'plat_config' => array(
		'type' => array(
			'colmunvalue' => array(
				'1' => '显示',
				'2' => '不显示',
			),
		),
	),
	'goods' => array(
		'status' => array(
			'colmunvalue' => array(
				'1' => '正常',
				'2' => '下架',
				'3' => '删除',
			),
		),
	),
	'order' => array(
		'status' => array(
			'colmunvalue' => array(
				'1' => '已创建未付款',
				'2' => '已付款',
				'3' => '已取消',
			),
		),
	),

);