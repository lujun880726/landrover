<?php

/**
 *  Description of Examine
 *
 * @author LJ <jun.lu.726@gmail.com>
 * @copyright @copyright
 * @history    2014-06-25 11:37:43::  Lujun  ::  Create File
 * $Id: test.php 0 2014-06-25 11:37:43Z lujun $
 */
class c_test extends c_cabstract
{

    function __construct()
    {

    }

    function indexAction(){

        $obj = m('m_msg');
        $msg = '欢迎您体验陆虎中国' . time();
        var_dump($msg);
        $flag = $obj->send($msg,13916497905);

        var_dump($flag);
        echo "send end!!!!!!!!!";exit;



    }

}
