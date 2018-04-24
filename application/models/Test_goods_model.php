<?php
class Test_goods_model extends CI_Model 
{
    
	private $_strTestGoods = 'test_goods';
    private $_db = "";

    function __construct()
    {
        parent::__construct();
        if (empty($this->_db)) {
            $this->_db = $this->load->database("default", true);
        }
    }

    function getList($arrWhere = array() )
    {
        
		$strSelect = 'name,price,num';
        $sql = " select {$strSelect} from test_goods where 1=1  ";
        $sqlNum = " select count(*) as num from test_goods where 1=1  ";
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
}

?>