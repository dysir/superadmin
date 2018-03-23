<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Config extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        checkRightPage();
    }

    function index()
    {
        $this->load->model("admin/Config_model");
        $allConfig = Config_model::getAllConfig();
        
        $data['config'] = $allConfig;
        
        $this->load->myview("admin/config/index", $data);
    }

    // 添加配置
    function ajaxAddConfig()
    {
        $cname = $this->input->post('cname', true);
        $ckey = $this->input->post('ckey', true);
        $cvalue = $this->input->post('cvalue');
        $mark = $this->input->post('mark', true);
        
        if ($cname == "" || $ckey == "" || $cvalue == "") {
            ajax(- 1, null, "参数不能为空");
        }
        $isExist = gconfig($ckey);
        if ($isExist != "") {
            ajax(- 2, null, "新添加的变量key已经存在，请更换一个key");
        }
        $this->load->model("admin/Config_model");
        $arr['cname'] = $cname;
        $arr['ckey'] = $ckey;
        $arr['cvalue'] = $cvalue;
        $arr['mark'] = $mark;
        $arr['ctime'] = date("Y-m-d H:i:s");
        $arr['mtime'] = date("Y-m-d H:i:s");
        $ret = Config_model::addConfig($arr);
        if (! $ret) {
            ajax(- 3, null, "添加失败");
        }
        ajax(1, null, "添加成功");
    }
    function ajaxGetConfig()
    {
        $id = $this->input->post('id', true);
        if ($id == "") {
            ajax(- 1, null, "参数不能为空");
        }
        $this->load->model("admin/Config_model");
        $config = Config_model::getConfigById($id);
        if (! $config) {
            ajax(- 2, null, "你删除的配置不存在");
        }
        ajax(1, $config , "success");
    }

    // 删除配置,系统配置不可以删除
    function ajaxDelConfig()
    {
        $id = $this->input->post('id', true);
        if ($id == "") {
            ajax(- 1, null, "参数不能为空");
        }
        $this->load->model("admin/Config_model");
        $config = Config_model::getConfigById($id);
        if (! $config) {
            ajax(- 2, null, "你删除的配置不存在");
        }
        if ($config['type'] == 1) {
            ajax(- 4, null, "系统配置不可以删除");
        }
        $ret = Config_model::delConfigById($id);
        if (! $ret) {
            ajax(- 3, null, "删除失败");
        }
        ajax(1, null, "删除成功");
    }

    // 更新配置，系统配置不可以更改ckey
    function ajaxUpdateConfig()
    {
        $cname = $this->input->post('cname', true);
        $ckey = $this->input->post('ckey', true);
        $cvalue = $this->input->post('cvalue');
        $mark = $this->input->post('mark', true);
        $id = $this->input->post('id', true);
        
        if ($cname == "" || $ckey == "" || $cvalue == "" || $id == "") {
            ajax(- 1, null, "参数不能为空");
        }
        $this->load->model("admin/Config_model");
        $config = Config_model::getConfigById($id);
        if (! $config) {
            ajax(- 2, null, "你更新的配置不存在");
        }
        if ($config['type'] == 1) { // 系统内置配置不可以更改ckey
            $arr['cname'] = $cname;
            $arr['cvalue'] = $cvalue;
            $arr['mark'] = $mark;
            $arr['mtime'] = date("Y-m-d H:i:s");
        } else {
            $arr['cname'] = $cname;
            $arr['ckey'] = $ckey;
            $arr['cvalue'] = $cvalue;
            $arr['mark'] = $mark;
            $arr['mtime'] = date("Y-m-d H:i:s");
        }
        $w['id'] = $id;
        
        $ret = Config_model::updateConfigById($w, $arr);
        if (! $ret) {
            ajax(- 3, null, "更新失败");
        }
        ajax(1, null, "更新成功");
    }
}