<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kb_article extends MY_Controller {

	function __construct() {
		parent::__construct();
		$class = $this->router->fetch_class();
		$this->load->model("{$class}_model", "model", true);
	}
	function index() {

		$this->load->library('page');
		$page = new Page();
		$page->num = 50;
		$arrLimit = $page->getlimit();
		$arrWhere = $this->input->get(null , true);
		$arrWhere['ls'] = $arrLimit['ls'];
		$arrWhere['le'] = $arrLimit['le'];

		$arrRes = $this->model->getList($arrWhere);

		$data['list'] = $arrRes['list'];
		$data['page_view'] = $page->view(array(
			'all' => $arrRes['num'],
		));

		$this->load->myview("kb_article/index", $data);
	}
	//获取预览
	function getView(){
		$intId = $this->input->get("id");
		$arrArticle = $this->model->getRow(array(
			'id'=>$intId
		));
		if(empty($arrArticle)){
			ajax(-1 , array() , "不存在");
		}

		ajax(1 , $arrArticle , "OK");
	}
	function updateArticle(){
		$intId = $this->input->get("id");
		$this->load->driver('cache');
		
		$data = array();

		if(!empty($intId)){
			$jsonData = $this->cache->redis->get("linkarticle".$intId);
			!empty($jsonData)&&$data = json_decode($jsonData,true);
			$data['id'] = $intId;
			if(empty($data['mark_content'])){
				$data = $this->model->getRow(array(
					'id'=>$intId
				));
			}
		}else{
			$jsonData = $this->cache->redis->get("linkarticle");
			!empty($jsonData)&&$data = json_decode($jsonData,true);
		}
	
		$this->load->myview("kb_article/updateArticle", $data);
	}
	function addupdateArticle(){
		$strMarkContent = $this->input->post("mark_content");
		$strHtmlContent = $this->input->post("html_content");
		$strTitle = $this->input->post("title");
		$intId = $this->input->post("id");

		$boolRes = $this->model->updateTable(array(
			'update'=>array(
				"mark_content"=>$strMarkContent,
				"title"=>$strTitle,
				"html_content"=>$strHtmlContent,
			),
			'where'=>array(
				"id"=>$intId
			),
		));
		$this->load->driver('cache');

		if(!$boolRes){
			ajax(-1 , array(),"数据库错误");
		}
		$this->cache->redis->delete("linkarticle".$intId);
		ajax(1 , array() , "OK");
	}
	function saveArticle(){
		$intId = $this->input->post("id");
		$strMarkContent = $this->input->post("mark_content");
		$strTitle = $this->input->post("title");
		$this->load->driver('cache');
		$strRedis = empty($intId)?"linkarticle":"linkarticle".$intId;

		$this->cache->redis->save( $strRedis,json_encode(array(
			'title'=>$strTitle,
			'mark_content'=>$strMarkContent
		)) , 86400*30);
	}
	function addArticle(){
		$strMarkContent = $this->input->post("mark_content");
		$strHtmlContent = $this->input->post("html_content");
		$strTitle = $this->input->post("title");

		$boolRes = $this->model->insertTable(array(
			"mark_content"=>$strMarkContent,
			"title"=>$strTitle,
			"html_content"=>$strHtmlContent,
		));
		$this->load->driver('cache');

		if(!$boolRes){
			ajax(-1 , array(),"数据库错误");
		}
		$this->cache->redis->delete("linkarticle");
		ajax(1 , array() , "OK");

	}
	function articleInfoById(){
		$intId = $this->input->get("id");
		$arrRow = $this->model->getRow(array(
			'id'=>$intId
		));

		$this->load->view("kb_article/articleinfo",$arrRow);
	}
}
?>