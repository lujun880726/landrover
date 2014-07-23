<?php

Class m_mysql
{

    private $link_id;
    private $handle;
    private $is_log;
    private $time;

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    //构造函数
    public function __construct()
    {
        $dbConfig   = include_once ROOT_CONFIG . 'db.php';
        $this->time = $this->microtime_float();

        if (!$this->link_id) {
            $this->connect($dbConfig["hostname"], $dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["pconnect"]);
            $this->is_log = $dbConfig["log"];
            if ($this->is_log) {
                $handle       = fopen($dbConfig["logfilepath"] . "dblog.txt", "a+");
                $this->handle = $handle;
            }
        }
    }

//数据库连接
    public function connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect = 0, $charset = 'utf8')
    {
        if ($pconnect == 0) {
            $this->link_id = @mysql_connect($dbhost, $dbuser, $dbpw, true);
            if (!$this->link_id) {
                $this->halt("数据库连接失败");
            }
        } else {
            $this->link_id = @mysql_pconnect($dbhost, $dbuser, $dbpw);
            if (!$this->link_id) {
                $this->halt("数据库持久连接失败");
            }
        }
        if (!@mysql_select_db($dbname, $this->link_id)) {
            $this->halt('数据库选择失败');
        }
        @mysql_query("set names " . $charset);
    }

//查询
    public function query($sql)
    {
        $this->write_log("查询 " . $sql);
        $query = mysql_query($sql, $this->link_id);
        if (!$query)
            $this->halt('Query Error: ' . $sql);
        return $query;
    }

    public function count($table, $where, $groupBy = '')
    {
        $sql   = "select count(*) as num from `{$table}`  " . $this->formatWhere($where) . '  ' . $groupBy . '  limit 1';
        $query = $this->query($sql);
        $rt    = mysql_fetch_array($query, MYSQL_ASSOC);
        return $rt['num'];
    }

//插入
    public function insert($table, $dataArray)
    {
        $field = "";
        $value = "";
        if (!is_array($dataArray) || count($dataArray) <= 0) {
            $this->halt('没有要插入的数据');
            return false;
        }
        while (list($key, $val) = each($dataArray)) {
            $field .="$key,";
            $value .="'$val',";
        }
        $field = substr($field, 0, -1);
        $value = substr($value, 0, -1);
        $sql   = "insert into $table($field) values($value)";
        $this->write_log("插入 " . $sql);
        if (!$this->query($sql))
            return false;
        return mysql_insert_id($this->link_id);
    }

//获取一条记录（MYSQL_ASSOC，MYSQL_NUM，MYSQL_BOTH）
    public function getRow($table, $where, $result_type = MYSQL_ASSOC)
    {

        $sql   = "select * from `{$table}`  " . $this->formatWhere($where) . ' limit 1';
        $query = $this->query($sql);
        $rt    = mysql_fetch_array($query, $result_type);
        $this->write_log("获取一条记录 " . $sql);
        return $rt;
    }

//获取全部记录
    public function getPage($table, $where, $start, $pageSize, $result_type = MYSQL_ASSOC)
    {
        $sql   = "select * from `{$table}`  " . $this->formatWhere($where) . " limit {$start},{$pageSize}";
        $query = $this->query($sql);
        $i     = 0;
        $rt    = array();
        while ($row   = mysql_fetch_array($query, $result_type)) {
            $rt[$i] = $row;
            $i++;
        }
        $this->write_log("获取全部记录 " . $sql);
        return $rt;
    }

//获取全部记录
    public function getAll($table, $where, $result_type = MYSQL_ASSOC)
    {
        $sql   = "select * from `{$table}`  " . $this->formatWhere($where);
        $query = $this->query($sql);
        $i     = 0;
        $rt    = array();
        while ($row   = mysql_fetch_array($query, $result_type)) {
            $rt[$i] = $row;
            $i++;
        }
        $this->write_log("获取全部记录 " . $sql);
        return $rt;
    }

//删除
    public function delete($table, $where, $jz = true)
    {
        if ($jz) {
            $limit = " limit 1";
        } else {
            $limit = '';
        }
        $sql   = "delete from `{$table}`  " . $this->formatWhere($where) . $limit;
        $query = $this->query($sql);
        if (!$this->query($sql))
            return false;
        return true;
    }

