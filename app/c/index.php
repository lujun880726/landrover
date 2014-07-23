<?php

class c_index extends c_cabstract
{

    public $_isLogin = true;

    public function indexAction()
    {
        $err   = '';
        $conf  = array(
            'city' => array(
                1 => '北京',
                2 => '广州',
                3 => '湖州',
                4 => '成都',
            ),
        );
        $reArr = array();

        $obj = m('m_couponBase');

        if ($this->_user['role'] > 1 && 3 != $this->_user['role']) {
            $tmp1[$this->_user['city']] = $conf['city'][$this->_user['city']];
            $conf['city']               = $tmp1;
        }
        foreach ($conf['city'] as $key => $val) {
            $tmp['city']           = $key;
            $tmp['coupon_all_num'] = $obj->db->count('coupon_base', array(array('city', $key)));

            $sql          = "select count(*) as num from coupon_base a left join coupon_base_u b on a.coupon_id = b.coupon_id where a.city = '{$key}' and (b.state  is null or b.state = 0); ";
            $tmp1         = mysql_fetch_array($obj->db->query($sql));
            $tmp['no_jh'] = $tmp1['num'];

            $sql          = "select count(*) as num from coupon_base a left join coupon_base_u b on a.coupon_id = b.coupon_id where a.city = '{$key}' and  b.state = 1; ";
            $tmp4         = mysql_fetch_array($obj->db->query($sql));
            $tmp['is_yy'] = $tmp4['num'];

            $sql            = "select count(*) as num from coupon_base a left join coupon_base_u b on a.coupon_id = b.coupon_id where a.city = '{$key}' and  b.state = 3; ";
            $tmp2           = mysql_fetch_array($obj->db->query($sql));
            $tmp['is_user'] = $tmp2['num'];

            //已使用
            $sql                   = "select count(*) as num from hotel_info  where city = '{$key}' and state = 3; ";
            $tmp3                  = mysql_fetch_array($obj->db->query($sql));
            $tmp['hotile_is_user'] = $tmp3['num'];

            //预约使用
            $sql                 = "select count(*) as num from hotel_info  where city = '{$key}' and state = 1; ";
            $tmp5                = mysql_fetch_array($obj->db->query($sql));
            $tmp['hotile_is_yy'] = $tmp5['num'];

            //未预约
            $sql                    = "select count(*) as num from hotel_info  where city = '{$key}' and state = 0; ";
            $tmp6                   = mysql_fetch_array($obj->db->query($sql));
            $tmp['hotile_is_no_yy'] = $tmp6['num'];

            $reArr[$val] = $tmp;
        }

        $city  = $this->getInt(0);
        $state = $this->getInt(1);
        $type  = $this->getInt(2); // 1 体验中心 2 酒店

        $sx = array();
        if ($city > 0) {

            if (1 == $type) {
                $sql = "select b.coupon_id,b.name,b.mobile,b.yy_time as utime from coupon_base a left join coupon_base_u b on a.coupon_id = b.coupon_id where a.city = '{$city}' and  b.state = '{$state}'; ";
                $num = $obj->db->query($sql);
                while ($row = mysql_fetch_array($num, MYSQL_ASSOC)) {
                    $sx[] = $row;
                }
            } else {
                $sql      = "select hotel_key,check_in_time from hotel_info  where city = '{$city}' and state = '{$state}'; ";
                $num      = $obj->db->query($sql);
                $tmphotel = array();
                while ($row      = mysql_fetch_array($num, MYSQL_ASSOC)) {
                    $tmphotel[] = $row;
                }
                if ($tmphotel) {
                    foreach ($tmphotel as $horow) {
                        $tmpIds = explode('-', $horow['hotel_key']);
                        $sql    = "select * from (select  b.coupon_id,b.name,b.mobile,b.utime,a.same_per_coupon_id   from coupon_base a inner join coupon_base_u b on a.coupon_id = b.coupon_id where a.coupon_id in ('" . implode("','", $tmpIds) . "')    order by b.who_hotel desc) as table1  group by same_per_coupon_id;";
                        $rowho  = $obj->db->query($sql);
                        while ($row    = mysql_fetch_array($rowho, MYSQL_ASSOC)) {
                            $row['utime'] = $horow['check_in_time'];
                            $sx[] = $row;
                        }
                    }
                }
            }
        }

        return array('cd' => '0', 'err' => $err, 'reArr' => $reArr, 'sx' => $sx, 'type' => $type, 'state' => $state);
    }

}
