<?php

function c($item, $config = 'custom')
{
    $ci = & get_instance();
    $ci->config->load($config);
    return $ci->config->item($item);
}

/*
 * 接口返回数据
 */
function ajax($code, $data, $msg)
{
    $info = array();
    $info['data'] = $data;
    $info['msg'] = $msg;
    $info['code'] = $code;
    if (isset($_REQUEST['callback'])) {
        // jsonp
        header('Content-Type: application/javascript;charset=utf-8');
        exit($_REQUEST['callback'] . '(' . json_encode($info) . ')');
    } else {
        // json
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode($info);
        exit();
    }
}

/*
 * 静态资源地址
 */
function static_url($url)
{
    return base_url() . "static/" . $url;
}

/**
 * 登录加密方式，可以使用更安全的password_hash
 *
 * @param unknown $pwd
 * @param unknown $salt
 * @return string
 */
function password($pwd, $salt)
{
    $pwd = sha1($pwd . $salt);
    return $pwd;
}

/**
 * 生成随机数
 * isup：是否含有大写
 */
function getRand($length = 10, $isup = false, $max = false)
{
    if (is_int($max) && $max > $length) {
        $length = mt_rand($length, $max);
    }
    $output = '';
    
    for ($i = 0; $i < $length; $i ++) {
        if ($isup) {
            $which = mt_rand(0, 2);
        } else {
            $which = mt_rand(0, 1);
        }
        
        if ($which === 0) {
            $output .= mt_rand(0, 9);
        } elseif ($which === 1) {
            $output .= chr(mt_rand(97, 122));
        } else {
            $output .= chr(mt_rand(65, 90));
        }
    }
    return $output;
}

function gconfig($ckey)
{
    $ci = & get_instance();
    $ci->load->model("admin/Config_model");
    $config = Config_model::getPlatConfig();
    if (! isset($config[$ckey])) {
        return "";
    }
    return $config[$ckey];
}

/*
 * 错误提示页
 */
function errorpage($msg = "")
{
    echo $msg;
    exit();
}

/**
 * 
 * @param string $mark 标题描述
 * @param array() or string $ext 扩展信息说明。如记录返回结果或请求结果等
 * @return unknown
 */
function wlog($mark,$ext="") {
    $ci = & get_instance();
    $ci->load->model("admin/Log_model");
    $newExt = $ext;
    if (is_array($ext)) {
        $newExt = json_encode($ext);
    }
    
    $uri = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:($ci->router->fetch_class() . "/" . $ci->router->fetch_method());
    $userInfo = checkLogin();
    $arr['username'] = $userInfo?$userInfo['username']:"未登录";
    $arr['uri'] = $uri;
    $arr['mark'] = $mark;
    $arr['mark_ext'] = $newExt;
    $arr['ip'] = get_client_ip();
    $ret = Log_model::insertLog($arr);
    return $ret;
}

/**
 * 获取ip
 * 首先获取remote_addr
 *
 * @return Ambigous <string, unknown>
 */
function get_client_ip()
{
    $ip = '0.0.0.0';
    $white_ip = array(); //
    if (! empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown") && substr($_SERVER['REMOTE_ADDR'], 0, 3) != "10." && $_SERVER['REMOTE_ADDR'] != '127.0.0.1' && ! in_array($_SERVER['REMOTE_ADDR'], $white_ip)) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], "unknown")) {
        $arrIp = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arrIp);
        if (false !== $pos) {
            unset($arrIp[$pos]);
        }
        $ip = trim($arrIp[0]); // 默认获取第一个
    } elseif (! empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    return $ip;
}