//更新
    public function update($table, $where, $serArr, $jz = true)
    {
        if ($jz) {
            $limit = " limit 1";
        } else {
            $limit = '';
        }
        $sql   = "update `$table` set {$this->createset($serArr)}  {$this->formatWhere($where)}" . $limit;
        $query = $this->query($sql);
        if (!$this->query($sql))
            return false;
        return true;
    }

    /**
     * 创建安全的set子句
     *
     * @param array $array 需要创建set子句的关联数组
     * @param array $safe 安全限制数组，字段列表
     * @param array $unset 不用单引号环绕的字段列表
     * @return string
     */
    public function createset($array, $safe = array(), $unset = array())
    {
        $_res = array();
        foreach ((array) $array as $_key => $_val) {
            if ($safe && !in_array($_key, $safe)) {
                continue;
            } else {
                if ($unset && in_array($_key, $unset)) {
                    $_res[$_key] = "`{$_key}`={$_val}";
                } else {
                    $_res[$_key] = "`{$_key}`='{$_val}'";
                }
            }
        }
        return implode(',', $_res);
    }

    /**
     * 格式化字段
     *
     * @param array $fieldArr
     * @return string
     */
    public function formatFields($fieldArr)
    {
        if (!empty($fieldArr)) {
            $fileds = '';
            foreach ((array) $fieldArr as $field) {
                $fileds .= '`' . $field . '`,';
            }
            $fileds = rtrim($fileds, ',');
            return $fileds ? $fileds : '*';
        } else {
            return '*';
        }
        return !empty($fieldArr) ? implode(', ', (array) $fieldArr) : '*';
    }

    /**
     * 格式化查询条件
     *
     * @param array $whereArr=array(array('字段', '值', '操作符'),...)
     * @return string
     */
    public function formatWhere($whereArr)
    {

        $where = '';
        if (!empty($whereArr)) {
            foreach ((array) $whereArr as $value) {
                if (is_array($value[0])) {
                    $where .= (empty($where) ? ' WHERE ( ' : ' AND  ( ');
                    foreach ($value as $k => $v) {
                        list($prefix, $suffix) = (!empty($v[2]) && strtoupper($v[2]) == 'LIKE') ? array('%', '%') : array('', '');
                        if (isset($v[2]) && (strtoupper($v[2]) == 'IN' || strtoupper($v[2]) == 'NOT IN')) {
                            $where .= ($k == 0 ? ' ' : ' OR ') . $v[0] . ' ' . $v[2] . ' ' . $prefix . $v[1] . $suffix;
                        } else {
                            $where .= ($k == 0 ? ' ' : ' OR ') . $v[0] . ' ' . (empty($v[2]) ? '=' : $v[2]) . " '" . $prefix . $v[1] . $suffix . "' ";
                        }
                    }
                    $where .= ' ) ';
                } else {
                    list($prefix, $suffix) = (!empty($value[2]) && strtoupper($value[2]) == 'LIKE') ? array('%', '%') : array('', '');
                    if (isset($value[2]) && (strtoupper($value[2]) == 'IN' || strtoupper($value[2]) == 'NOT IN')) {
                        $where .= (empty($where) ? ' WHERE ' : ' AND ') . $value[0] . ' ' . $value[2] . ' ' . $prefix . $value[1] . $suffix;
                    } else {
                        $where .= (empty($where) ? ' WHERE ' : ' AND ') . $value[0] . ' ' . (empty($value[2]) ? '=' : $value[2]) . " '" . $prefix . $value[1] . $suffix . "' ";
                    }
                }
            }
        }
        return $where;
    }

    /**
     * 格式化排序字段
     *
     * @param array $orderByArr
     * @return string
     */
    public function formatOrderBy($orderByArr)
    {
        return !empty($orderByArr) ? ' ORDER BY ' . implode(', ', (array) $orderByArr) : '';
    }

    /**
     * 格式化限制字段
     *
     * @param array $limitArr
     * @return string
     */
    public function formatLimit($limitArr)
    {
        $row_count = 0;
        $offset    = 0;
        $limit     = !empty($limitArr) && 2 == count($limitArr) && list($row_count, $offset) = (array) $limitArr;
        return $offset == 0 ? '' : ' limit ' . $row_count . ',' . $offset;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//返回结果集
    public function fetch_array($query, $result_type = MYSQL_ASSOC)
    {
        $this->write_log("返回结果集");
        return mysql_fetch_array($query, $result_type);
    }

//获取记录条数
    public function num_rows($results)
    {
        if (!is_bool($results)) {
            $num = mysql_num_rows($results);
            $this->write_log("获取的记录条数为" . $num);
            return $num;
        } else {
            return 0;
        }
    }

//释放结果集
    public function free_result()
    {
        $void = func_get_args();
        foreach ($void as $query) {
            if (is_resource($query) && get_resource_type($query) === 'mysql result') {
                return mysql_free_result($query);
            }
        }
        $this->write_log("释放结果集");
    }

//关闭数据库连接
    protected function close()
    {
        $this->write_log("已关闭数据库连接");
        return @mysql_close($this->link_id);
    }

//错误提示
    private function halt($msg = '')
    {
        $msg .= "\r\n" . mysql_error();
        $this->write_log($msg);
        die($msg);
    }

//析构函数
    public function __destruct()
    {
        $this->free_result();
        $use_time = ($this->microtime_float()) - ($this->time);
        $this->write_log("完成整个查询任务,所用时间为" . $use_time);
        if ($this->is_log) {
            fclose($this->handle);
        }
    }

//写入日志文件
    public function write_log($msg = '')
    {
        if ($this->is_log) {
            $text = date("Y-m-d H:i:s") . " " . $msg . "\r\n";
            fwrite($this->handle, $text);
        }
    }

//获取毫秒数
    public function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

}
