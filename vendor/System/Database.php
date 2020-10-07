<?php

namespace System;

use PDO;
use PDOException;
class Database{
    private $app;
    private static $connection;
    private $table;
    private $data = [];
    private $bindings = [];
    private $lastId;
    private $wheres = [];
    private $selects = [];
    private $joins = [];
    private $limit;
    private $offset;
    private $rows = 0;
    private $orderBy = [];


    public function __construct(Application $app){
        $this->app = $app;
        if (!$this->isConnected()){
            $this->connect();
        }
    }

    private function isConnected(){
        return self::$connection instanceof PDO;
    }

    private function connect(){
        $conData = $this->app->file->required('config.php');
        try {
            self::$connection = new PDO('mysql:host=' . $conData['server'] . ';dbname=' . $conData['dbname']
                , $conData['dbuser'], $conData['dbpass']);
            self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_OBJ);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
            self::$connection->exec('SET NAMES utf8');
        } catch (PDOException $e){
            die($e->getMessage());
        }

    }

    public function connection(){
        return self::$connection;
    }

    public function table($table){
        $this->table = $table;
        return $this;
    }

    public function from($table){
        return $this->table($table);
    }

    public function data($key , $value = null){
        if (is_array($key)){
            $this->data = array_merge($this->data , $key);
            $this->addToBindings($key);
        } else {
            $this->data[$key] = $value;
            $this->addToBindings($value);
        }
        return $this;
    }

    public function where(...$bindings){
        $sql = array_shift($bindings);
        $this->addToBindings($bindings);
        $this->wheres[] = $sql;
        return $this;
    }

    public function update($table = null){
        if($table){
            $this->table($table);
        }
        $sql = 'UPDATE '.$this->table . ' SET ';
        $sql .= $this->setFields();
        if($this->wheres){
            $sql .= ' WHERE ' .implode('',$this->wheres);
        }
        $this->query($sql , $this->bindings);
        $this->reset();
        return $this;

    }

    public function insert($table =null){
        if($table){
            $this->table($table);
        }

        $sql = 'INSERT INTO '.$this->table . ' SET ';
        $sql .= $this->setFields();
        $this->query($sql , $this->bindings);
        $this->lastId = $this->connection()->lastInsertId();
        $this->reset();
        return $this;
    }

    public  function addToBindings($value)
    {
        if (is_array($value)) {
            $this->bindings = array_merge($this->bindings, array_values($value));
        } else {
            $this->bindings[] = $value;
        }
    }

    public function query(...$bindings){
        $sql = array_shift($bindings);
        if(count($bindings) == 1 and is_array($bindings[0])){
            $bindings = $bindings[0];
        }
        try {
            $query = $this->connection()->prepare($sql);
            foreach ($bindings as $key => $value) {
                $query->bindValue($key + 1, _e($value));
            }
            $query->execute();
            return $query;
        } catch (PDOException $e){
            echo $sql;
            pre($this->bindings);
            die($e->getMessage());
        }
    }

    public function lastId(){
        return $this->lastId;
    }

    public function setFields(){
        $sql = '';
        foreach ($this->data as $key => $value){
            $sql .= '`' . $key . '` = ? , ';
        }
        $sql = rtrim($sql , ', ');
        return $sql;
    }

    public function select($select){
        $this->selects[] = $select;
        return $this;
    }

    public function join($join){
        $this->joins[]= $join;
        return $this;
    }

    public function offsetLimit($offset , $limit = 0){
        $this->offset = $offset;
        $this->limit = $limit;
        return $this;
    }

    public function fetch($table = null){
         if($table){
             $this->table = $table;
         }

         $sql = $this->fetchStatment();
        echo $sql;
         $result = $this->query($sql , $this->bindings)->fetch();
         $this->reset();
         return $result;
    }

    public function fetchAll($table = null){
        if($table){
            $this->table = $table;
        }

        $sql = $this->fetchStatment();
        $query = $this->query($sql , $this->bindings);
        $results = $query->fetchAll();
        $this->rows = $query->rowCount();
        $this->reset();
        return $results;
    }

    public function getRows(){
        return $this->rows;
    }


    private function fetchStatment(){
        $sql = 'SELECT ';
        if($this->selects){
            $sql .= implode(',' , $this->selects);
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM '.$this->table . ' ';
        if($this->joins){
            $sql .= implode(' ',$this->joins);
        }
        if($this->wheres){
            $sql .= ' WHERE '.implode(' ',$this->wheres);
        }
        if($this->limit){
            $sql .= ' LIMIT '.$this->limit;
        }
        if ($this->offset){
            $sql .= ' OFFSET ' .$this->offset;
        }
        if($this->orderBy){
            $sql .= ' ORDER BY '.implode(' ',$this->orderBy);
        }
        return $sql;
    }

    public function orderBy($orderBy , $sort= 'ASC'){
        $this->orderBy = [$orderBy , $sort];
        return $this;
    }

    public function delete($table = null){
        if($table){
            $this->table = $table;
        }
        $sql = 'DELETE FROM '.$this->table.' ';
        if($this->wheres){
            $sql .= ' WHERE '.implode(' ' , $this->wheres);
        }
        $this->query($sql , $this->bindings);
        $this->reset();
        return $this;
    }

    private function reset(){
        $this->data = [];
        $this->bindings = [];
        $this->limit = null;
        $this->offset =null;
        $this->table = null;
        $this->selects = [];
        $this->joins = [];
        $this->wheres = [];
        $this->orderBy = [];
    }


}