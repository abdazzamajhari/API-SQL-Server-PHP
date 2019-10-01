<?php
class Connection {
    public function getConnection(){

        try{
            $conn = new PDO("sqlsrv:Server=192.168.1.1;Database=api_db", "sa", "sa108");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn_local = $conn;
            return $conn;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }


}
