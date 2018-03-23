<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Access extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function noright()
    {
        echo "你没有权限访问";
    }
}