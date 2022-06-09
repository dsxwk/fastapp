<?php

namespace helpers\kernel\orm;
use PDO;

class Model
{
    //数据库连接
    protected $dbConfig = 'default';

    protected $type = 'pdo';

    //数据库连接
    protected $table = null;

    //连接实例
    private static $instance = null;

    public function __construct($conf = null)
    {
        if ($conf === null)
        {
            $conf = config('database')[$this->type][$this->dbConfig];
            $con = new PDO($conf['dsn'], $conf['username'], $conf['password'], $conf['options']);
        } else {
            $con = new PDO($conf['dsn'], $conf['username'], $conf['password'], $conf['options']);
        }

        self::$instance = $con;
    }

    public static function getInstance($conf = null){
        if(!(self::$instance instanceof self)){
            self::$instance = new self($conf);
        }
        return self::$instance;
    }

    public function first()
    {
        $sql = "SELECT * FROM {$this->table} LIMIT 1;";
        $result = self::$instance
            ->query($sql)
            ->fetchObject();
        return $result;
    }

    public function select()
    {
        return 'select';
    }

    public function insert()
    {
        return 'insert';
    }

    public function update()
    {
        return 'update';
    }

    public function delete()
    {
        return 'delete';
    }
}