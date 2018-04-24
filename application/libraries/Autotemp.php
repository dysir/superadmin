<?php
class Autotemp{
	//是否覆盖已存在文件
	public $_overfile = true;

	//表字段数据 必填 
	public $_datafield = "";
	/*
		文件名
		可选 默认主表名
	*/
	public $_filename = "";
	/*
		字段配置数组
		可选
			规则
				array(
					'表名'=>array(
						字段=>array(
							//描述字段 view展示 及搜索以此为标准
							'colmunvalue'=>array(
								1=>'a1',
								2=>'a2',
							),
							...
						)
					)
				)
	*/
	public $_arrColumnInfo = array();

	/*
		生成文件存放目录
	*/
	private $_pathOutController = APPPATH."controllers/";
	private $_pathOutModel = APPPATH."models/";
	private $_pathOutView = APPPATH."views/";
	/*
		模板存放目录
	*/
	private $_pathTempController =APPPATH."libraries/autotemp/temp_controller.temp";
	private $_pathTempModel =APPPATH."libraries/autotemp/temp_model.temp";
	private $_pathTempView =APPPATH."libraries/autotemp/temp_view.temp";
	private $_pathTempFormSelect =APPPATH."libraries/autotemp/temp_form_select.temp";
	private $_pathTempFormInput =APPPATH."libraries/autotemp/temp_form_input.temp";


	private $_resinfo = array();
	private $_tableinfo = array();
	private $_tableTitle = array();
					// table=>'',
					// type=>1, 1 input 2 select
					// k=>status,
					// v=>"状态"
	private $_arrSearch = array();



	function creater($config = array())
	{

		$arrInit = $this->init($config);

		if($arrInit['code']!=1)
		{
			return $arrInit;
		}
		$arrView = $this->creatView();

		if($arrView['code']!=1)
		{
			return $arrView;
		}

		//生成控制器
		$arrContro = $this->creatController();
		if($arrContro['code']!=1)
		{
			return $arrContro;
		}
		

		$arrModel = $this->creatModel();

		if($arrModel['code']!=1)
		{
			return $arrModel;
		}

		return $this->resMsg("ok");
	}

