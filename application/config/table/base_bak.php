<?php
/*
	tabletitle
		表头
			key 若 _P_* 则为权限列 需要进行权限判断
	tabledatafunc
		数据处理方法


*/
$config = array(
	"tabletitle"=>array(
		"name"=>"名称",
		"price"=>"价格",
		'ctime'=>"时间"
	),
	"tabledatafunc"=>array(
		'ctime'=>array(
			'func'=>'toDate'
		),
	),
);