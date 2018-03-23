<?php
class Createtemp extends MY_Controller {

	function __construct() {
		parent::__construct();
		//超级管理员 或 管理员有访问权限
		checkRightPage();
		$class = $this->router->fetch_class();

		$this->load->model("admin/{$class}_model", "model");
	}

	function index()
	{
        $list = $this->model->getTablelist();

        $data['list'] = $list;
		$this->load->myview("admin/manage/autotemp",$data);
	}
	function creater()
	{
		checkRightPage("superadmin");
		$arrPost = $this->input->post(null, true);

		if(empty($arrPost['maintable'])){
			ajax(-1 , array(), "缺少主表");
		}

		if(empty($arrPost['filename'])){
			$config['_filename'] = $arrPost['maintable'];
		}else{
			$config['_filename'] =$arrPost['filename'];
		}

		$this->load->library("autotemp");

		$config['_datafield'] = $arrPost;
		
		$res = $this->autotemp->creater($config);

		if($res['code']!=1)
		{
			ajax(-1 , array() , $res['msg']);
		}
		$resinfo = $this->autotemp->resinfo();

		ajax(1 , $resinfo , "success");

	}
	function getTablecolumn(){
		$table = $this->input->get('maintable' , true);
		$columnlist = $this->model->getTablecolumn($table);
		$columnview = $this->load->view('admin/manage/createtemp/column' , array('list'=>$columnlist) , true);
		ajax(1 , array('columnview'=>$columnview) , 'success');
	}
	//获取关联表页面
	function getJoinTable(){
		$table = $this->input->get('maintable' , true);


		$list = $this->model->getTablelist();
		foreach ($list as $key => $value) {
			if($value['table_name'] == $table){
				unset($list[$key]);
			}
		}

		$jointableview = $this->load->view('admin/manage/createtemp/jointable' , array('list'=>$list) , true);
		ajax(1 , array('jointableview'=>$jointableview) , 'success');
	}
	//获取关联字段
	function getJoinTablecolumn(){
		$table = $this->input->get('jointable' , true);
		$columnlist = $this->model->getTablecolumn($table);
		$columnview = $this->load->view('admin/manage/createtemp/joincolumn' , array('list'=>$columnlist) , true);
		ajax(1 , array('columnview'=>$columnview) , 'success');
	}

}