<?php

/**
 *  Description of Examine
 *
 * @author LJ <jun.lu.726@gmail.com>
 * @copyright @copyright
 * @history    2014-06-19 01:26:43::  Lujun  ::  Create File
 * $Id: coupon.php 0 2014-06-19 01:26:43Z lujun $
 */
class c_coupon extends c_cabstract
{

    public $_isLogin = true;

    function __construct()
    {

    }

    public function indexAction()
    {
        $err  = '';
        $list = array();

        $obj = m('m_couponBase');


        if ($this->isPost()) {
            $data = isset($_POST['c']) ? $_POST['c'] : '';
            if ($data) {
                $userType = $_POST['user_type'];
                $hotelKey = array();
                $first    = false;
                foreach ($data as $key => $val) {
                    $hotelKey[]       = $key;
                    $val['yy_time']   = strtotime($val['yy_time']);
                    $flag             = $obj->db->getRow('coupon_base_u', array(array('coupon_id', $key)));
                    $val['user_type'] = $userType;
                    $val['utime']     = time();

                    if ($flag) {
                        $obj->db->update('coupon_base_u', array(array('coupon_id', $key)), $val);
                    } else {
                        $first            = true;
                        $val['coupon_id'] = $key;
                        $obj->db->insert('coupon_base_u', $val);
                    }
                    $obj->db->update('coupon_base', array(array('coupon_id', $key)), array('user_type' => $userType));
                }

                rsort($hotelKey);
                $hotelInfo = $obj->db->getRow('hotel_info', array(array('hotel_key', implode('-', $hotelKey))));
                if (!$hotelInfo) {
                    $obj->db->insert('hotel_info', array('hotel_key' => implode('-', $hotelKey), 'city' => $val['city']));
                }


                $type2CoId = array();

                // 酒店使用券
                $tmp1    = $obj->db->getRow('coupon_base', array(array('coupon_id', $key)));
                $tmpList = $obj->db->getAll('coupon_base', array(array('same_per_coupon_id', $tmp1['same_per_coupon_id'])));
                if ($tmpList) {
                    foreach ($tmpList as $valTL) {
                        if (1 == $userType) {
                            $who_hotel = 1;
                        } else {
                            if ($valTL['coupon_id'] == $_POST['cp_ids']) {
                                $type2CoId = $valTL['coupon_id'];
                                $who_hotel = 1;
                            } else {
                                $who_hotel = 0;
                            }
                        }
                        $obj->db->update('coupon_base_u', array(array('coupon_id', $valTL['coupon_id'])), array('who_hotel' => $who_hotel));
                    }
                }
                if (isset($hotelInfo['state']) && $hotelInfo['state'] < 3) {
                    $obj->db->query("update coupon_base_u set hotel_is = 0 where coupon_id in ('" . implode("','", $hotelKey) . "')");
                }
                //, 'hotel_is'=> 0

                if (1 == $userType) {
                    $dxRow = $obj->db->getRow('coupon_base_u', array(array('coupon_id', $tmpList[0]['coupon_id'])));
                } else {
                    $dxRow = $obj->db->getRow('coupon_base_u', array(array('coupon_id', $type2CoId)));
                }

                $conf = getCon('fieldVal');

                $msg = '';
                if (1 == $dxRow['state'] && true == $first) {
                    $msg = $dxRow['name'] . '已预订' . date('m月d日',$dxRow['yy_time']) . $conf['city'][$dxRow['city']] . '体验课程，请协助安排当地酒店预定事宜。具体情况请联系客户再次确认。';
                }
                if (1 == $dxRow['state'] && false == $first) {
                    $msg = $dxRow['name'] . '已更改' . $conf['city'][$dxRow['city']] .'体验课程时间至' . date('m月d日',$dxRow['yy_time']) . '，请协助更改酒店入住时间，请再次和客户联系进行确认。';
                }

                if (4 == $dxRow['state'] && false == $first) {
                    $msg = $dxRow['name'] . '已取消' . date('m月d日',$dxRow['yy_time']) . $conf['city'][$dxRow['city']] .  '体验课程，请尽快联系当地酒店安排取消入住事宜。';
                }
                if ($msg) {
                    $msgobj = m('m_msg');
                    $msgobj->send($msg, '13564232098');// 13564232098
                   // file_put_contents('MSG.TXT', $msg. "\r\n",FILE_APPEND);
                }


                $err = '提交成功';
            }
            $hotelInfo = isset($_POST['hotel']) ? $_POST['hotel'] : '';
            if ($hotelInfo) {
                foreach ($hotelInfo as $key => $val) {
                    $val['utime']         = time();
                    $val['check_in_time'] = strtotime($val['check_in_time']);
                    $flag                 = $obj->db->getRow('hotel_info', array(array('hotel_key', $key)));
                    if ($flag) {
                        $obj->db->update('hotel_info', array(array('hotel_key', $key)), $val);
                    } else {
                        $val['hotel_key'] = $key;
                        $obj->db->insert('hotel_info', $val);
                    }
                    $tmpCid = explode('-', $key);
                    $obj->db->query("update coupon_base set hotel_is=1 where coupon_id in ('" . implode("','", $tmpCid) . "') ");
                    $obj->db->query("update coupon_base_u set hotel_is=1 where coupon_id in ('" . implode("','", $tmpCid) . "') ");
                }
                $err = '提交成功';
            }
        }

        $couponId = $this->getx(0);
        $nArr     = array();
        if ('n' == $couponId) {
            $couponId = '';
            //$sql      = "select *   from coupon_base a inner join coupon_base_u b on a.coupon_id = b.coupon_id where b.hotel_is = 0  group by a.same_per_coupon_id  order by b.who_hotel desc";
            $sql      = "select * from (select b.*,a.same_per_coupon_id   from coupon_base a inner join coupon_base_u b on a.coupon_id = b.coupon_id where b.hotel_is = 0 order by b.who_hotel desc) as table1 group by same_per_coupon_id; ";

            $num = $obj->db->query($sql);

            while ($row = mysql_fetch_array($num, MYSQL_ASSOC)) {
                $nArr[] = $row;
            }
        }

        $whereArr = array();

        $sql = "select a.* from coupon_base a left join coupon_base_u b on a.coupon_id = b.coupon_id where 1 ";

        $flag = false;
        if ($couponId) {
            $flag = true;
            $sql .= " and a.coupon_id = '{$couponId}'";
        }

        $name_ = urldecode($this->getx(1));
        if ($name_ != 'null' && $name_) {
            $flag = true;
            $sql .= " and ( a.name = '{$name_}' or b.name = '{$name_}') ";
        } else {
            $name_ = '';
        }

        $mobile = $this->getx(2);
        if ($mobile != 'null' && $mobile) {
            $flag = true;
            $sql .= " and (a.mobile = '{$mobile}' or b.mobile = '{$mobile}')  ";
        } else {
            $mobile = '';
        }
        if (!in_array($this->_user['role'], array(-1, 1, 3))) {
            $sql .= " and a.city = '" . $this->_user['city'] . "' ";
        }
        $list = array();
        if ($flag) {
            $tmre = $obj->db->query($sql);
            while ($row  = mysql_fetch_array($tmre, MYSQL_ASSOC)) {
                $list[] = $row;
            }
            if (empty($list)) {
                $err = '体验券不属于本体验中心，请重新查找';
            }
        }
        $data = true;
        foreach ($list as $key => $val) {
            if (!isset($list[$key + 1])) {
                continue;
            }
            if ($val['same_per_coupon_id'] != $list[$key + 1]['same_per_coupon_id']) {
                $data = false;
            }
        }
        if (false == $data) {
            $list = array();
            $err  = '为您找出2条以上的体验券信息，请提供券号进一步查询';
        }
        if (('提交成功' == $err || empty($err)) && $list) {
            $list = $obj->db->getAll('coupon_base', array(array('same_per_coupon_id', $list[0]['same_per_coupon_id'])));
        }
        if ($couponId < 1) {
            $couponId = '';
        }
        $ids = array(); {
            foreach ($list as $val) {
                $ids[] = $val['coupon_id'];
            }
        }

        if(isset($conf)){
            return array('cd' => 4, 'err' => $err, 'list' => $list, 'couponId' => $couponId, 'name_' => $name_, 'mobile' => $mobile, 'obj' => $obj, 'nArr' => $nArr, 'ids' => $ids,'conf'=>$conf);
        } else {
            return array('cd' => 4, 'err' => $err, 'list' => $list, 'couponId' => $couponId, 'name_' => $name_, 'mobile' => $mobile, 'obj' => $obj, 'nArr' => $nArr, 'ids' => $ids);
        }


    }

    public function sfzeditAction()
    {
        $obj             = m('m_couponBase');
        $this->_viewType = 3;

        $sfx   = $_POST['sfz'];
        $cp_id = $_POST['cp_id'];

        if ($this->isPost()) {
            $obj->db->update('coupon_base_u', array(array('coupon_id', $cp_id)), array('identity_card' => $sfx));
        }
        return array('code' => 1, 'msg' => '修改成功');
    }

}
