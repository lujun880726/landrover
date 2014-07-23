<?php

/**
 *  Description of Examine
 *
 * @author LJ <jun.lu.726@gmail.com>
 * @copyright @copyright
 * @history    2014-06-18 02:01:54::  Lujun  ::  Create File
 * $Id: user.php 0 2014-06-18 02:01:54Z lujun $
 */
class c_user extends c_cabstract
{

    public $_isLogin = true;


    public function addAction()
    {
        $err      = '';
        $uid      = 0;
        $userInfo = array();
        $obj      = m('m_user');
        $isMy     = $this->getx(0);
        $uid      = $this->getx(1);
        if ('m' == $isMy) {
            if ($uid < 1) {
                $uid = $_SESSION['uid'];
            }
        }
        if ($this->isPost()) {
            $data = $_POST;
            $data['uname'] = ($data['uname']);
            if (empty($data['uname'])) {
                $err = '用户名不能为空';
            }
            if (empty($data['name'])) {
                $err = '姓名不能为空';
            }
            if (empty($data['email'])) {
                $err = '邮件不能为空';
            }
            if (empty($data['phone'])) {
                $err = '手机号不能为空';
            }
            if ($data['role'] < 1) {
                $err = '非法操作，请重新登录';
            }
            $uid = (int) $data['uid'];
            if ($uid < 1) {
                $isBeing = $obj->userInfoByUName($data['uname']);
                if ($isBeing) {
                    $err = '用户名已存在';
                }
                if ($data['role'] < 1) {
                    $err = '非法操作，请重新登录';
                }
                if (empty($err)) {
                    $data['psd'] = md5(123456);
                    $obj->CNUser($data);
                    $err         = '添加成功';
                }
            } else {
                if(1 == $uid) {
                    $data['role'] = -1;
                }
                unset($data['uid']);
                $obj->db->update('landrover_user', array(array('uid',$uid)),$data);
                $err         = '修改成功';
            }
        }
        if ($uid > 0) {
            $userInfo = $obj->userInfoById($uid);
        }
        return array('cd' => '1', 'err' => $err, 'muserInfo' => $userInfo);
    }

    public function indexAction()
    {
        $list     = $whereArr = array();

        $page       = max(1, intval($this->getInt(0)));
        $pageSize   = 10;
        $start      = ($page - 1 ) * $pageSize;
        $uname      = '';
        $whereArr[] = array('uid', 1, '>');
        if ($this->isPost()) {
            $uname      = $_POST['uname'];
            $whereArr[] = array('uname', $uname, 'like');
        }
        //查询
        $obj   = m('m_user');
        $count = $obj->db->count('landrover_user', $whereArr);
        $cnt   = ceil($count / $pageSize);
        if ($page > $cnt) {
            $page  = $cnt;
            $start = ($page - 1 ) * $pageSize;
        }
        if ($count) {
            $list = $obj->db->getPage('landrover_user', $whereArr, $start, $pageSize);
        }

        return array('cd' => '2', 'list' => $list, 'page' => $page, 'cnt' => $cnt, 'uname' => $uname);
    }

    public function delAction()
    {
        $this->_viewType = 3;
        if ($this->isPost()) {
            $id = (int) $_POST['id'];
            if (1 == $id) {
                return array('msg' => '操作失败，请刷新后再试');
            }
            $obj = m('m_user');
            $obj->db->delete('landrover_user', array(array('uid', $id)));
        }
        return array('msg' => '删除成功');
    }

    public function rePsdAction()
    {
        $this->_viewType = 3;
        if ($this->isPost()) {
            $id  = (int) $_POST['id'];
            $obj = m('m_user');
            $obj->db->update('landrover_user', array(array('uid', $id)), array('psd' => md5(123456), 'psd_s' => 0));
        }
        return array('msg' => '重置成功');
    }

}
