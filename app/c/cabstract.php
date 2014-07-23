<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class c_cabstract
{

    public $_paraArr  = array();
    public $_bg       = false;
    public $_viewType = 1;  // 1整页。2 弹出框。3 AJAX
    public $_isLogin  = false;
    public $_user;
    public $_psd_s    = false;

    public function init()
    {
        if (true == $this->_isLogin) {

            if (false == $this->_psd_s) {
                if (!isset($_SESSION['uid']) || $_SESSION['uid'] < 1) {
                    header("Location: /login/index.html");
                }
                $this->_user = $_SESSION;
            }
        }
    }

    public function getInt($key)
    {
        if (isset($this->_paraArr[$key])) {
            return (int) $this->_paraArr[$key];
        } else {
            return 0;
        }
    }

    public function getx($key)
    {
        if (isset($this->_paraArr[$key])) {
            return (string) trim($this->_paraArr[$key]);
        } else {
            return '';
        }
    }

    public function isPost()
    {
        return ('POST' == $_SERVER['REQUEST_METHOD']);
    }

    public function jsonx($msg, $resultType, $extra = '')
    {
        return array('msg' => $msg, 'res' => $resultType, 'extra' => $extra);
    }

}
