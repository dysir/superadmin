<?php

class Log_model extends CI_Model
{
   private static $_strOpLog = "oplog";
   
   private static $_db = "";

    function __construct()
    {
        parent::__construct();
        if (empty(self::$_db)) {
            self::$_db = $this->load->database('default', true);
        }
    }

    public static function  getLog($arr) {
        $p = "*";
        $sql = " select {$p} from ".self::$_strOpLog." where 1=1  ";
        $sqlNum = " select count(*) as num from ".self::$_strOpLog."  where 1=1 ";
        
        $arrWhere = array();
        $arrWhereNum = array();
        
        if (isset($arr['st'])) {
            $sql.=" and ctime>?";
            $sqlNum.=" and ctime>?";
            $arrWhere[] = $arr['st'];
            $arrWhereNum[] = $arr['st'];
            
        }
        if (isset($arr['et'])) {
            $sql.=" and ctime<=?";
            $arrWhere[] = $arr['et'];
            $sqlNum.=" and ctime<=?";
            $arrWhereNum[] = $arr['et'];
        }
        
        $sql.=" order by id desc ";
        if (isset($arr['ls'])) {
            $sql .= " limit ? , ?";
            $arrWhere[] = $arr['ls'];
            $arrWhere[] = $arr['le'];
        }
        $list = self::$_db->query($sql, $arrWhere)->result_array();
        $arrCount = self::$_db->query($sqlNum, $arrWhereNum)->row_array();
        
        return array(
            'list' => $list,
            'num' => $arrCount['num']
        );
    }
    
    public static function insertLog($arr) {
        $arr['ctime'] = date("Y-m-d H:i:s");
        $ret = self::$_db->insert(self::$_strOpLog, $arr);
        return $ret;
    } 
    
}