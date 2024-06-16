<?php
class DatabaseHelper {
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port) {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    function prepare($query) {
        $stmt = $this->db->prepare($query);
        if($stmt == false) {
            $error = $this->db->errno . ' ' . $this->db->error;
            echo $error;
        }
        return $stmt;
    }

    
}

?>