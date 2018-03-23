<?php
/*
 * 数据库 status 状态 描述
 */
$config['table_desc'] = array(
    'user' => array(
        'status' => array(
            '2' => '正常',
            '3' => '锁定'
        ),
        'user_level' => array(
            '1' => '普通用户',
            '2' => '普通管理员',
            '4' => '管理员',
            '8' => '超级管理员'
        )
    
    ),
    'plat_menu' => array(
        'status' => array(
            '1' => '显示',
            '2' => '不显示'
        )
    ),
    'goods'=>array(
        'status'=>array(
            '1' => '正常',
            '2' => '下架',
            '3' => '删除',
        )
    ),
    'order'=>array(
        'status'=>array(
            '1' => '已创建未付款',
            '2' => '已付款',
            '3' => '已取消',
        )
    ),
);
/*
    特殊关键词 命名权限名时不允许被命名
*/
$config['keyword_action'] = array(
    'superadmin','normaladmin'
);

/*
    特殊权限 ，默认普通管理员拥有且不允许被修改
*/
$config['normaladmin'] = array(
    array(
        'action'=>"/m/user/index"
    )
);