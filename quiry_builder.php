<?php

class Builder
{
    public $dsn ="mysql:host=localhost;dbname=coding";
    public $username = "root";
    public $pass = "";
    private $pdo ;
    private $final;

    public function __construct()
    {
        $this->pdo = new PDO($this->dsn,$this->username,$this->pass);
        echo "Connected successfully to DB";
    }

    public function select($columns = "*",$table,$condition = null){
        if($condition != null)$this->final="SELECT ".$columns." FROM ".$table." WHERE $condition";
        else $this->final="SELECT ".$columns." FROM ".$table;
        return $this;
    }

    public function update($table,$columns,$values,$condition){
        if(count($columns) == count($values)){
            $this->final = "UPDATE ".$table." SET ";
            for ($i=0 ; $i<count($values) ; $i++) {
                $column = $columns[$i];
                $value = $values[$i];
                if ($i == count($values) - 1) $pair = "$column = \"$value\"";
                else $pair = "$column = $value , ";
                $this->final .= $pair;
            }
            $this->final.=" WHERE ".$condition;
            echo $this->final;
        }
        return $this;
    }

    public function delete($table,$condition){
        $this->final = "DELETE FROM $table WHERE $condition";
        return $this;
    }

    public function insert($table,$columns,$values){
        if(count($columns) == count($values)){
            $this->final = "INSERT INTO $table (";
            for ($i=0 ; $i<count($columns) ; $i++) {
                $column = $columns[$i];
                if ($i == count($columns) - 1) $this->final.="$column)";
                else $this->final.="$column, ";
            }
            $this->final.=" VALUES (";
            for ($i=0 ; $i<count($values) ; $i++) {
                $value = $values[$i];
                if ($i == count($values) - 1) $this->final.=" $value)";
                else $this->final.="$value, ";
            }
                echo $this->final;
        }
        return $this;
    }

    public function orderBy ($columns){
        $this->final .= " ORDER BY $columns";
        return $this;
    }

    public function  count($columns,$table){
//        str_replace("SELECT","SELECT count($table)",$this->final);
        $this->final="SELECT COUNT($columns) FROM $table";
        return $this;
    }

    public function limit($rowCount,$offset = null){
        if($offset!= null){
            $this->final.=" LIMIT $offset , $rowCount";
        }else{
            $this->final.=" LIMIT $rowCount";
        }
        echo $this->final;
        return $this;
    }

    public function innerJoin($columns, $table1, $table2,$condition){
        $this->final = "SELECT $columns FROM $table1 INNER JOIN $table2 ON $condition";
        return $this;
    }

    public function leftJoin($columns, $table1, $table2,$condition){
        $this->final = "SELECT $columns FROM $table1 LEFT JOIN $table2 ON $condition";
        return $this;
    }

    public function rightJoin($columns, $table1, $table2,$condition){
        $this->final = "SELECT $columns FROM $table1 RIGHT JOIN $table2 ON $condition";
        return $this;
    }

    public function runQuery(){

        $stm = $this->pdo->prepare($this->final);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }
}