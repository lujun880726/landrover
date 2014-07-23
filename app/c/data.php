<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_data extends c_cabstract
{

    public $_isLogin = true;

    function __construct()
    {

    }

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
                            $sx[]         = $row;
                        }
                    }
                }
            }
        }

        return array('cd' => '5', 'err' => $err, 'reArr' => $reArr, 'sx' => $sx, 'type' => $type, 'state' => $state);
    }

    function exportAction()
    {
        $conf = getCon('fieldVal');
//        header("Content-type:application/vnd.ms-excel");
//        header("Content-Disposition:attachment;filename=data.xls");

        $data_type = (int) $_POST['data_type'];
        if (1 == $data_type) {
            $city = (int) $_POST['city'];
            $obj  = m('m_couponBase');

            $data = array(1 => array('同一组券ID', '券ID', '体验中心', '姓名', '称谓', '手机', 'EMAIL'));

            $list = $obj->db->getAll('coupon_base', array(array('city', $city)));
            if ($list) {
                foreach ($list as $val) {
                    $data[] = array($val['same_per_coupon_id'], $val['coupon_id'], $conf['city'][$val['city']], $val['name'], $val['title'], $val['mobile'], $val['email']);
                }
            }
            $xlsxml = m('m_xlsxml');
            $xlsxml->addArray($data); //数据
            $xlsxml->generateXML('原始数据表'); //文件名
            exit;
        }
        if (2 == $data_type) {
            $city  = (int) $_POST['city'];
            $btime = strtotime(trim($_POST['btime']) . ' 00:00:00');
            $etime = strtotime(trim($_POST['etime']) . ' 23:59:59');
            $state = (int) $_POST['state'];

            $obj = m('m_couponBase');

            $data = array(1 => array('同一组券ID', '券ID', '使用方法', '体验中心', '姓名', '称谓', '手机', 'EMAIL', '身份证', '预约时间', '使用状态'));

            $tmpSql = '';
            if ($state > 0) {
                $tmpSql .= " and b.state = '{$state}' ";
            }
            if ($city > 0) {
                $tmpSql .= "  and a.city = '{$city}' ";
            }
            $sql = "select * from coupon_base a left join coupon_base_u b on a.coupon_id = b.coupon_id where 1 {$tmpSql} and b.utime > {$btime} and b.utime <= {$etime}";

            $tmre = $obj->db->query($sql);
            $list = array();
            while ($row  = mysql_fetch_array($tmre, MYSQL_ASSOC)) {
                $list[] = $row;
            }
            if ($list) {
                foreach ($list as $val) {
                    $str    = 1 == $val['user_type'] ? '同行使用' : '拆分使用';
                    $data[] = array($val['same_per_coupon_id'], $val['coupon_id'], $str, $conf['city'][$val['city']], $val['name'], $val['title'], $val['mobile'], $val['email'], (string) $val['identity_card'], date('Y-m-d', $val['yy_time']), $conf['state'][$val['state']]);
                }
            }
            $xlsxml = m('m_xlsxml');
            $xlsxml->addArray($data); //数据
            $xlsxml->generateXML('更新数据表'); //文件名
            exit;
        }

        if (3 == $data_type) {
            $city  = (int) $_POST['city'];
            $btime = strtotime(trim($_POST['btime']) . ' 00:00:00');
            $etime = strtotime(trim($_POST['etime']) . ' 23:59:59');
            $state = (int) $_POST['state'];

            $obj = m('m_couponBase');

            $data = array(1 => array('券号', '姓名', '酒店名称', '入住时间', '地区', '使用状态'));

            $tmpSql = '';
            if ($state > 0) {
                $tmpSql .= " and  state = '{$state}' ";
            }

            if ($city > 0) {
                $tmpSql .= "  and city = '{$city}' ";
            }
            $sql  = "select * from hotel_info  where 1 {$tmpSql} and utime > {$btime} and utime <= {$etime}";
            $tmre = $obj->db->query($sql);
            $list = array();
            while ($row  = mysql_fetch_array($tmre, MYSQL_ASSOC)) {
                $list[] = $row;
            }

            if ($list) {
                foreach ($list as $val) {
                    $tmp = explode('-', $val['hotel_key']);

                    $sql   = "select * from coupon_base_u  where coupon_id in ('" . implode("','", $tmp) . "') order by who_hotel desc  limit 1";
                    $query = $obj->db->query($sql);
                    $row   = mysql_fetch_array($query, MYSQL_ASSOC);
                    $str   = 1 == $row['user_type'] ? '同行使用' : '拆分使用';

                    $data[] = array($row['coupon_id'], $row['name'], $conf['hotel'][$val['hotel_id']], date('Y-m-d', $val['check_in_time']), $conf['city'][$val['city']], $conf['state'][$val['state']]);
                }
            }
            $xlsxml = m('m_xlsxml');
            $xlsxml->addArray($data); //数据
            $xlsxml->generateXML('酒店数据'); //文件名
            exit;
        }


//输出内容如下：
        echo iconv("utf-8", "gb2312", '姓名' . "\t");
        echo iconv("utf-8", "gb2312", '年龄' . "\t");
        echo iconv("utf-8", "gb2312", '学历' . "\t");

        echo "\n";

        echo iconv("utf-8", "gb2312", '张三' . "\t");
        echo iconv("utf-8", "gb2312", '25' . "\t");
        echo iconv("utf-8", "gb2312", '本科' . "\t");
        exit;
    }

}
