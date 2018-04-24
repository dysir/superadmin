<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $class = $this->router->fetch_class();
        
        $this->load->model("{$class}_model", "model", true);
    }
    function index(){
    	//权限判断
    	checkRightPage("/test/order/index");
    	$arrWhere = $this->input->get(null, true);
    	$this->load->library('page');

		$page = new Page();
		$page->num = 5;
		$arrLimit = $page->getlimit();
		$arrWhere['ls'] = $arrLimit['ls'];
		$arrWhere['le'] = $arrLimit['le'];

		$arrRes = $this->model->getOrderlist($arrWhere);

		$all = $arrRes['num'];
		$user = $this->model->getUser();
		
		$newdata['user'] = $user;
		$cuser = $this->load->view('test/user', $newdata,true);
		
		$data['list'] = $arrRes['list'];
		$data['cuser'] = $cuser;
		$data['page_view'] = $page->view(array(
			'all' => $all,
		));
		$this->load->myview('test/order', $data);
    }
    
    
    function ajaxChangeUser() {
        $id = $this->input->post("id",true);
        if (intval($id)<1) {
            ajax(-1,null,"参数错误");
        }
        
        $user = $this->model->getUserById($id);
        if (!$user) {
            ajax(-2,null,"切换的用户不存在或者权限太高你无法操作");
        }
        $this->load->model("admin/user_model");
        $this->user_model->wsession($user);
        ajax(1,null,"OK");
    }
}