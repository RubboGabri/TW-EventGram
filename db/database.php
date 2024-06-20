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
        $query = "SELECT P.IDpost FROM Post P, infopost I WHERE P.IDpost=I.IDpost AND P.IDuser=? ORDER BY postDate DESC";
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

    public function insertUser($username, $password, $info="NULL", $profilePic="NULL"){
        $stmt = $this->prepare("INSERT INTO Utenti (username, password, salt, info, profilePic) VALUES (?, ?, ?, ?, ?)");
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password = hash('sha512', $password.$random_salt);
        $stmt->bind_param('sssss',$username, $password, $random_salt, $info, $profilePic);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function login($username, $password){
        if ($stmt = $this->prepare("SELECT IDuser, username, password, salt FROM Utenti WHERE username=? LIMIT 1")) { 
            $stmt->bind_param('s', $username); 
            $stmt->execute(); 
            $result = $stmt->get_result();
            $result = $result->fetch_all(MYSQLI_ASSOC); 
            if(count($result) == 1) {
                $user_id = $result[0]["IDuser"];
                $salt = $result[0]["salt"];
                $db_password = $result[0]["password"];
                $password = hash('sha512', $password.$salt); 
                if($this->checkBruteForceAttack($user_id)) { 
                    $result["esito"] = false;
                    $result["errore"] = "Account disabilitato, numero massimo di tentativi superato!";
                } else {
                    if($db_password == $password) {
                        $result["esito"] = true;
                    } else {
                        $now = time();
                        $stmt = $this->prepare("INSERT INTO Login_attempts (IDuser, attemptNum) VALUES (?, ?)");
                        $stmt->bind_param('is', $user_id, $now);
                        $stmt->execute();
                        $result["errore"] = "Password errata!";
                        $result["esito"] = false;
                    }
                }
            } else {
                $result["errore"] = "Utente non trovato!";
                $result["esito"] = false;
            }
        } else {
            $result["esito"] = false;
        }
        return $result;
    }
    
    private function checkBruteForceAttack($IDuser) {
        $now = time();
        $valid_attempts = $now - (60 * 60);
    
        if ($stmt = $this->prepare("SELECT attemptNum FROM Login_attempts WHERE IDuser = ? AND attemptNum > ?")) {
            $stmt->bind_param('is', $IDuser, $valid_attempts);
            $stmt->execute();
            $stmt->store_result();
            // Verifico l'esistenza di più di 10 tentativi di login falliti nell'ultima ora.
            if ($stmt->num_rows > 10) {
                return true;
            } else {
                return false;
            }
        } else {
            // Gestione degli errori di preparazione della query
            return false;
        }
    }   

    public function getUserById($idUser){
        $query = "SELECT * FROM Utenti WHERE IDuser=?";
        $stmt = $this->prepare($query);
        $stmt->bind_param('i',$idUser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserStats($IDuser){
        $query = "SELECT P.numPost, FR.numFollower, FD.numFollowed FROM (SELECT COUNT(IDpost) AS numPost FROM Post WHERE IDuser=?) AS P,
                    (SELECT COUNT(IDfollower) AS numFollower FROM Follower WHERE IDfollowed=?) AS FR,
                    (SELECT COUNT(IDfollowed) AS numFollowed FROM Follower WHERE IDfollower=?) AS FD";
        $stmt = $this->prepare($query);
        $stmt->bind_param('sss',$IDuser,$IDuser,$IDuser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>