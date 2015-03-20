<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$REQUEST_URI = $_SERVER['REQUEST_URI'];

$m       = 'index';
$f       = 'index';
$paraArr = array();


if ('/' == $REQUEST_URI) {
    $m = 'index';
    $f = 'index';
} else {
    str_replace('.html', '', $REQUEST_URI, $cnt);
    if (1 != $cnt) {
        $m = 'error';
        $f = 'index';
    } else {
        $tmp = explode('/', trim($REQUEST_URI, '/'));
        if (1 == count($tmp)) {
            $tmpH = explode('.', $tmp[0]);
            $m    = $tmpH[0];
            $f    = 'index';
        } elseif (2 == count($tmp)) {
            $tmpH = explode('.', $tmp[1]);
            $m    = $tmp[0];
            $f    = $tmpH[0];
        } elseif (3 == count($tmp)) {
            $tmpH    = explode('.', $tmp[2]);
            $m       = $tmp[0];
            $f       = $tmp[1];
            $paraArr = explode('_', $tmpH[0]);
        } else {
            $m = 'error';
            $f = 'index';
        }
    }
}
define('DS', "/");
define('ROOT_PATH', __DIR__);
define('ROOT_APP', ROOT_PATH . DS . '..' . DS . 'app' . DS);
define('ROOT_C', ROOT_APP . 'c' . DS);
define('ROOT_M', ROOT_APP . 'm' . DS);
define('ROOT_V', ROOT_APP . 'v' . DS);
define('ROOT_CONFIG', ROOT_APP . 'config' . DS);

//$fFile = ROOT_C . $f . '.php';
//if (!file_exists($fFile)) {
//    $m = 'error';
//    $f = 'index';
//}

function __autoload($className)
{
    $classPath = '';

    if (strpos($className, 'c_') !== false) {
        $classPath = ROOT_APP . str_replace('_', DS, $className);
    }

    if (strpos($className, 'm_') !== false) {
        $classPath = ROOT_APP . str_replace('_', DS, $className);
    }
    str_replace('PHPExcel', '', $className, $cnt);
    if ($cnt < 1) {
        include_once $classPath . '.php';
    } else {
        $file = str_replace('_', DS, $className) . '.php';
        require_once ROOT_M . 'PHPExcel' . DS . $file;
    }

//    if (!class_exists($className, false)) {
//        trigger_error('<br />Unable to load class: ' . $className, E_USER_WARNING);
//        exit();
//    }
}

session_start();

$mc            = 'c_' . $m;
$obj           = new $mc();
$fm            = $f . 'Action';
$obj->_paraArr = $paraArr;

$obj->init();
$endArr = $obj->$fm();
if (3 == $obj->_viewType) {
    header('Content-type: text/json');
    header('Content-type: application/json; charset=UTF-8');
    exit(json_encode($endArr));
}

if (false == $obj->_bg) {
    // 前台
    $basePath = ROOT_V . 'front' . DS;
} else {
    // 后台
    $basePath = ROOT_V . 'ad' . DS;
}
define('ROOT_V_R', $basePath);

if (2 == $obj->_viewType) {


    if (!empty($endArr)) {
        extract($endArr);
    }

    include_once $basePath . $m . DS . $f . '.php';
} else {
    $endArr['userInfo'] = $obj->_user;
    if (!empty($endArr)) {
        extract($endArr);
    }

    include_once $basePath . 'header.php';
    include_once $basePath . $m . DS . $f . '.php';

    include_once $basePath . 'footer.php';
}

function m($mName)
{
    return new $mName();
}

function model($name)
{
    $modelName = 'm_' . $name;
    return new $modelName();
}

function pageHtml($url, $page, $cnt)
{


//
//                        <a href="#">1</a>
//                        <a href="#" class="current">2</a>
//                        ..
//                        <a href="#">3</a>
//                        <a href="#">4</a>
//                        <a href="#" class="next">></a>



    $str = '<div class="page_turn page_turnSpe txtC">';
    if ($cnt != 0) {
        if (1 != $page) {
            $str .= '<a href="' . $url . ($page - 1) . '.html" class="pre">上一页</a>';
        }
        if ($cnt != $page) {
            $str .= '<a href="' . $url . ($page + 1) . '.html" class="next">下一页</a>';
            //  $str .= '<a href="' . $url . ($page + 1) . '.html" style="text-align:right;">下一页</a>';
        }
    }
    $str .= '共' . $cnt . '页';
    $str .= '</div>';
    return $str;
}

function sysSubStr($String, $Length, $Append = false)
{
    if (strlen($String) <= $Length) {
        return $String;
    } else {
        $I = 0;
        while ($I < $Length) {
            $StringTMP = substr($String, $I, 1);
            if (ord($StringTMP) >= 224) {
                $StringTMP = substr($String, $I, 3);
                $I         = $I + 3;
            } elseif (ord($StringTMP) >= 192) {
                $StringTMP = substr($String, $I, 2);
                $I         = $I + 2;
            } else {
                $I = $I + 1;
            }
            $StringLast[] = $StringTMP;
        }
        $StringLast = implode("", $StringLast);
        if ($Append) {
            $StringLast .= "...";
        }
        return $StringLast;
    }
}

/**
 * 模块
 * @param type $str
 */
function template($str, $arr)
{
    if (!empty($arr)) {
        extract($arr);
    }
    $tmpFile = ROOT_V_R . $str . '.php';
    include $tmpFile;
}

function getTpl($str)
{
    return file_get_contents(ROOT_V_R . $str . '.php');
}

/**
 * 配置
 * @param type $str
 */
function getCon($str)
{
    $tmpFile = ROOT_CONFIG . $str . '.php';
    return @include_once $tmpFile;
}
