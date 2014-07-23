<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_getInfo extends c_cabstract
{

    public $_isLogin = true;

    public function indexAction()
    {
        $this->_viewType = 3;

         $obj = m('m_couponBase');
$list = array();
         $sql = "select *   from coupon_base a inner join coupon_base_u b on a.coupon_id = b.coupon_id where b.hotel_is = 0 group by a.same_per_coupon_id ";
         $num = $obj->db->query($sql);

            while ($row  = mysql_fetch_array($num, MYSQL_ASSOC)) {
                $list[] = $row;
            }


         //$num = $obj->db->query('coupon_base_u', array(array('hotel_is' ,'0')), ' group by ');
        return array('num' => count($list));
    }

}