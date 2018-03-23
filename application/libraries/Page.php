<?php
class Page{

	// 每页条数
	public $num = 50;
	//当前页 默认加在 分页 get 请求中 不需要配置
	public $current_page = 1;
	/*
		初始化获取当前页
			参数 
				current_page
			优先 get post $this->current_page
	*/
	function __construct()
	{
		//初始化当前页
		if(!empty($_GET['current_page']) && intval($_GET['current_page']) >=1 )
		{
			$this->current_page = intval($_GET['current_page']);
		}
	}

	/*
		return 
			ls 起始下标 
			le 偏移量

		用于sql limit 查询
	*/
	function getlimit()
	{
		$ls = ($this->current_page - 1) * $this->num;

		return array(
			'ls'=>$ls,
			'le'=>$this->num
		);
	}
	/*
		返回前端显的分页
		param
			//可选参数 总页数
			$arrPage = array('all'=>总条数 )
			//get 可选携带查询条件
			$arrWhere = array('id'=>1,'type'=>1)
	*/
	function view( $arrPage = array('all'=> 0 ) , $arrWhere = array() )
	{
		$arrGet = $_GET;

		if(!empty($arrGet))
		{
			foreach ($arrGet as $key => $value) {
				!isset($arrWhere[$key]) && $arrWhere[$key] = $value;
			}
		}
	    $num = empty($this->num) ? 50 : $this->num;
	    //总页数
	    $all_page = empty($arrPage['all']) ? 1 : intval(ceil($arrPage['all'] / $num));
	    //当前页
	    $current_page = empty($this->current_page) ? 1 : $this->current_page;

	    if (! empty($arrWhere['current_page']))
	        unset($arrWhere['current_page']);
	    $strWhere = ! empty($arrWhere) ? "&" . http_build_query($arrWhere) : "";
	    $strview = "<ul  class='pagination'>";
	    $strview .= "<li><a herf'#'>第{$current_page}页</a></li>";
	    $strview .= "<li><a href='?current_page=1" . $strWhere . "'>«</a></li>";
	    
	    if ($all_page > 0) {
	        $ii = 1;
	        if ($all_page > 5 && $current_page + 2 >= $all_page) {
	            $ii = $all_page - 4;
	        } elseif ($all_page > 5 && $current_page + 2 < $all_page && $current_page > 3) {
	            $ii = $current_page - 2;
	        }
	        
	        $end = $current_page < 3 ? 5 : $current_page + 2;
	        
	        for (; $ii <= $all_page && $ii <= $end; $ii ++) {
	            $active = $current_page == $ii ? "style='background-color: #e8ecf1;'" : "";
	            $strview .= "<li><a {$active} href='?current_page=" . $ii . $strWhere . "'>" . $ii . "</a></li>";
	        }
	    }
	    $strview .= "<li><a href='?current_page=" . $all_page . $strWhere . "'>»</a></li>";

	    if(!empty($arrPage['all']))
	    {
	    	$strview .= "<li><a herf='#'>共{$arrPage['all']}条</a></li></ul>";
	    }
	    
	    return $strview;
	}

}