	/*
		单独调用某个方法生成文件时，初始化使用
	*/
	function init($config)
	{
		foreach ($config as $key => $value) {
			isset($this->$key) && $this->$key =$value;
		}
		if(empty($this->_datafield))
		{
			return $this->resMsg("缺少数据配置");
		}
		if(!$this->check_dir_iswritable($this->_pathOutController) ||!$this->check_dir_iswritable($this->_pathOutModel)|| !$this->check_dir_iswritable($this->_pathOutView))
		{
			return $this->resMsg("检查目录是否拥有可写权限");
		}

		$datafield = $config['_datafield'];
		if(empty($datafield['maintable'])){
			return $this->resMsg("缺少主表");
		}
		//定义文件名
		empty($this->_filename)?$this->_filename = $datafield['maintable']:"";
		//获取表名数据
		$tableinfo = array(
			$datafield['maintable']=>$this->tableToStr($datafield['maintable']),
		);
		if(!empty($datafield['joinlist'])){
			foreach ($datafield['joinlist'] as $key => $value) {
				$tableinfo[$value['table']] = $this->tableToStr($value['table']);
			}
		}
		$this->_tableinfo = $tableinfo;

		//从表字段重命名定义
		$columnlist = array();
		//表头字段解析
		$arrTitleInfo = array();
		//搜素表
		$arrSearch = array();
		if(!empty($datafield['maintablecolume'])){
			foreach ($datafield['maintablecolume'] as $key => $value) {
				if($value['s']==1){
					$type = $this->checkColumnConfig($datafield['maintable'] ,$value['k'])?2:1;
					$linkarr = array(
						"table"=>$datafield['maintable'],
						"type"=>$type,
						"k"=>$value['k'],
						"v"=>$value['t'],
					);
					$arrSearch[] = $linkarr;
				}
				$columnlist[] = $value['k'];
				$arrTitleInfo[$value['k']] = empty($value['t'])?$value['k']:$value['t'];
			}
			if(!empty($datafield['joinlist'])){			
				foreach ($datafield['joinlist'] as $key => $value) {
					if(empty($value['colume']))
					{
						continue;
					}

					foreach ($value['colume'] as $k => $v) {

						if($v['s']==1){
							$type = $this->checkColumnConfig($value['table'] ,$v['k'])?2:1;
							$linkarr = array(
								"table"=>$value['table'],
								"type"=>$type,
								"k"=>$v['k'],
								"v"=>$v['t'],
							);
							$arrSearch[] = $linkarr;
						}

						if(in_array($v['k'], $columnlist)){
							$v['k'] = $tableinfo[$value['table']]['as']."_".$v['k'];
							$datafield['joinlist'][$key]['colume'][$k]['as'] = $v['k'];
						}
						$columnlist[] = $v['k'];
						$arrTitleInfo[$v['k']] = empty($v['t'])?$v['k']:$v['t'];
					}
				}
			}
		}
		$this->_tableTitle = $arrTitleInfo;
		$this->_datafield = $datafield;
		$this->_arrSearch = $arrSearch;


		return $this->resMsg("ok");

	}
	//创建控制器
	function creatController()
	{
		$phpTempController = file_get_contents($this->_pathTempController);

		$phpTempController = str_replace("{{FILENAME}}",ucfirst( $this->_filename), $phpTempController);
		$phpTempController = str_replace("{{FILENAMELOW}}", $this->_filename, $phpTempController);

		$fileconstroller = $this->_pathOutController.ucfirst($this->_filename).".php";
		$this->_resinfo['file'][] = $fileconstroller;
		return $this->output($fileconstroller , "<?php\n".$phpTempController."\n?>");
	}
	//创建模板
	function creatView()
	{
		$dataTitle = $this->_tableTitle;
		$dataField = $this->_datafield;
		//表格表头
		$HtmlTitle = "";
		//表格body
		$HtmlField = "";
		$HtmlSearch = "";
		$arrColumnInfo = array();
		$strColumnInfo = "";
		
		foreach ($dataField['maintablecolume'] as $key => $value) {
			if($this->checkColumnConfig($dataField['maintable'] ,$value['k'])){
				$strColumnInfo.="\$arr".ucfirst($value['k'])." = getTableColumnInfo('".$dataField['maintable']."' ,'".$value['k']."' ,'colmunvalue');_PN7_";
				$arrColumnInfo[$value['k']] = "_PN7_<?php _PN8_echo !empty(\$arr".ucfirst($value['k'])."[\$value['".$value['k']."']]) ? \$arr".ucfirst($value['k'])."[\$value['".$value['k']."']] : \"\";_PN7_?>_PN6_";
			}
		}
		if(!empty($dataField['joinlist'])){	
			foreach ($dataField['joinlist'] as $key => $value) {
				if(empty($value['colume']))
				{
					continue;
				}
				foreach ($value['colume'] as $k => $v) {

					if($this->checkColumnConfig($value['table'] ,$v['k'])){
						$askey = empty($v['as'])?$v['k']:$v['as'];
						$strColumnInfo.="\$arr".ucfirst($askey)." = getTableColumnInfo('".$value['table']."' ,'".$askey."' ,'colmunvalue');_PN7_";
						$arrColumnInfo[$askey] = "_PN7_<?php _PN8_echo !empty(\$arr".ucfirst($askey)."[\$value['".$askey."']]) ? \$arr".ucfirst($askey)."[\$value['".$askey."']] : \"\";_PN7_?>_PN6_";
					}
				}

			}
		}
		foreach ($dataTitle as $key => $value) {
			$HtmlTitle.= "_PN6_<th>{$value}</th>";
			if(!empty($arrColumnInfo[$key])){
				$HtmlField.= "_PN6_<td>".$arrColumnInfo[$key]."</td>";
			}else{
				$HtmlField.= "_PN6_<td><?php echo \$value['".$key."'];?></td>";
			}
		}

		$searchform = $this->getSearchFrom();

		$getform = "/".ucfirst( $this->_filename)."/index";
		$phpTempView = file_get_contents($this->_pathTempView );
		$phpTempView = str_replace("{{COLUMNVIEWINFO}}",$strColumnInfo, $phpTempView);
		$phpTempView = str_replace("{{SEARCHFORM}}",$searchform, $phpTempView);
		$phpTempView = str_replace("{{FORMACTION}}",$getform, $phpTempView);
		$phpTempView = str_replace("{{TITLE}}",$HtmlTitle, $phpTempView);
		$phpTempView = str_replace("{{FIELD}}",$HtmlField, $phpTempView);


		$fileViewPath = $this->_pathOutView.$this->_filename;
		if(!is_dir($fileViewPath))
		{
			mkdir($fileViewPath , 0777 , true);
			$this->_resinfo['dir'][] = $fileViewPath;
		}
		$this->_resinfo['file'][] = $fileViewPath."/index.php";

		return $this->output($fileViewPath."/index.php" , $phpTempView);
	}
	function creatModel()
	{
		$datafield = $this->_datafield;
		$phpTempModel = file_get_contents($this->_pathTempModel);

		empty($this->_filename) && $this->_filename = $this->_tablename;
		$phpTempModel = str_replace("{{FILENAME}}",ucfirst( $this->_filename), $phpTempModel);

		$tablelist = "";
		$tableinfo = $this->_tableinfo;
		// $isas 是否需要创建别名 false 不需要 true 需要
		$isas = count($tableinfo)>1?true:false;
		foreach ($tableinfo as $key => $value) {
			$tablelist.="\n\tprivate \$_".$value['p']." = '".$key."';";
		}
		$phpTempModel = str_replace("{{TABLELIST}}",$tablelist, $phpTempModel);

		$strselect = "";
		$strsqltable = "";
		$strsqlTableName = "";

		$strSqlWhere = "";

		$table = $datafield['maintable'];
		$colume = $datafield['maintablecolume'];
		//有从表
		if($isas){
			$strsqlTableName .= "{$table} as ".$tableinfo[$table]['as']." ";
			if(!empty($colume)){
				$strsqltable.="{\$str".ucfirst($tableinfo[$table]['as'])."},";
				$strselect.="_PN2_\$str".ucfirst($tableinfo[$table]['as'])." = '";
				foreach ($colume as $key => $value) {

					if( $this->checkSearh($table ,$value['k']) ){
						$strSqlWhere.="_PN2_if(!empty(\$arrWhere['".$value['k']."'])) {";
						$strSqlWhere.="_PN3_\$sql .= \" and ".$tableinfo[$table]['as'].".".$value['k']." = ?\";";
						$strSqlWhere.="_PN3_\$sqlNum .= \" and ".$tableinfo[$table]['as'].".".$value['k']." = ?\";";
						$strSqlWhere.="_PN3_\$arrParam[] = \$arrWhere['".$value['k']."'];";
						$strSqlWhere.="_PN3_\$arrParamNum[] = \$arrWhere['".$value['k']."'];";
						$strSqlWhere.="_PN2_}";					
					}

					$strselect.=$tableinfo[$table]['as'].".".$value['k'].",";
				}
				$strselect = substr($strselect, 0,-1)."';";
			}

			foreach ($datafield['joinlist'] as $key => $value) {
				$strsqlTableName .= "left join {$value['table']} as ".$tableinfo[$value['table']]['as']." on 1=1 ";
				if(empty($value['colume'])){
					continue;
				}
				$strsqltable.="{\$str".ucfirst($tableinfo[$value['table']]['as'])."},";
				$strselect.="_PN2_\$str".ucfirst($tableinfo[$value['table']]['as'])." = '";
				foreach ($value['colume'] as $k => $v) {

					if( $this->checkSearh($value['table'] ,$v['k']) ){
						$strSqlWhere.="_PN2_if(!empty(\$arrWhere['".$v['k']."'])) {";
						$strSqlWhere.="_PN3_\$sql .= \" and ".$tableinfo[$value['table']]['as'].".".$v['k']." = ?\";";
						$strSqlWhere.="_PN3_\$sqlNum .= \" and ".$tableinfo[$value['table']]['as'].".".$v['k']." = ?\";";
						$strSqlWhere.="_PN3_\$arrParam[] = \$arrWhere['".$v['k']."'];";
						$strSqlWhere.="_PN3_\$arrParamNum[] = \$arrWhere['".$v['k']."'];";
						$strSqlWhere.="_PN2_}";					
					}


					$c = empty($v['as'])?"":" as ".$v['as']." ";
					$strselect.=$tableinfo[$value['table']]['as'].".".$v['k'].$c.",";
					//联查表联查条件
					if(!empty($v['l'])){
						$linkas = $v['k'];
						$arrlinktable = explode(".", $v['l']);
						$strsqlTableName.="and ".$tableinfo[$value['table']]['as'].".{$linkas} = ".$tableinfo[$arrlinktable[0]]['as'].".".$arrlinktable[1]." ";
					}

				}
				$strselect = substr($strselect, 0,-1)."';";
			}
			$strsqltable = substr($strsqltable, 0,-1);

		}else{
			$strselect = "_PN2_\$strSelect = '";
			$strsqltable.="{\$strSelect}";
			$strsqlTableName .= "{$table} ";
			if(!empty($colume) )
			{
				foreach ($colume as $key => $value) {
					if( $this->checkSearh($table ,$value['k']) ){
						$strSqlWhere.="_PN2_if(!empty(\$arrWhere['".$value['k']."'])) {";
						$strSqlWhere.="_PN3_\$sql .= \" and ".$value['k']." = ?\";";
						$strSqlWhere.="_PN3_\$sqlNum .= \" and ".$value['k']." = ?\";";
						$strSqlWhere.="_PN3_\$arrParam[] = \$arrWhere['".$value['k']."'];";
						$strSqlWhere.="_PN3_\$arrParamNum[] = \$arrWhere['".$value['k']."'];";
						$strSqlWhere.="_PN2_}";					
					}
					$strselect.=$value['k'].",";
				}
				$strselect = substr($strselect, 0,-1)."';";
			}else{
				$strselect .= "*';";
			}
		}
		$phpTempModel = str_replace("{{SELECT}}",$strselect, $phpTempModel);



		$field = empty($this->_field)?"*":$this->_field;
		$sql = "select {$strsqltable} from {$strsqlTableName}where 1=1 ";
		$sqlnum = "select count(*) as num from {$strsqlTableName}where 1=1 ";
		$phpTempModel = str_replace("{{SQL}}",$sql, $phpTempModel);
		$phpTempModel = str_replace("{{SQLNUM}}", $sqlnum, $phpTempModel);
		$phpTempModel = str_replace("{{WHERESQL}}", $strSqlWhere, $phpTempModel);

		$filemodel = $this->_pathOutModel.ucfirst($this->_filename)."_model.php";
		$this->_resinfo['file'][] = $filemodel;
		$this->_resinfo['sql'] = $sql;

		return $this->output($filemodel , "<?php\n".$phpTempModel."\n?>");
	}
	function tableToStr($table)
	{
		if(empty($table))
		{
			return "";
		}
		$arrTable = explode("_", $table);
		$strTable = "";
		$strAsTable = "";

		foreach ($arrTable as $key => $value) {
			$strTable.= ucfirst($value);
			$strAsTable.=substr($value, 0,1);
		}
		if(strlen($strAsTable) <=1){
			$strAsTable.=substr($table, -2);
		}

		return array(
			'n'=>$table,
			'p'=>"str".$strTable,
			//表别名  字段重复时用于字段重命名前缀
			'as'=>$strAsTable
		);
	}
	function checkSearh($table ,$c){

		$bool = false;
		foreach ($this->_arrSearch as $key => $value) {
			if($value['table'] == $table && $value['k'] == $c){
				$bool =  true;
				break;
			}
		}
		return $bool;
	}
	//判断文件是否可写
	function check_dir_iswritable($dir_path){
		$is_writale=1;
		if(!is_dir($dir_path)){
			$is_writale=0;
			return $is_writale;
		}else{
			$file_hd=@fopen($dir_path.'/test.txt','w');
			if(!$file_hd){
				$is_writale=0;
				return $is_writale;
			}
			@fclose($file_hd);
			@unlink($dir_path.'/test.txt');
			$dir_hd=opendir($dir_path);
			while(false!==($file=readdir($dir_hd))){
				if ($file != "." && $file != "..") {
					if(is_file($dir_path.'/'.$file)){
						//文件不可写，直接返回
						if(!is_writable($dir_path.'/'.$file)){
						return 0;
						}
					}else{
						$file_hd2=@fopen($dir_path.'/'.$file.'/test.txt','w');
						if(!$file_hd2){
							$is_writale=0;
							return $is_writale;
						}
						@fclose($file_hd2);
						@unlink($dir_path.'/'.$file.'/test.txt');
						//递归
						$is_writale=$this->check_dir_iswritable($dir_path.'/'.$file);
					}
				}
			}
		}
		return $is_writale;
	}

