<?php


class MY_Loader extends CI_Loader {
    
    public function __construct() {
        parent::__construct ();
    }
    public function myview($body, $data = array(), $arrLayout = array() ) {

    	$CI =& get_instance();
        
    	$arrMenu = $CI->rabc->getMenu();
        $menulist = $arrMenu['arrmenu'];
        $current = empty($data['_current'])?$arrMenu['current']:$data['_current'];

        empty($arrLayout)?$arrLayout=array(
            'header'=>'base_header',
            'footer'=>'base_footer',
        ):"";

        $arrHeaderData = array(
            '_menulist'=>$menulist,
            // '_atfunc'=>$atfunc,
            '_current'=>$current
        );

        $this->view ( "admin/layer/{$arrLayout['header']}" , $arrHeaderData );
        $this->view ( $body,$data);
        $this->view ( "admin/layer/{$arrLayout['footer']}");
    }
}