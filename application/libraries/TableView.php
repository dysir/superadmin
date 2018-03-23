<?php
class TableView{
	/*
		表标题 
		数据结构：
			k 为表数据field  v是中文描述
			k => v
	*/
	public $tableTitle = array();
	/*
		表数据
		array(
			array(	
				//为表数据field   
				k          
				=>    
				v是值 如果存在处理函数 则为函数参数(string|array)
				v
			),
		)
	*/
	public $tableData = array();
	/*
		数据配置
		array(
			//为表数据field
			k=>array(
				//处理函数 默认 textdata
				'func'=>''
			)
		)
	*/
	public $tableDataConfig = array();

	//表样式
	public $tableStyle = 'table table-striped table-bordered table-hover';

	protected $_ext = array();


	function __construct($arrParam = array()){
		$this->_ext = $arrParam;
	}

	protected function thead(){
		$htmlTitle = "<tr>";
		if(!empty($this->tableTitle)){
			foreach ($this->tableTitle as $k => $v) {
				$htmlTitle.="<th>";
				$htmlTitle.=empty($v)?$k:$v;
				$htmlTitle.="</th>";
			}
		}
		$htmlTitle .= "</tr>";
		return $htmlTitle;
	}
	protected function tbody(){
		$tableData = $this->tableData;
		$tableTitle = $this->tableTitle;
		$tableDataConfig = $this->tableDataConfig;
		$htmlBody = "";
		if(!empty($tableTitle) && !empty($tableData)){
			foreach ($tableData as $vd) {
				$htmlBody .= "<tr>";
				foreach ($tableTitle as $k => $v) {
					$htmlBody.="<td>";
					if(!empty($vd[$k]) ){
						$data = $vd[$k];
						$func = empty($tableDataConfig[$k]['func']) || !method_exists($this,$tableDataConfig[$k]['func'])?'textdata': $tableDataConfig[$k]['func'];
						// !is_array($data)&&$data = array($data);
						// $htmlBody.=call_user_func_array(array($this, $func), $data);
						$htmlBody.=$this->$func($data);
					}
					$htmlBody.="</td>";
				}
				$htmlBody .= "</tr>";
			}
		}
		return $htmlBody;
	}
	//默认数据处理函数
	protected function textdata($v){
		return trim($v);
	}

	function setTableTitle($tableTitle){
		$this->tableTitle = $tableTitle;
	}

	function setTableData($tableData){
		$this->tableData = $tableData;
	}
	function setTableDataConfig($tableDataConfig){
		$this->tableDataConfig = $tableDataConfig;
	}
	//判断该列是是否需要权限判断
	function checkTableTitle(){
		
	}
	//输出表格
	function view(){
		$tableStyle = $this->tableStyle;
		$view = '<table class="{$tableStyle}">';
		$view.= '<thead>';
		$view.=$this->thead();
		$view.='</thead>';
		$view.='<tbody>';
		$view.=$this->tbody();
		$view.='</tbody>';
		$view.='</table>';
		return $view;
	}

	function __call($method , $args){
		if(!empty($this->_ext)){
			foreach ($this->_ext as $obj) {
				return call_user_func_array(array($obj ,$method ), $args);
			}
		}
		return call_user_func_array(array($this, $method), $args);
	}
}