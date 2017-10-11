<?php

class Database
{
    private $db;

    /**
     * Создание подключения к базе данных
     * @param string $dbHost хост для подключения к базе данных
     * @param string $dbLogin имя пользователя для подключения к базе данных
     * @param string $dbPassword пароль для подключения к базе данных
     * @param string $dbName название базы данных
     */
    function __construct($dbHost, $dbLogin, $dbPassword, $dbName)
    {
        $this->db = new mysqli($dbHost, $dbLogin, $dbPassword, $dbName);
        $this->db->query("SET NAMES 'utf8'");
    }

    function __destruct()
    {
        $this->db->close();
    }

    public function query($sql)
    {
        return $this->db->query($sql);
    }

    public function queryOne($sql)
    {
        return $this->query($sql)->fetch_assoc();
    }

    public function queryAll($sql)
    {
        return $this->toArray($this->query($sql));
    }

    public function mysqli_escape_string($str)
    {
        return mysqli_escape_string($this->db, $str);
    }

    public function insert_id()
    {
        return $this->db->insert_id;
    }

    /**
     * Возвращает массив результатов выборки
     * @param object $res результат запроса к базе данных
     * @return array массив результатов выборки
     */
    private function toArray($res)
    {
        $arr = array();
        while ($row = $res->fetch_assoc())
            $arr[] = $row;
        return $arr;
    }
}
