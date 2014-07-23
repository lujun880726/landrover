<?php

/**
 *  Description of Examine
 *
 * @author LJ <jun.lu.726@gmail.com>
 * @copyright @copyright
 * @history    2014-06-25 11:36:44::  Lujun  ::  Create File
 * $Id: msg.php 0 2014-06-25 11:36:44Z lujun $
 */
class m_msg
{

    function __construct()
    {
        $this->corpID    = '2062409';
        $this->loginName = 'TINGLITEST3';
        $this->password  = '123456';
        $this->msgFormat = 2; //utf-8
    }

    function send($msg,$mobile, $kindFlag = 1)
    {
        $corpID    = $this->corpID;
        $loginName = $this->loginName; //必需大写
        $password  = $this->password;

        set_time_limit(0); // 设置自己服务器超时时

        $ch = curl_init();

        //第一步：取随机码
        $url    = 'http://api.cosms.cn/sms/getMD5str/';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookie');
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $md5str = curl_exec($ch);
       // echo $md5str . '<br>';

        //第二步：企业编辑+登录名+密码  组合后MD5加密
        $str     = $corpID . $loginName . $password;
        $md5str2 = md5($str);

        //第三步：第二步与第一步内容组合后再进行MD5加密
        $str  = $md5str2 . $md5str;
        $pass = md5($str);
     //   echo $pass . '<br>';

        //第四步：发送
        $mes           = $msg . '【路虎中国】';
        $fields_string = 'msgFormat='.$this->msgFormat.'&corpID=' . $corpID . '&loginName=' . $loginName . '&password=' . $pass . '&Mobs='.$mobile.'&msg=' . urlencode($mes) . '&mtLevel=1&MD5str=' . $md5str;
        $url           = 'http://api.cosms.cn/sms/putMt/index.asp';
     //   echo $fields_string . '<br>';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 8);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        $str = curl_exec($ch);
     //   echo $str;

        curl_close($ch);

        if('100' == substr($str, 0, 3)) {
            return true;
        }
        return false;
    }

    // function send($msg,$mobile, $kindFlag = 1)
    //   {
    //       $this->msg = $msg;
    //     $this->mobile = $mobile;
    //   $this->kindFlag = $kindFlag;
    // $this->MD5str =  $this->getMDStr();
    //var_dump($this->getUrlT().$this->getStr());
    //echo "<BR>";
    //$date = file_get_contents($this->getUrlT().$this->getStr());
    //var_dump($date);exit;
    //}
    //
    public function getUrlT()
    {
        return 'http://api.cosms.cn/sms/putMt/?';
    }

    public function getStr()
    {
        return "msgFormat={$this->msgFormat}&corpID={$this->corpID}&loginName={$this->loginName}&password={$this->password}&Mobs={$this->mobile}&msg={$this->msg}&mtLevel=1&kindFlag={$this->kindFlag}&MD5str={$this->MD5str}";
        // return "msgFormat={$this->msgFormat}&corpID={$this->corpID}&loginName={$this->loginName}&password={$this->password}&Mobs={$this->mobile}&msg={$this->msg}&mtLevel=1&kindFlag={$this->kindFlag}&MD5str={$this->MD5str}";
//
    }

    function getMDStr()
    {
        $getMD5str = trim(file_get_contents('http://api.cosms.cn/sms/getMD5str/'));
        return md5(md5($this->corpID . $this->loginName . $this->password) . $getMD5str);
    }

}
