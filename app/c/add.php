<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_add extends c_cabstract
{

    public $_isLogin = true;

    function __construct()
    {

    }

    public function indexAction()
    {
        $err      = '';
        $fileType = array('application/vnd.ms-excel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $conf     = getCon('fieldVal');
        if ($this->isPost()) {
            if (!in_array($_FILES['fileField']['type'], $fileType)) {
                $err = '只能上传XLS';
            } else {

                include_once ROOT_M . 'PHPExcel' . DS . 'PHPExcelToArray.php';
                $file      = fopen($_FILES['fileField']['tmp_name'], 'r');
                $tmpFile   = ROOT_V . $_FILES['fileField']['name'];
                file_put_contents($tmpFile, $file);
                $oPHPExcel = new PHPExcelToArray($tmpFile);
                $aData     = $oPHPExcel->getExcelData(0);
                $i      = 1;
                $obj    = m('m_couponBase');
                $errArr = array();
                $sqlIn  = 'INSERT INTO coupon_base(coupon_id,city,name,title,mobile,email,same_per_coupon_id,cx)VALUES';
                foreach ($aData AS $data) {
                    if ($data[4] == 'mobile') {
                        $i++;
                        continue;
                    }
                    $sql  = "select count(*) as num from coupon_base where coupon_id = '{$data[0]}' ";
                    $tmp1 = mysql_fetch_array($obj->db->query($sql));
                    if ($tmp1['num'] < 1) {
//                          $city = array_search(iconv('GB2312', 'UTF-8', $data['1']), $conf['city']);
//                        $sqlIn .= "('" . iconv('GB2312', 'UTF-8', $data['0']) . "','{$city}','" . iconv('GB2312', 'UTF-8', $data['2']) . "','" . iconv('GB2312', 'UTF-8', $data['3']) . "','" . iconv('GB2312', 'UTF-8', $data['4']) . "','" . iconv('GB2312', 'UTF-8', $data['5']) . "','"
//                                . iconv('GB2312', 'UTF-8', $data['7']) . "','" . iconv('GB2312', 'UTF-8', $data['6']) . "'),";

                        $city = array_search($data['1'], $conf['city']);
                        $sqlIn .= "('" . $data['0'] . "','{$city}','" . $data['2'] . "','" .  $data['3'] . "','" .$data['4'] . "','" . $data['5'] . "','"
                                . $data['7'] . "','" .  $data['6'] . "'),";
                    } else {
                        $errArr[] = $i;
                    }
                    $i++;
                }
                if ($errArr) {
                    $err = implode(',', $errArr) . '行的优惠券ID与老数据重复，请处理后再传，本次未上传数据！';
                } else {
                    ($obj->db->query(trim($sqlIn, ',')));
                    $err = '上传成功';
                }
            }
        }
        return array('cd' => '6', 'err' => $err);
    }

    function findAction()
    {
        $obj = m('m_couponBase');
        $sql = "select *  from coupon_base where coupon_id = '{$this->getx(0)}' and user_type < 1 ";

        $num  = $obj->db->query($sql);
        $nArr = array();
        while ($row  = mysql_fetch_array($num, MYSQL_ASSOC)) {
            $nArr[] = $row;
        }

        $err = '';
        return array('cd' => '6', 'err' => $err, 'list' => $nArr);
    }

    function deloneAction()
    {

        $obj = m('m_couponBase');
        $obj->db->delete('coupon_base', array(array('coupon_id', $_POST['id'])));
        echo '删除成功';
        exit();
    }

}
