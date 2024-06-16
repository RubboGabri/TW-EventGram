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

    public function getUserPosts($idUser, $n=-1){
        $query = "SELECT P.IDpost FROM POST P, INFOPOST I WHERE P.IDpost=I.IDpost AND P.IDuser=? ORDER BY date DESC";
        if($n > 0){
            $query .= " LIMIT ?";
        }
        $stmt = $this->prepare($query);
        if($n > 0){
            $stmt->bind_param('ii',$idUser, $n);
        }
        else {
            $stmt->bind_param('i',$idUser);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>