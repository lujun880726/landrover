<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_user extends m_mabstract
{

    function checkUser($uname, $psd)
    {
        $sql   = "select * from `landrover_user`   where lower(uname) = '" . strtolower($uname) . "' and psd = '" . md5($psd) . "'limit 1";
        $query = $this->db->query($sql);
        $rt    = mysql_fetch_array($query, MYSQL_ASSOC);
        return $rt;
    }

    function userInfoById($uid)
    {
        return $this->db->getRow('landrover_user', array(array('uid', $uid)));
    }

    function userInfoByUName($uname)
    {

        $sql   = "select * from `landrover_user`   where lower(uname) = '" . strtolower($uname) . "'limit 1";
        $query = $this->db->query($sql);
        $rt    = mysql_fetch_array($query, MYSQL_ASSOC);
        return $rt;
    }

    function CNUser($UserInfo)
    {
        return $this->db->insert('landrover_user', $UserInfo);
    }

}
