<?php
/*
	公共数据处理方法
*/
class TableDataFunc{
	//传入时间错 或 可格式化的字符串
	function toDate($strTime){
		if(!empty($strTime) && preg_match("/\d{10}/", $strTime)){
			return date("Y-m-d H:i:s" , $strTime);
		}
		return date("Y-m-d H:i:s" , strtotime($strTime));
	}
}