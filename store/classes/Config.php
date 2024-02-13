<?php
// namespace Config;
// use PDO;
// use PDOException;
trait Config
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "store"; 
    protected function connect()
    {
        // Create connection
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}

?>