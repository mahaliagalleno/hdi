<?php
class Db_conn{
   public function con(){
       $host = "localhost";
       $db = "ifoods_app";
       $user = "root";
       $pass= "root";
       $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
       return $conn;
    }
   public function test(){
    echo "this is a test function";
   }
}
?>