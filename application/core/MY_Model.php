<?php

class MY_Model extends CI_Model
{
    public $_db = null;

    function __construct()
    {
        parent::__construct();
        $this->_db = $this->load->database("default", true);
    }

    function getRow($arrWhere = array() , $table = false){
        $table&&$this->_DfTable=$table;
        if(empty($this->_DfTable)){
            return false;
        }
        return $this->_db->get_where($this->_DfTable,$arrWhere)->row_array();
    }
    function getResult($arrWhere = array() , $table = false){
        $table&&$this->_DfTable=$table;

        if(empty($this->_DfTable)){
            return false;
        }
        return $this->_db->get_where($this->_DfTable,$arrWhere)->result_array();
    }

    function updateTable($arrUpdate , $table = false){
        $table&&$this->_DfTable=$table;
        if(empty($this->_DfTable)){
            return false;
        }
        $arrUpdate['update']['mtime']=date("Y-m-d H:i:s");
        return $this->_db->update($this->_DfTable,$arrUpdate['update'],$arrUpdate['where']);
    }

    function insertTable($arrInsert , $table = false){
        $table&&$this->_DfTable=$table;
        if(empty($this->_DfTable)){
            return false;
        }
        $arrInsert['mtime']=date("Y-m-d H:i:s");
        $arrInsert['ctime']=date("Y-m-d H:i:s");
        return $this->_db->insert($this->_DfTable,$arrInsert);
    }
}