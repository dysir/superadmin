<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		/*
			只有超级管理员 和管理员 有访问此目录权限
		*/
		checkRightPage();

		$class= $this->router->fetch_class();
		$this->load->model("admin/{$class}_model" , "model" , true);
	}
	/*
		用户管理相关
		用户列表
	*/
	// function user()
	// {
	// 	$this->load->library('page');

	// 	$page = new Page;
	// 	$page->num = 5;
	// 	$arrLimit = $page->getlimit();
	// 	$arrWhere['ls'] = $arrLimit['ls'];
	// 	$arrWhere['le'] = $arrLimit['le'];

	// 	$arrRes = $this->model->getManageUserByWhere($arrWhere);

	// 	$all = $arrRes['num'];

	// 	$data['list'] = $arrRes['list'];
	// 	$data['page_view'] = $page->view(array('all'=>$all));

	// 	$this->load->myview('manage/user' , $data);
	// }


	/*
		目录管理

	*/
	function navigation()
	{
		/*
			获取目录列表
		*/
		$arrWhere = array(
			'type'=>1
		);
		$arrMenuList = $this->model->getMenuByWhere($arrWhere);
		$menulist = array();

		if (! empty($arrMenuList)) {
            $arrLinkMenu = array();
            foreach ($arrMenuList as $key => $arrMenu) {
                ! isset($arrLinkMenu[$arrMenu['id']]) ? $arrLinkMenu[$arrMenu['id']] = array() : "";
                
                if (empty($arrMenu['parent'])) {
                    $arrMenu['_list'] = &$arrLinkMenu[$arrMenu['id']];
                    $menulist[] = $arrMenu;
                } else {
                    $arrLinkMenu[$arrMenu['parent']][] = $arrMenu;
                }
            }
        }
        /*
         * 获取权限列表
         */
        $arrAction = $this->model->getAction();
        
        $actionlist = array();
        
        if (! empty($arrAction)) {
            foreach ($arrAction as $value) {
                $actionlist[$value['parent']][] = $value;
            }
        }
        $data['actionlist'] = $actionlist;
        $data['menulist'] = $menulist;
        
        $this->load->myview('admin/manage/navigation', $data);
    }

    // 添加一级目录
    function addFirstMenu()
    {
        $arrGet = $this->input->get(null, true);
        if (empty($arrGet['mname'])) {
            ajax(- 1, array(), '必须填写目录名');
        }
        if (empty($arrGet['icon'])) {
            ajax(- 1, array(), '必须填写图标');
        }
        if (empty($arrGet['radio'])) {
            ajax(- 1, array(), '必须选择状态');
        }
        
        if (! empty($arrGet['mname'])) {
            $arrWhere = array(
                'mname' => $arrGet['mname']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '目录名已存在，请重新定义');
            }
        }
        if (! empty($arrGet['url'])) {
            $arrWhere = array(
                'url' => $arrGet['url']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '访问地址已存在，请重新定义');
            }
        }
        if (! empty($arrGet['action'])) {
            $arrWhere = array(
                'action' => $arrGet['action']
            );
            $kwa = c("keyword_action");

            if(in_array(strtolower($arrGet['action']), $kwa)){
                ajax(- 1, array(), '权限别名为关键词，请重新定义');
            }
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '权限别名已存在，请重新定义');
            }
        }
        // if (empty($arrGet['action'])) {
        //     ajax(- 1, array(), '权限别称必须填写');
        // }
        $arrInsert = array(
            "mname" => $arrGet['mname'],
            "url" => empty($arrGet['url']) ? "" : $arrGet['url'],
            "icon" => $arrGet['icon'],
            "action" => empty($arrGet['action']) ? null : $arrGet['action'],
            "parent" => 0,
            "type" => 1,
            "status" => $arrGet['radio']
        );
        
        $bool = $this->model->insertMenu($arrInsert);
        if (! $bool) {
            ajax(- 1, array(), '数据库错误');
        }
        
        ajax(1, array(
            'id' => $bool
        ), 'success');
    }

    // 添加二级目录
    function addsecondmenu()
    {
        $arrGet = $this->input->get(null, true);

        $system = $this->issystemmenu($arrGet['parent']);

        if($system && !checkRight("superadmin"))
        {
            ajax(- 1, array(), '系统目录，没有操作权限');
        }
        if (empty($arrGet['parent'])) {
            ajax(- 1, array(), '缺少父级目录ID');
        }
        if (empty($arrGet['url'])) {
            ajax(- 1, array(), '缺少访问地址');
        }
        if (empty($arrGet['mname'])) {
            ajax(- 1, array(), '必须填写目录名');
        }
        if (empty($arrGet['icon'])) {
            ajax(- 1, array(), '必须填写图标');
        }
        if (empty($arrGet['radio'])) {
            ajax(- 1, array(), '必须选择状态');
        }
        
        if (! empty($arrGet['mname'])) {
            $arrWhere = array(
                'mname' => $arrGet['mname']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '目录名已存在，请重新定义');
            }
        }
        if (! empty($arrGet['url'])) {
            $arrWhere = array(
                'url' => $arrGet['url']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '访问地址已存在，请重新定义');
            }
        }
        if (! empty($arrGet['action'])) {
            $arrWhere = array(
                'action' => $arrGet['action']
            );
            $kwa = c("keyword_action");

            if(in_array(strtolower($arrGet['action']), $kwa)){
                ajax(- 1, array(), '权限别名为关键词，请重新定义');
            }
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '权限别名已存在，请重新定义');
            }
        }
        $arrInsert = array(
            "mname" => $arrGet['mname'],
            "parent" => $arrGet['parent'],
            "url" => $arrGet['url'],
            "icon" => $arrGet['icon'],
            "action" => empty($arrGet['action']) ? $arrGet['url'] : $arrGet['action'],
            "type" => 1,
            "status" => $arrGet['radio']
        );
        
        $bool = $this->model->insertMenu($arrInsert);
        if (! $bool) {
            ajax(- 1, array(), '数据库错误');
        }
        
        ajax(1, array(), 'success');
    }

    // 删除目录
    function deleteMenu()
    {
        $id = $this->input->get('id', true);


        $system = $this->issystemmenu($id);

        if($system && !checkRight("superadmin"))
        {
            ajax(- 1, array(), '系统目录，没有操作权限');
        }

        $arrWhere = array(
            'id' => $id
        );
        $arrRes = $this->model->getMenuByWhere($arrWhere);
        if (empty($arrRes[0])) {
            ajax(- 1, array(), "该条目不存在");
        }
        $arrWhere = array(
            'parent' => $id,
            'type' => 1
        );
        $arrRes = $this->model->getMenuByWhere($arrWhere);
        if (! empty($arrRes)) {
            ajax(- 1, array(), "请先删除子目录");
        }
        $arrWhere = array(
            'id' => $id
        );
        $bool = $this->model->deleteMenuByWhere($arrWhere);
        if (! $bool) {
            ajax(- 1, array(), "删除失败");
        }
        // 删除旗下权限
        $arrWhere = array(
            'parent' => $id,
            'type' => 2
        );
        $bool = $this->model->deleteMenuByWhere($arrWhere);
        if (! $bool) {
            ajax(- 1, array(), "权限删除失败 ，点击目录整理 ，删除多余配置！");
        }
        ajax(1, array(), 'success');
    }

    // 获取目录内容
    function getMenu()
    {
        $id = $this->input->get('id', true);
        $arrWhere = array(
            'id' => $id,
            'type' => 1
        );
        $arrRes = $this->model->getMenuByWhere($arrWhere);
        if (empty($arrRes[0])) {
            ajax(- 1, array(), "目录不存在");
        }
        ajax(1, $arrRes[0], 'success');
    }

    // 修改目录内容
    function editFirstMenu()
    {
        $arrGet = $this->input->get(null, true);

        if (empty($arrGet['id'])) {
            ajax(- 1, array(), '参数错误');
        }

        $id = $arrGet['id'];

        $system = $this->issystemmenu($id);

        if($system && !checkRight("superadmin"))
        {
            ajax(- 1, array(), '系统目录，没有操作权限');
        }


        if (empty($arrGet['mname'])) {
            ajax(- 1, array(), '必须填写目录名');
        }
        if (empty($arrGet['icon'])) {
            ajax(- 1, array(), '必须填写图标');
        }
        if (empty($arrGet['radio'])) {
            ajax(- 1, array(), '必须选择状态');
        }
        
        if (! empty($arrGet['mname'])) {
            $arrWhere = array(
                'id <>' => $id,
                'mname' => $arrGet['mname']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '目录名已存在，请重新定义');
            }
        }
        if (! empty($arrGet['url'])) {
            $arrWhere = array(
                'id <>' => $id,
                'url' => $arrGet['url']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '访问地址已存在，请重新定义');
            }
        }
        if (! empty($arrGet['action'])) {
            $arrWhere = array(
                'id <>' => $id,
                'action' => $arrGet['action']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '权限别名已存在，请重新定义');
            }
        }
        $arrEdit = array(
            "mname" => $arrGet['mname'],
            "action" => empty($arrGet['action']) ? null : $arrGet['action'],
            "url" => empty($arrGet['url']) ? "" : $arrGet['url'],
            "icon" => $arrGet['icon'],
            "status" => $arrGet['radio']
        );
        
        $arrWhere = array(
            'id' => $id
        );
        $bool = $this->model->EditMenu($arrEdit, $arrWhere);
        if (! $bool) {
            ajax(- 1, array(), '数据库错误');
        }
        ajax(1, array(), 'success');
    }

    // 修改二级目录内容
    function editSecondMenu()
    {
        $arrGet = $this->input->get(null, true);
        if (empty($arrGet['id'])) {
            ajax(- 1, array(), '参数错误');
        }
        $id = $arrGet['id'];

        $system = $this->issystemmenu($id);

        if($system && !checkRight("superadmin"))
        {
            ajax(- 1, array(), '系统目录，没有操作权限');
        }

        if (empty($arrGet['mname'])) {
            ajax(- 1, array(), '必须填写目录名');
        }
        if (empty($arrGet['url'])) {
            ajax(- 1, array(), '必须填写访问目录');
        }
        if (empty($arrGet['icon'])) {
            ajax(- 1, array(), '必须填写图标');
        }
        if (empty($arrGet['radio'])) {
            ajax(- 1, array(), '必须选择状态');
        }
        $arrWhere = array(
            'id <>' => $id,
            'mname' => $arrGet['mname']
        );
        
        $arrRes = $this->model->getMenuByWhere($arrWhere);
        if (! empty($arrRes[0])) {
            ajax(- 1, array(), '目录名已存在，请重新定义');
        }
        $arrWhere = array(
            'id <>' => $id,
            'url' => $arrGet['url']
        );
        
        $arrRes = $this->model->getMenuByWhere($arrWhere);
        if (! empty($arrRes[0])) {
            ajax(- 1, array(), '访问地址已存在，请重新定义');
        }
        empty($arrGet['action']) ? $arrGet['action'] = $arrGet['url'] : "";
        
        $arrWhere = array(
            'id <>' => $id,
            'action' => $arrGet['action']
        );
        $arrRes = $this->model->getMenuByWhere($arrWhere);
        if (! empty($arrRes[0])) {
            ajax(- 1, array(), '权限别名已存在，请重新定义');
        }
        $arrEdit = array(
            "mname" => $arrGet['mname'],
            "action" => $arrGet['action'],
            "url" => $arrGet['url'],
            "icon" => $arrGet['icon'],
            "status" => $arrGet['radio']
        );
        $arrWhere = array(
            'id' => $id
        );
        $bool = $this->model->EditMenu($arrEdit, $arrWhere);
        if (! $bool) {
            ajax(- 1, array(), '数据库错误');
        }
        ajax(1, array(), 'success');
    }

    // 添加权限
    function addactionmenu()
    {
        $arrGet = $this->input->get(null, true);
        if (empty($arrGet['parent'])) {
            ajax(- 1, array(), '缺少父级目录ID');
        }


        $system = $this->issystemmenu($arrGet['parent']);

        if($system && !checkRight("superadmin"))
        {
            ajax(- 1, array(), '系统目录，没有操作权限');
        }
        
        
        if (empty($arrGet['action'])) {
            ajax(- 1, array(), '必须填写权限别名');
        }
        $kwa = c("keyword_action");

        if(in_array(strtolower($arrGet['action']), $kwa)){
            ajax(- 1, array(), '权限别名为关键词，请重新定义');
        }
        if (! empty($arrGet['mname'])) {
            $arrWhere = array(
                'mname' => $arrGet['mname']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '名称已存在，请重新定义');
            }
        }
        $arrWhere = array(
            'action' => $arrGet['action']
        );
        
        $arrRes = $this->model->getMenuByWhere($arrWhere);
        if (! empty($arrRes[0])) {
            ajax(- 1, array(), '权限别名已存在，请重新定义');
        }
        
        $arrInsert = array(
            "mname" => empty($arrGet['mname']) ? null : $arrGet['mname'],
            "parent" => $arrGet['parent'],
            "url" => null,
            "icon" => null,
            "action" => $arrGet['action'],
            "type" => 2,
            "status" => 1
        );
        $bool = $this->model->insertMenu($arrInsert);
        if (! $bool) {
            ajax(- 1, array(), '数据库错误');
        }
        
        ajax(1, array(), 'success');
    }
    //获取排序目录
    function getSortMeun()
    {
        $parent = $this->input->get("parent" , true);
        //一级目录排序
        if(!$parent || intval($parent )< 1)
        {
            $arrWhere= array(
                'parent'=>0,
            );
            $menulist = $this->model->getMenu($arrWhere);
        }else{
            $arrWhere= array(
                'parent'=>$parent,
            );
            $menulist = $this->model->getMenu($arrWhere);
        }
        $data['sortmenulist'] = $menulist;
        ajax(1 , $data , 'success');
    }
    function updateSortMeun(){
        $arrSort = $this->input->post("sortarr" , true);

        if(!empty($arrSort))
        {
            foreach ($arrSort as $key => $value) {
                $arrWhere = array(
                    'id'=>$value['id']
                );
                $arrEdit = array(
                    'sort'=>$value['sort']
                );
                $this->model->EditMenu($arrEdit ,$arrWhere );
            }
        }
        ajax(1 , array() , 'success');
    }
    //是否为系统目录 是 true
    function issystemmenu($id)
    {
        $list = $this->model->getMenuByWhere(array('id'=>$id));
        if(empty($list[0]) || $list[0]['system']!=1)
        {
            return false;
        }
        return true;
    }
}