<?php

class User_model extends CI_Model
{

    private $_strUser = 'user';

    private $_strPlatConfig = 'plat_config';

    private $_strUserGroupRight = 'user_group_right';

    private $_strUserGroup = 'user_group';

    private $_strPlatMenu = 'plat_menu';

    private $_db = "";

    function __construct()
    {
        parent::__construct();
        if (empty($this->_db)) {
            $this->_db = $this->load->database('default', true);
        }
    }
    // function testinsert($arr)
    // {
    //     $this->_db->insert("goods" , $arr);
    // }

    function addUser($arr)
    {
        $uname = $arr['uname'];
        $user = $this->getUserByName($uname);
        if ($user) {
            return array(
                "code" => 2,
                "msg" => "用户名已经存在"
            );
        }
        $insertData['username'] = $uname;
        $insertData['nick_name'] = $arr['nick_name'];
        $insertData['user_level'] = $arr['user_level'];
        $insertData['salt'] = getRand(16);
        $insertData['password'] = password($arr['pwd'], $insertData['salt']);
        $insertData['gcode'] = getBase32Rand();
        $insertData['ctime'] = date("Y-m-d H:i:s");
        $insertData['mtime'] = date("Y-m-d H:i:s");
        $isS = $this->_db->insert($this->_strUser, $insertData);
        if (! $isS) {
            return array(
                "code" => - 1,
                "msg" => "添加用户失败"
            );
        }
        return array(
            "code" => 1,
            "msg" => "添加用户成功"
        );
    }

    function wsession($user)
    {
        $level = $user['user_level'];
        $group = $user['user_group'];
        $baseRight = $user['user_right'];
        $jsonRight = $this->getUserRight($group, $baseRight, $level);
        
        $sess['level'] = $level;
        $sess['right'] = $jsonRight;
        $sess['group'] = $group;
        $sess['username'] = $user['username'];
        $sess['nick_name'] = $user['nick_name'];
        
        $ci = &get_instance();
        $ci->load->library('session');
        
        $ci->session->set_userdata('user_info', $sess);
        return $sess;
    }

    function getUserRight($group, $baseRight, $level)
    {
        // 管理员和超级管理员默认拥有所有的权限，无需判断用户组和right
        if ($level == 4 || $level == 8) {
            return "";
        }
        $right = array();
        if ($baseRight != "") {
            $right = explode(",", $baseRight);
        }
        if($group)
        {
            $sql = "select pm.action from {$this->_strUserGroupRight} ugr left join {$this->_strPlatMenu} pm on ugr.pmid=pm.id where ugr.ugid in ({$group})";
            $action = $this->_db->query($sql , array())->result_array();
            if ($action) {
                foreach ($action as $value) {
                    $right[] = $value['action'];
                }
            }            
        }
        $jsonRight = json_encode($right);
        return $jsonRight;
    }

    function getUserByName($name)
    {
        $user = $this->_db->get_where($this->_strUser, array(
            "username" => $name
        ))->row_array();
        return $user;
    }

    function getUserByUid($id)
    {
        $user = $this->_db->get_where($this->_strUser, array(
            "id" => $id
        ))->row_array();
        return $user;
    }

    function updateUser($data, $where)
    {
        $ret = $this->_db->update($this->_strUser, $data, $where);
        return $ret;
    }

    function getPlatConfig()
    {
        $sql = "select * from {$this->_strPlatConfig}";
        $config = $this->_db->query($sql)->result_array();
        if (! $config) {
            return false;
        }
        $arrConfig = array();
        foreach ($config as $key => $value) {
            $arrConfig[$value['ckey']] = $value['cvalue'];
        }
        return $arrConfig;
    }
    function getManageUserByWhere($arr = array() , $level)
    {
        $p = "id,username,nick_name,gcode,user_group,user_level,user_right,status,salt,ctime,mtime";
        $sql = " select {$p} from {$this->_strUser} where 1=1 and user_level < {$level} ";
        $sqlNum = " select count(*) as num from {$this->_strUser} where 1=1 and user_level < {$level} ";
        
        $arrWhere = array();
        $arrWhereNum = array();
        
        if (isset($arr['ls'])) {
            $sql .= " limit ? , ?";
            $arrWhere[] = $arr['ls'];
            $arrWhere[] = $arr['le'];
        }
        
        $list = $this->_db->query($sql, $arrWhere)->result_array();
        $arrCount = $this->_db->query($sqlNum, $arrWhereNum)->row_array();
        
        return array(
            'list' => $list,
            'num' => $arrCount['num']
        );
    }
    /*
        获取用户可分配权限组
    */
    function getUserGroup($strGroup = "")
    {
        $sql = "select id,gname from {$this->_strUserGroup} where 1 = 1 ";
        if(!empty($strGroup))
        {
            $sql .=" and id in ({$strGroup}) ";
        }
        return $this->_db->query($sql)->result_array();
    }

    function deleteUserById($id){
        return $this->_db->delete($this->_strUser , array('id'=>$id));
    }
}