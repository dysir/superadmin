<?php

class Group_model extends CI_Model
{
    private $_strUserGroup = 'user_group';
    private $_strUserGroupRight = 'user_group_right';
    private $_strPlatMenu = 'plat_menu';

    private $_db = "";

    function __construct()
    {
        parent::__construct();
        if (empty($this->_db)) {
            $this->_db = $this->load->database('default', true);
        }
    }

    function getUserGroup($arrWhere = array())
    {
    	return $this->_db->get_where($this->_strUserGroup , $arrWhere)->result_array();
    }
    function addGroup($arr)
    {
        return $this->_db->insert($this->_strUserGroup , $arr);
    }
    function deleteGroup($id)
    {
        $this->_db->delete($this->_strUserGroupRight ,array('ugid'=>$id) );
        return $this->_db->delete($this->_strUserGroup , array('id'=>$id));
    }

    function getGroupRight($id)
    {
        $sql = "select pm.action,ugr.pmid from {$this->_strUserGroupRight} ugr left join {$this->_strPlatMenu} as pm on ugr.pmid = pm.id where ugr.ugid = ? ";
        return $this->_db->query($sql , array($id))->result_array();
    }
    function updateGroupRight($insert, $ugid)
    {
        $this->_db->trans_start();
        $this->_db->delete($this->_strUserGroupRight ,array('ugid'=>$ugid) );
        $this->_db->insert_batch($this->_strUserGroupRight , $insert);
        $this->_db->trans_complete();
        if ($this->_db->trans_status() === FALSE)
        {
            return false;
        }
        return true;
    }
}