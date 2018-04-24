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

        $arrCreateloglist = $this->model->getCreateLog(['status'=>1]);

        $data['list'] = $list;
        $data['arrCreateloglist'] = $arrCreateloglist;

		$this->load->myview("admin/manage/autotemp",$data);
	}
	function creater()
	{
		checkRightPage("superadmin");
		$arrPost = $this->input->post(null, true);

		if(empty($arrPost['maintable'])){
			ajax(-1 , array(), "缺少主表");
		}
		$config['_filename'] = empty($arrPost['filename'])?$arrPost['maintable']:$arrPost['filename'];

		$this->load->library("autotemp");

		$config['_datafield'] = $arrPost;
		
		$res = $this->autotemp->creater($config);

		if($res['code']!=1)
		{
			ajax(-1 , array() , $res['msg']);
		}
		$resinfo = $this->autotemp->resinfo();

		$file = implode(",", $resinfo['file']);
		$arrCreateloglist = $this->model->getCreateLog(['file'=>$file,'status'=>1]);

		if(!empty($arrCreateloglist[0])){
			$id = $arrCreateloglist[0]['id'];
			$file_ctime = $arrCreateloglist[0]['ctime'];
		}else{
			$arrInsert = array(
				"authname"=>"",
				"dirname"=>"/".$config['_filename']."/index",
				"table"=>"",
				"file"=>$file,
				"ctime"=>date("Y-m-d H:i:s"),
			);
			$id = $this->model->insertCreateLog($arrInsert);
			$file_ctime = date("Y-m-d H:i:s");
		}

		$resinfo['file_id'] = $id;
		$resinfo['file_ctime'] = $file_ctime;
		ajax(1 , $resinfo , "success");

	}
	function getTablecolumn(){
		$table = $this->input->get('maintable' , true);
		$columnlist = $this->model->getTablecolumn($table);
		$columnview = $this->load->view('admin/manage/createtemp/column' , array('list'=>$columnlist) , true);
		ajax(1 , array('columnview'=>$columnview) , 'success');
	}
	function deletefile(){
		$id = $this->input->get('id', true);
		if(empty($id)){
			ajax(-1 , '','缺少参数');
		}
		$arrCreateloglist = $this->model->getCreateLog(['id'=>$id,'status'=>1]);
		if(empty($arrCreateloglist[0])){
			ajax(-1 , '','不存在的记录');
		}
		$strfile = $arrCreateloglist[0]['file'];
		$arrFile = explode(",", $strfile);
		$arrFilelog = [];
		foreach ($arrFile as $file) {

			$bool = file_exists($file) && unlink($file);
			$arrFilelog[$file] = $bool;
		}
		$strHtml = "";
		foreach ($arrFilelog as $key => $value) {
			$strHtml.=$key.($value?" 移除成功":" <span style='color:red'>移除失败(请手动移除)</span>")."\n";
		}
		$arrUpdate = array(
			'status'=>9
		);
		$arrWhere = array(
			'id'=>$id
		);
		$this->model->updateCreatelog($arrUpdate,$arrWhere);
		ajax(1 , '',$strHtml);
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