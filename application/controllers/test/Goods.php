<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Goods extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $class = $this->router->fetch_class();
        
        $this->load->model("{$class}_model", "model", true);
    }
    function index(){
    	//权限判断
    	checkRightPage("/test/goods/index");

    	$this->load->library('page');

		$page = new Page();
		$page->num = 5;
		$arrLimit = $page->getlimit();
		$arrWhere['ls'] = $arrLimit['ls'];
		$arrWhere['le'] = $arrLimit['le'];

		$arrRes = $this->model->getGoodslist($arrWhere);

		$all = $arrRes['num'];

		$data['list'] = $arrRes['list'];
		$data['page_view'] = $page->view(array(
			'all' => $all,
		));
		$this->load->myview('test/goods', $data);
    }
    function ajaxAddGoods()
    {
    	checkRightPage("addgoods");
    	$name = $this->input->post("name", true);
		$price = $this->input->post("price", true);
		$price = intval($price);
		$num = $this->input->post("num", true);
		if ($name == "" || $price == "") {
			ajax(-1, null, "参数不能为空");
		}

		$bool = $this->model->getGoodsByWhere(array('name'=>$name));
		if($bool)
		{
			ajax(-1 , array() , '商品名重复');
		}
		$arrInsert = array(
			'name'=>$name,
			'price'=>$price,
			'num'=>empty($num)?0:intval($num),
			'status'=>1,
			'ctime'=>date("Y-m-d H:i:s"),
			'mtime'=>date("Y-m-d H:i:s"),
		);
		$this->model->addGoods($arrInsert);
		ajax(1, array(),"success");
    }
    function ajaxEditGoods(){
    	checkRightPage("editgoods");

    	$name = $this->input->post("name", true);
		$price = $this->input->post("price", true);
		$price = intval($price);
		$num = $this->input->post("num", true);
		$id = $this->input->post("id", true);
		if ($name == "" || $price == "") {
			ajax(-1, null, "参数不能为空");
		}
		$arrWhere = array(
			'name'=>$name,
			'id <>'=>$id
		);
		$bool = $this->model->getGoodsByWhere($arrWhere);
		if($bool)
		{
			ajax(-1 , array() , '商品名重复');
		}
		$arrInsert = array(
			'name'=>$name,
			'price'=>$price,
			'num'=>empty($num)?0:intval($num),
			'mtime'=>date("Y-m-d H:i:s"),
		);
		$this->model->editGoods($arrInsert , array('id'=>$id));
		ajax(1, array(),"success");
    }
    function ajaxGetGoods(){
    	checkRightPage("editgoods");

		$id = $this->input->get("id", true);
    	$arrGoods = $this->model->getGoodsByWhere(array('id'=>$id) );
		if (empty($arrGoods)) {
			ajax(-1, array(), "商品异常");
		}
		ajax(1, $arrGoods, 'success');
    }

	function deleteGoods() {
    	checkRightPage("deletegoods");

		$id = $this->input->get("id", true);
		if (!$id) {
			ajax(-1, array(), "缺少参数");
		}
		$arrGoods = $this->model->getGoodsByWhere(array('id'=>$id) );
		if (empty($arrGoods)) {
			ajax(-1, array(), "商品异常");
		}

		$bool = $this->model->deleteGoodsById($id);

		if (!$bool) {
			ajax(-1, array(), "删除失败");
		}

		ajax(1, array(), 'success');

	}
	function editGoodsStatus(){
    	checkRightPage("pullgoods");

		$id = $this->input->get("id", true);
		if (!$id) {
			ajax(-1, array(), "缺少参数");
		}
		$arrGoods = $this->model->getGoodsByWhere(array('id'=>$id) );
		if (empty($arrGoods)) {
			ajax(-1, array(), "商品异常");
		}
		$arrEdit = array(
			'status'=>$arrGoods['status']==1?2:1,
			'mtime'=>date("Y-m-d H:i:s"),
		);
		$this->model->editGoods($arrEdit , array('id'=>$id));
		ajax(1, array(),"success");
	}
}