function gor($msg = "", $go = "")
{
    $str = "<script>";
    empty($msg) ? "" : $str .= ("alert('" . $msg . "');");
    
    if (empty($go)) {
        $str .= "history.go(-1)</script>";
        echo $str;
        // $strlog= json_encode(array('str'=>$str));
        // inLog($strlog);
        exit();
    } else {
        $str .= "</script>";
        echo $str;
        // $strlog= json_encode(array('str'=>$str,'go'=>$go));
        // inLog($strlog);
        redirect($go);
    }
}
function getBase32Rand($num = 10)
{
    $str = "abcdefghijklmnopqrstuvwxyz1234567890";
    $randStr = "";
    for ($i=0; $i < $num ; $i++) { 
        $randStr.=$str[ mt_rand(0,strlen($str)-1)];
    }
    return base32_encode($randStr);
}
function base32_encode($input) {  
    $BASE32_ALPHABET = 'abcdefghijklmnopqrstuvwxyz234567';  
    $output = '';  
    $v = 0;  
    $vbits = 0;  
  
    for ($i = 0, $j = strlen($input); $i < $j; $i++) {  
        $v <<= 8;  
        $v += ord($input[$i]);  
        $vbits += 8;  
  
        while ($vbits >= 5) {  
            $vbits -= 5;  
            $output .= $BASE32_ALPHABET[$v >> $vbits];  
            $v &= ((1 << $vbits) - 1);  
        }  
    }  
  
    if ($vbits > 0) {  
        $v <<= (5 - $vbits);  
        $output .= $BASE32_ALPHABET[$v];  
    }
  
    return $output;  
}
/*
    表格处理类
*/
function tableView($arrParam){
    
    //配置文件名
    $tableconfig = $arrParam['tableconfig'];
    //数据
    $tabledata = $arrParam['tabledata'];
    $CI =&get_instance();

    //数据处理方法调用类 新的处理方法添加到本类中
    $CI->load->library("tablelib/tabledatafunc");
    $arrInitObj = array();
    $arrInitObj[] = new tabledatafunc();




    $CI->load->library("tableview",$arrInitObj);
    $CI->tableview->setTableTitle( c("tabletitle","table/".$tableconfig) );
    $CI->tableview->setTableData( $tabledata );
    $CI->tableview->setTableDataConfig( c("tabledatafunc","table/".$tableconfig) );
    return $CI->tableview->view();
}
/*
    返回数据表字段预定义类型
    args 
        table|string|表名,$K|string|字段名
    return
        array()
*/
function getcolmunvalue($table , $k){
    $arrvalue = c("colmunvalue","table/".$table);

    if(empty($arrvalue[$k])){
        $arrvalue = c("colmunvalue","table/common");
    }
    return empty($arrvalue[$k])?array():$arrvalue[$k];
}
/*
    获取表字段相应配置
    优先搜素config/$table 文件 若不存在
    搜索 config/commen [$table] 数组 若不存在
    搜索 config/commen [_global]

    param
        $table 表名
        $column 配置字段名
        $strCv 字段配置类型 为空返回全部字段配置信息 建议不为空
            strCv可选值
                colmunvalue 字段描述

*/
function getTableColumnInfo($table , $column , $strCv = ""){
    $ci = & get_instance();

    $ci->config->load("table/{$table}.php", false , true);
    $arrColumnRes = $ci->config->item($column);
    if(!$strCv&&$arrColumnRes){
        return $arrColumnRes;
    }
    if(!empty($strCv) && isset($arrColumnRes[$strCv])){
        return $arrColumnRes[$strCv];
    }
    $ci->config->load("table/common.php");
    $arrTableRes = $ci->config->item($table);
    if(!$strCv&&isset($arrTableRes[$column]))
    {
        return $arrTableRes[$column];
    }
    if(!empty($strCv) && isset($arrTableRes[$column][$strCv])){
        return $arrTableRes[$column][$strCv];
    }
    $arrGlobalRes = $ci->config->item("_global");
    $arrRes = array();

    foreach ($arrGlobalRes as $key => $value) {
        if(!empty($value[$column])){
           $arrRes[$key] =  $value[$column];
        }
    }
    if(!$strCv){
        return $arrRes;
    }
    return empty($arrRes[$strCv])?array():$arrRes[$strCv];
}
function outputColumnView($table , $column , $k){
    $arrGet = getTableColumnInfo($table , $column , "colmunvalue");
    return empty($arrGet[$k])?"":$arrGet[$k];
}
function pn($n = 0){
    return "\n".str_repeat("\t", $n);
}