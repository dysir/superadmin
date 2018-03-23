<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        checkRightPage();
        $class = $this->router->fetch_class();
        
        $this->load->model("admin/{$class}_model", "model", true);
    }

    function index()
    {
        wlog("访问日志");
        $st = $this->input->get("st", true);
        $et = $this->input->get("et", true);
        
        $this->load->library('page');
        
        $page = new Page();
        $page->num = 50;
        
        $arrLimit = $page->getlimit();
        
        $arrWhere['ls'] = $arrLimit['ls'];
        $arrWhere['le'] = $arrLimit['le'];
        
        $st = $st != "" ? $st : date("Y-m-d 00:00:00",time()-86400*7);
        $et = $et != "" ? $et : date("Y-m-d 23:59:59");
        
        $arrWhere['st'] = $st;
        $arrWhere['et'] = $et;
        
        $arrRes = Log_model::getLog($arrWhere);
        
        $all = $arrRes['num'];
        
        $data['list'] = $arrRes['list'];
        $data['st'] = date("Y-m-d",strtotime($st));
        $data['et'] = date("Y-m-d",strtotime($et));
        $data['page_view'] = $page->view(array(
            'all' => $all
        ));
        
        $this->load->myview('admin/log/index', $data);
    }
}