	function resinfo()
	{
		return $this->_resinfo;
	}

	private function output($file , $content)
	{
		preg_match_all("/_PN(\d{1,2})_/", $content, $arrPn);
		if(!empty($arrPn[0])){
			$arrAllPn = array();
			foreach ($arrPn[0] as $key => $value) {
				empty($arrAllPn[$arrPn[1][$key]])?$arrAllPn[$arrPn[1][$key]]=$value:"";
			}
			foreach ($arrAllPn as $kn => $vs) {
				$content = str_replace($vs, "\n".str_repeat("\t", $kn), $content);
			}
		}

		if(!$this->_overfile && file_exists($file))
		{
			return $this->resMsg("文件已存在");
		}

		if(file_exists($file))
		{
			$bool = unlink($file);
			if(!$bool)
			{
				return $this->resMsg("文件已存在,删除失败");
			}
		}



		$bool = file_put_contents($file,$content);

		if($bool<=0)
		{
			return $this->resMsg($file."创建失败");
		}
		return $this->resMsg("ok");
	}
	private function resMsg( $msg )
	{
		return  $msg == "ok"?
				array(
					'code'=>1 , 
					'msg' => 'ok'
				):
				array(
					'code'=>-1 , 
					'msg'=>$msg
				);
	}
	/*
	*	调用了外部方法

		字段配置数组
			检测是否有字段配置信息
	*/ 
	function checkColumnConfig($table ,$colume){
		return getTableColumnInfo($table , $colume , "colmunvalue");
	}
	/*
	   获取 form列表
	   $arrParam
	   		array(
				array(
					table=>'',
					type=>1, 1 input 2 select
					k=>status,
					v=>"状态"
				)
	   		)
	*/
	function getSearchFrom(){

		$arrParam = $this->_arrSearch;
		$resHtml = "";
		if(empty($arrParam)){
			return $resHtml;
		}
		foreach ($arrParam as $key => $value) {
			$phpTemp = "";
			if($value['type'] == 1){
				$phpTemp = file_get_contents($this->_pathTempFormInput);
			}elseif($value['type']==2){
				$phpTemp = file_get_contents($this->_pathTempFormSelect);
			}
			$phpTemp = str_replace("{{KEY}}", $value['k'], $phpTemp);
			$phpTemp = str_replace("{{VALUE}}", $value['v'], $phpTemp);
			$phpTemp = str_replace("{{TABLENAME}}", $value['table'], $phpTemp);
			$resHtml.=$phpTemp;
		}
		$resHtml.="_PN7_<button class='btn blue-madison' type='submit'>查询</button>";
		return $resHtml;
	}

}