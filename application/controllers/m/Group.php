<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Group extends MY_Controller {

	function __construct() {
		parent::__construct();
		//超级管理员 或 管理员有访问权限
		checkRightPage();
		$class = $this->router->fetch_class();
		$this->load->model("admin/{$class}_model", "model");
	}
	function index() {
		$arrUser = $this->model->getUserGroup();
		$data['list'] = $arrUser;
		$this->load->myview('admin/manage/group', $data);
	}
    //添加权限组
	function ajaxAddGroup() {
		$gname = $this->input->get("gname", true);
		if (!$gname) {
			ajax(-1, array(), '缺少参数');
		}
		$arrWhere = array(
			'gname' => $gname,
		);
		$arrUser = $this->model->getUserGroup($arrWhere);
		if ($arrUser) {
			ajax(-1, array(), '权限组已存在');
		}

		$arrInsert = array(
			'gname' => $gname,
			'ctime' => date("Y-m-d H:i:s"),
			'mtime' => date("Y-m-d H:i:s"),
		);
		$bool = $this->model->addGroup($arrInsert);
		if (!$bool) {
			ajax(-1, array(), "添加失败");
		}
		ajax(1, array(), 'success');
	}
    //编辑权限
    function editGroupRight(){
        //参数 group right 分别为 管理组id数组 right action 数组
        $id = $this->input->get('id', true);
        if (!$id) {
            ajax(-1, array(), '缺少参数');
        }
        $arrWhere = array(
            'id' => $id,
        );
        $arrUserGroup = $this->model->getUserGroup($arrWhere);
        if (empty($arrUserGroup)) {
            errorpage( "不存在的权限组");
        }

        $this->load->model('admin/Manage_model');

        $arrWhere = array(
            'system' => 2,
        );

        $arrAllMenuList = $this->Manage_model->getMenu($arrWhere);

        $arrAllMenuKv = array();
        $arrAllMenulink = array();
        //所有目录
        foreach ($arrAllMenuList as $arrMenu) {

            !isset($arrAllMenulink[$arrMenu['id']]) && $arrAllMenulink[$arrMenu['id']] = array();
            if (empty($arrMenu['parent'])) {
                $arrMenu['_list'] = &$arrAllMenulink[$arrMenu['id']];
                $arrAllMenuKv[] = $arrMenu;
            } else {
                $arrAllMenulink[$arrMenu['parent']][] = $arrMenu;
            }
        }
        //所有权限
        $arrAction = $this->Manage_model->getAction();
        $actionAllList = array();
        if (!empty($arrAction)) {
            foreach ($arrAction as $value) {
                $actionAllList[$value['parent']][] = $value;
            }
        }

        $arrRight = $this->model->getGroupRight($id);
        $arrCurentRight = array();
        foreach ($arrRight as $key => $value) {
            $arrCurentRight[] = $value['pmid'];
        }
        $arrCurent = array(
            'mname' => "权限编辑",
            'url' => '/m/group/index',
            'parent' => 1,
        );
        $data['_current'] = $arrCurent;
        $data['arrCurentRight'] = $arrCurentRight;

        //所有目录和权限
        $data['actionAllList'] = $actionAllList;
        $data['arrAllMenuKv'] = $arrAllMenuKv;
        $this->load->myview("admin/manage/groupright", $data);
    }


	function saveUserGroupRight() {

        $ugid = $this->input->post('ugid', true);
        $postRight = $this->input->post('right', true);

        $arrWhere = array(
            'id' => $ugid,
        );
        $arrUser = $this->model->getUserGroup($arrWhere);
        if (empty($arrUser)) {
            ajax(-1, array(), "权限组不存在");
        }
        $insert = array();

        if (!empty($postRight)) {
            foreach ($postRight as $key => $pmid) {
                if(intval( $pmid) <= 0)
                {
                    continue;
                }
                $insert[] = array(
                    'ugid'=>$ugid,
                    'pmid'=>$pmid
                );
            }
        }

        $bool = $this->model->updateGroupRight($insert, $ugid);
        if (!$bool) {
            ajax(-5, array(), '更新失败');
        }
        ajax(1, array(), 'success');
    }
    //删除权限组
	function ajaxDelGroup() {

		$id = $this->input->get("id", true);
		if (empty($id)) {
			ajax(-1, array(), '缺少参数');
		}
        $arrWhere = array(
            'id' => $id,
        );
		$arrUser = $this->model->getUserGroup($arrWhere);
		if (!$arrUser) {
			ajax(-1, array(), '权限组不存在');
		}

		$bool = $this->model->deleteGroup($id);

		if (!$bool) {
			ajax(-1, array(), "删除失败");
		}

		ajax(1, array(), 'success');
	}
}