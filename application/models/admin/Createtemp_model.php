<?php
class Createtemp_model extends CI_Model
{
	private $_db = "";
	private $_databaseName = "";

    function __construct()
    {
        parent::__construct();
        if (empty($this->_db)) {
            $this->_db = $this->load->database('default', true);
        }
        include APPPATH."config/database.php";
		$config = $db['default'];
		$this->_databaseName = $config['database'];
    }
    function getTablelist(){
    	$sql = "select table_name,table_comment from information_schema.tables where table_schema='".$this->_databaseName."'";

		return  $this->_db->query($sql)->result_array();
    }
    //获取数据表字段及描述
	function getTablecolumn($strTable){

		$sql = "SELECT COLUMN_NAME,column_comment FROM INFORMATION_SCHEMA.Columns WHERE table_name=? AND table_schema='".$this->_databaseName."'";

		return  $this->_db->query($sql , [$strTable])->result_array();

		// $fieldComment = array();
		// foreach ($result as $key => $value) {			
		// 	$fieldComment[$value['COLUMN_NAME']] = empty($value['column_comment'])?$value['COLUMN_NAME']:trim($value['column_comment']);
		// }
		// return $fieldComment;
	}
}