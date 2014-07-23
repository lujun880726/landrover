<?php

if (PATH_SEPARATOR == ':') {
    return array(
        'hostname'    => "localhost",
        "username"    => "root",
        "password"    => "PassWord", //数据库密码
        "database"    => "landrover", //数据库名称
        "charset"     => "utf-8", //数据库编码
        "pconnect"    => 0, //开启持久连接
        "log"         => 0, //开启日志
        "logfilepath" => "./", //开启日志
    );
} else {
    return array(
        'hostname'    => "localhost",
        "username"    => "root",
        "password"    => "sql123", //数据库密码
        "database"    => "landrover", //数据库名称
        "charset"     => "utf-8", //数据库编码
        "pconnect"    => 0, //开启持久连接
        "log"         => 0, //开启日志
        "logfilepath" => "./", //开启日志
    );
}




