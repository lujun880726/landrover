<?php

/**
 *  Description of Examine
 *
 * @author LJ <jun.lu.726@gmail.com>
 * @copyright @copyright
 * @history    2014-06-19 01:43:42::  Lujun  ::  Create File
 * $Id: couponBase.php 0 2014-06-19 01:43:42Z lujun $
 */
class m_couponBaseU extends m_mabstract
{

    public function getCAll($couponId)
    {
        $tmp = $this->db->getRow('coupon_base_u', array(array('coupon_id', $couponId)));
        if ($tmp) {
            if ($tmp['same_per_coupon_id']) {
                $tmp2 = $this->db->getAll('coupon_base_u', array(array('coupon_id', $tmp['same_per_coupon_id'])));
            } else {
                $tmp2 = $this->db->getAll('coupon_base_u', array(array('same_per_coupon_id', $couponId)));
            }
            if ($tmp2) {
                array_push($tmp2, $tmp);
                return $tmp2;
            } else {
                return array($tmp);
            }
        } else {
            return '没有此券信息!';
        }
    }

}
