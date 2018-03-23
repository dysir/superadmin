<?php

class Config_model extends CI_Model
{

    private static $_strPlatConfig = 'plat_config';

    private static $_db = "";

    private static $gconfig;

    function __construct()
    {
        parent::__construct();
        if (empty(self::$_db)) {
            self::$_db = $this->load->database('default', true);
        }
    }

    public static function getPlatConfig()
    {
        if (self::$gconfig) {
            return self::$gconfig;
        }
        $config = self::getAllConfig();
        $arrConfig = array();
        foreach ($config as $key => $value) {
            $arrConfig[$value['ckey']] = $value['cvalue'];
        }
        self::$gconfig = $arrConfig;
        return $arrConfig;
    }

    public static function getAllConfig()
    {
        $sql = "select * from " . self::$_strPlatConfig;
        $config = self::$_db->query($sql)->result_array();
        if (! $config) {
            return false;
        }
        return $config;
    }

    public static function getConfigById($id)
    {
        $sql = "select * from " . self::$_strPlatConfig . " where id=?";
        $config = self::$_db->query($sql , array($id))->row_array();
        if (! $config) {
            return false;
        }
        return $config;
    }

    public static function delConfigById($id)
    {
        $sql = "delete from " . self::$_strPlatConfig . " where id=?";
        $config = self::$_db->query($sql,array($id));
        if (! $config) {
            return false;
        }
        return $config;
    }

    public static function updateConfigById($w, $data)
    {
        $ret = self::$_db->update(self::$_strPlatConfig, $data, $w);
        return $ret;
    }

    public static function addConfig($arr)
    {
        $ret = self::$_db->insert(self::$_strPlatConfig, $arr);
        return $ret;
    }
}