<?php 

ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);

require "query/Dbconnect.php";

class Query extends Dbconnect
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select($table, $columns = "*", $join = null, $where = null, $order = null, $limit = null)
    {
        $sql = "SELECT $columns FROM $table";
        if($join != null)
        {
            $sql .= " JOIN $join";
        }
        if($where != null)
        {
            $sql .= " WHERE $where";
        }
        if($order != null)
        {
            $sql .= " Order By $order";
        }
        if($limit != null)
        {
            $sql .= " LIMIT $limit";
        }

        //echo "<br>".$sql;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        if($limit == '1')
        {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            $result = $stmt->fetchAll();
        }


        return $result;
    }

    public function store($table, $datas = [])
    {
        //var_dump($datas);
        $table_columns = implode(', ', array_keys($datas));
        //echo $table_columns;
        $sql = "INSERT INTO $table($table_columns) VALUE (:".implode(', :', array_keys($datas)).") ";
       // echo "<br>".$sql;
        $stmt = $this->pdo->prepare($sql);
        foreach($datas as $key => &$data)
        {
            $stmt->bindParam(":$key", $data, PDO::PARAM_STR);
        }

        $stmt->execute();
    }

    public function update($table, $datas = [], $where)
    {
        /*$cols = '';
        $j = count($datas);
        foreach($datas as $key => $data )
        {
            $cols .= "$key = :$key"; //ContactName = 'Alfred Schmidt',

            if($j % 2 == 0)
                $cols .= ", ";
            else
                $cols .= " ";
            //echo $key." : ".$data."<br>";
            $j--;
        }

        $sql = "UPDATE $table SET $cols WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        
        foreach($datas as $key => &$data )
        {
            $stmt->bindParam(":$key", $data, PDO::PARAM_STR);
        }

        $stmt->execute();
        echo "<br>".$sql;
        */

        $args = [];
        foreach($datas as $key => $value)
        {
            $args[] = "$key = '$value'";
        }

        $sql = "UPDATE $table SET ".implode(',', $args)." WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function delete($table, $where)
    {
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        echo "<br>".$sql;
        $stmt->execute();
    }
}

?>