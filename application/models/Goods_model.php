<?php

class Goods_model extends CI_Model
{
    private $_strGoods = 'test_goods';
    private $_db = "";

    function __construct()
    {
        parent::__construct();
        if (empty($this->_db)) {
            $this->_db = $this->load->database('default', true);
        }
    }
    function getGoodslist($arrWhere = array() )
    {
        $sql = " select * from {$this->_strGoods} where status <> 3 ";
        $sqlNum = " select count(*) as num from {$this->_strGoods} where status <> 3 ";
        $arrParam = array();
        $arrParamNum = array();
        
        if (isset($arrWhere['ls'])) {
            $sql .= " limit ? , ?";
            $arrParam[] = $arrWhere['ls'];
            $arrParam[] = $arrWhere['le'];
        }

        $list = $this->_db->query($sql, $arrParam)->result_array();
        $arrCount = $this->_db->query($sqlNum, $arrParamNum)->row_array();
        return array(
            'list' => $list,
            'num' => $arrCount['num']
        );
    }
    function addGoods($arrGoods)
    {
        return $this->_db->insert($this->_strGoods , $arrGoods);
    }
    function editGoods($arrEdit , $arrWhere)
    {
        return $this->_db->update($this->_strGoods , $arrEdit , $arrWhere);
    }

    function getGoodsByWhere($arrWhere)
    {
        return $this->_db->get_where($this->_strGoods , $arrWhere)->row_array();
    }
    function deleteGoodsById($id)
    {
        return $this->_db->delete($this->_strGoods , array('id'=>$id));
    }
}