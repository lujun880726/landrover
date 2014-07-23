<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_login extends c_cabstract
{

    public function indexAction()
    {
        if (isset($_SESSION['uid']) && $_SESSION['uid'] > 0) {
            header("Location: /");
        }
    }

    public function loginAction()
    {
        $this->_viewType = 3;

        if ($this->isPost()) {
//            $code = trim($_POST['code']);
//            if (!isset($_SESSION['code']) ) {
//                return array('code' => 1, 'msg' => '请走正常登录!');
//            }
//            if ($code != $_SESSION['code']) {
//                return array('code' => 1, 'msg' => '验证码不正确!');
//            }
            $obj      = m('m_user');
            $userInfo = $obj->checkUser(strtolower($_POST['name']), $_POST['psd']);
            if (empty($userInfo)) {
                return array('code' => 1, 'msg' => '账号或密码错误!');
            } else {
                if ($userInfo['psd_s'] < 1) {
                     $_SESSION['tmp_uid'] = $userInfo['uid'];
                    return array('code' => 2, 'msg' => file_get_contents(ROOT_V . 'front' . DS . 'psd/index.php'));
                } else {
                    $_SESSION = $userInfo;
                    return array('code' => 3, 'msg' => '登录成功!');
                }
            }
        }
    }

    public function outAction()
    {
        session_destroy();
        header("Location: /");
    }

}
