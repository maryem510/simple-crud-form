<?php
namespace Core;
use mysqli;
require_once 'config.php';
require_once 'sql.php';

createDB( DB_SERVER_NAME ,DB_USER_NAME ,DB_PASSWORD,DB_DATABASE_NAME);
class DB
{

    private static $conn;
    private  $table;
    private  $query;
    private  $result;
    private  $data = [];
    private  $where = [];
    private  $additiinalParts = [];
    const  SORTING = "DESC";
    private $serverName;
    private $user;
    private $db_name;   
    private $password;

    public function __construct()
    {
        $this->serverName =  DB_SERVER_NAME ;
        $this->user =DB_USER_NAME ;
        $this->db_name =DB_DATABASE_NAME ;
        $this->password = DB_PASSWORD;
        $this->connection();
    }

    public function connection()
    {
        if (!self::$conn) {
            self::$conn = new mysqli($this->serverName, $this->user, $this->password, $this->db_name);
            self::$conn->set_charset("utf8");
        }

        return self::$conn;
    }

    public  function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($name,$op,$value)
    {
        $value = self::$conn->real_escape_string($value);
        $this->where[] = " WHERE  `{$name}` {$op} '{$value}' ";
        return $this;
    }

    public function whereAnd($name, $op, $value)
    {
        $value = self::$conn->real_escape_string($value);
        $this->where[] = " AND `{$name}` {$op} '{$value}' ";
        return $this;
    }

    public function whereOr($name, $op, $value)
    {
        $value = self::$conn->real_escape_string($value);
        $this->where[] = " OR `{$name}` {$op} '{$value}' ";
        return $this;
    }

    private function whereSentence(): string
    {
        $where = "";
        foreach ($this->where as $val) {
            $where .= $val;
        }
        return $where;
    }

    public function additionalParts()
    {
        $additional = '';
        foreach ($this->additiinalParts as $val) {
            $additional .= $val;
        }
        return $additional;
    }

    public function insert($data)
    {
        $fields = "";
        $values = "";
        $last = array_key_last($data);
        foreach ($data as $key => $value) {
            if ($last == $key) {
                $fields .= "`$key`";
                $value = self::$conn->real_escape_string($value);
                $values .= "'$value'";
            } else {
                $fields .= "`$key`,";
                $value = self::$conn->real_escape_string($value);
                $values .= "'$value',";
            }
        }
        $this->query = "INSERT INTO {$this->table} ({$fields}) VALUES({$values}) ";
        return $this;
    }     

    public function update($data)
    {
        $fields = "";
        $last = array_key_last($data);
        foreach ($data as $key => $value) {
            if ($last == $key) {
                $value = self::$conn->real_escape_string($value);
                $fields .= " `{$key}`='$value'";
            } else {
                $value = self::$conn->real_escape_string($value);
                $fields .= " `{$key}`='$value',";
            }
        }

        $this->query = "UPDATE {$this->table} SET {$fields} {$this->whereSentence()} ";
        return $this;
    }

    public function getAll()
    {
        $this->query = "SELECT * FROM {$this->table} {$this->whereSentence()} {$this->additionalParts()} ";
        if ($this->save()) {
            while ($row = $this->result->fetch_object()) {
                $this->data[] = $row;
            }
            $this->result->free();
            return $this->data;
        } else {
            return $this->queryError();
        }
    }

    public function getRow($data = null)
    {
        if (is_int($data) && empty($this->where)) {
            $this->where = [" WHERE `id`='$data' "];
        }
        if (is_array($data) && empty($this->where)) {
            $this->where[] = [" WHERE `$data[0]` $data[1] '$data[2]'"];
        }
        $this->query = "SELECT * FROM {$this->table}   {$this->whereSentence()} ";
        if ($this->save()) {
            while ($row = $this->result->fetch_object()) {
                $this->data = $row;
            }
            return $this->data;
        } else {
            return $this->queryError();
        }
    }

    public function delete($id, $field = 'id')
    {
        $this->query = "DELETE FROM {$this->table} WHERE `$field`='$id' ";
        if ($this->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function save()
    {
        $this->result = self::$conn->query($this->query);
        if (self::$conn->affected_rows >= 0 && $this->result == true) {
            return true;
        }
        return false;
    }

    public function queryError()
    {
        return self::$conn->error;
    }

    public function getNumRows()
    {
        return $this->result->num_rows;
    }

    public function orderBy($field, $sort = self::SORTING)
    {
        $this->additiinalParts[] = " ORDER BY `{$field}` {$sort} ";
        return $this;
    }

    public function limit($count, $offset = 0)
    {
        $this->additiinalParts[] = " LIMIT {$offset} ,  {$count} ";
        return $this;
    }

    public function getLastId()
    {
        return self::$conn->insert_id;
    }

    public function __destruct()
    {
        self::$conn->close();
    }
}
