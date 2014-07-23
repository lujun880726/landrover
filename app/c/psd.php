<?php

/**
 *  Description of Examine
 *
 * @author LJ <jun.lu.726@gmail.com>
 * @copyright @copyright
 * @history    2014-06-18 05:52:08::  Lujun  ::  Create File
 * $Id: psd.php 0 2014-06-18 05:52:08Z lujun $
 */
class c_psd extends c_cabstract
{

    public $_isLogin = true;
    public $_psd_s   = true;

    public function indexAction()
    {
        $this->_viewType = 3;
        $err             = '';
        if ($this->isPost()) {
            $o_psd = trim($_POST['o_psd']);
            if (empty($o_psd)) {
                return array('code' => 1, 'msg' => '老密码不能为空!');
            }
            $n_psd1 = trim($_POST['n_psd1']);
            $n_psd2 = trim($_POST['n_psd2']);
            if (empty($n_psd1)) {
                return array('code' => 1, 'msg' => '新密码不能为空!');
            }

            if ($n_psd1 != $n_psd2) {
                return array('code' => 1, 'msg' => '两次密码不能一致!');
            }

            if ($n_psd1 == $o_psd) {
                return array('code' => 1, 'msg' => '新密码不可以和老密码一样!');
            }
            if (strlen($n_psd1)<6) {
                return array('code' => 1, 'msg' => '密码必须大于6位!');
            }

            $str = $n_psd1;
            if (preg_match('/(?=.*[0-9])(?=.*[a-zA-Z]).*/', $str, $m)) {

            } else {
                return array('code' => 1, 'msg' => '密码必须为字母和数字组合');
            }

            $obj         = m('m_user');
            $tmpUserInfo = $obj->userInfoById($_SESSION['tmp_uid']);
            if (md5($o_psd) != $tmpUserInfo['psd']) {
                return array('code' => 1, 'msg' => '老密码不正确!');
            }

            $obj->db->update('landrover_user', array(array('uid', $_SESSION['tmp_uid'])), array('psd' => md5($n_psd1), 'psd_s' => 1));
            $userInfo = $obj->userInfoById($_SESSION['tmp_uid']);

            $_SESSION = $userInfo;
            return array('code' => 3, 'msg' => '修改成功!');
        }
    }

}
