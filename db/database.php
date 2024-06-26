<?php
class DatabaseHelper {
    public $db;

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

    public function insertUser($username, $password){
        $stmt = $this->prepare("INSERT INTO Utenti (username, password, salt) VALUES (?, ?, ?)");
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password = hash('sha512', $password.$random_salt);
        $stmt->bind_param('sss',$username, $password, $random_salt);
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
            if ($stmt->num_rows > 10) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }   

    public function getUserById($idUser){
        $stmt = $this->prepare("SELECT * FROM Utenti WHERE IDuser=?");
        $stmt->bind_param('i',$idUser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserByUsername($username){
        $stmt = $this->prepare("SELECT * FROM Utenti WHERE username=?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserByPost($idPost) {
        $stmt = $this->prepare("SELECT U.IDuser FROM Post P JOIN Utenti U ON P.IDuser = U.IDuser WHERE P.IDpost = ?");
        $stmt->bind_param('i', $idPost);
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

    public function getFollowers($IDuser) {
        $stmt = $this->prepare("SELECT IDfollower FROM Follower WHERE IDfollowed = ?");
        $stmt->bind_param('i', $IDuser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertNotification($type, $IDuser, $notifier, $IDpost = null) {
        $stmt = $this->prepare("INSERT INTO Notifiche (type, IDuser, notifier, IDpost) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('siii', $type, $IDuser, $notifier, $IDpost);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function getNotifications($IDuser) {
        $stmt = $this->prepare("
            SELECT N.*, P.title AS post_title
            FROM Notifiche N
            LEFT JOIN Post P ON N.IDpost = P.IDpost
            WHERE N.IDuser = ?
            ORDER BY N.date DESC
        ");
        $stmt->bind_param('i', $IDuser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function markNotificationsAsRead($userID) {
        $stmt = $this->prepare("UPDATE Notifiche SET is_read = 1 WHERE IDuser = ? AND is_read = 0");
        $stmt->bind_param('i', $userID);
        return $stmt->execute();
    }

    public function getUnreadNotificationCount($IDuser) {
        $stmt = $this->prepare("SELECT COUNT(*) AS unread_count FROM Notifiche WHERE IDuser = ? AND is_read = 0");
        $stmt->bind_param('i', $IDuser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function isFollowing($IDfollower, $IDfollowed){
        $stmt = $this->prepare("SELECT * FROM Follower WHERE IDfollower=? AND IDfollowed=?");
        $stmt->bind_param('ii',$IDfollower,$IDfollowed);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function insertFollower($IDfollower, $IDfollowed){
        $stmt = $this->prepare("INSERT INTO Follower(IDfollower, IDfollowed) VALUES (?,?)");
        $stmt->bind_param('ii', $IDfollower, $IDfollowed);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function getAllPosts() {
        $query = "
            SELECT
                P.*,
                L.name AS location,
                C.name AS category,
                U.username,
                U.profilePic,
                I.numLikes,
                I.numComments
            FROM Post P 
            JOIN Locations L ON P.IDlocation = L.IDlocation 
            JOIN Categorie C ON P.IDcategoria = C.IDcategory 
            JOIN Utenti U ON P.IDuser = U.IDuser
            LEFT JOIN Infopost I ON P.IDpost = I.IDpost
            ORDER BY P.postDate DESC";
        $stmt = $this->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserPosts($idUser) {
        $query = "
            SELECT 
                P.*, 
                L.name AS location, 
                C.name AS category, 
                U.username,
                U.profilePic,
                I.numLikes, 
                I.numComments
            FROM Post P
            JOIN Locations L ON P.IDlocation = L.IDlocation 
            JOIN Categorie C ON P.IDcategoria = C.IDcategory 
            JOIN Utenti U ON P.IDuser = U.IDuser
            LEFT JOIN Infopost I ON P.IDpost = I.IDpost
            WHERE P.IDuser = ?
            ORDER BY P.postDate DESC";
        $stmt = $this->prepare($query);
        $stmt->bind_param('i', $idUser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostById($idPost) {
        $stmt = $this->prepare("SELECT * FROM Post WHERE IDpost=?");
        $stmt->bind_param('i',$idPost);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createPost($imgFile, $title, $description, $eventDate, $IDuser, $IDlocation, $price, $category, $minAge){
        $query = "INSERT INTO Post (img, title, description, eventDate, IDuser, IDlocation, price, IDcategoria, minAge) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->prepare($query);
        // Bind all parameters including the blob data
        $stmt->bind_param('bssssiisi', $imgFile, $title, $description, $eventDate, $IDuser, $IDlocation, $price, $category, $minAge);
   
        // Send the actual blob data for the first parameter
        $stmt->send_long_data(0, $imgFile);
   
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }  

    public function getAllCategories(){
        $query = "SELECT * FROM Categorie";
        $stmt = $this->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllLocations(){
        $query = "SELECT * FROM Locations";
        $stmt = $this->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function removeFollower($IDfollower, $IDfollowed){
        $stmt = $this->prepare("DELETE FROM Follower WHERE IDfollower=? AND IDfollowed=?");
        $stmt->bind_param('ii', $IDfollower, $IDfollowed);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function updateUser($IDuser, $username, $info, $profilePic = null) {
        if ($profilePic === 'REMOVE') {
            $query = "UPDATE Utenti SET username=?, info=?, profilePic=NULL WHERE IDuser=?";
            $stmt = $this->prepare($query);
            $stmt->bind_param('ssi', $username, $info, $IDuser);
        } elseif ($profilePic === null) {
            $query = "UPDATE Utenti SET username=?, info=? WHERE IDuser=?";
            $stmt = $this->prepare($query);
            $stmt->bind_param('ssi', $username, $info, $IDuser);
        } else {
            $query = "UPDATE Utenti SET username=?, info=?, profilePic=? WHERE IDuser=?";
            $stmt = $this->prepare($query);
            $stmt->bind_param('sssi', $username, $info, $profilePic, $IDuser);
        }
        return $stmt->execute();

    }

    public function deleteUser($IDuser) {
        $query = "DELETE FROM Utenti WHERE IDuser=?";
        $stmt = $this->prepare($query);
        $stmt->bind_param('i', $IDuser);
        return $stmt->execute();
    }

    public function getUserSubscriptions($idUser) {
        $query = "
                    SELECT 
                        P.*, 
                        L.name AS location, 
                        C.name AS category, 
                        U.username,
                        U.profilePic, 
                        I.numLikes, 
                        I.numComments
                    FROM Iscrizioni S
                    JOIN Post P ON S.IDpost = P.IDpost
                    JOIN Locations L ON P.IDlocation = L.IDlocation
                    JOIN Categorie C ON P.IDcategoria = C.IDcategory
                    JOIN Utenti U ON P.IDuser = U.IDuser
                    LEFT JOIN Infopost I ON P.IDpost = I.IDpost
                    WHERE S.IDuser = ?
                    ORDER BY P.postDate DESC";
        $stmt = $this->prepare($query);
        $stmt->bind_param('i', $idUser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function isSubscribed($postId, $userId) {
        $stmt = $this->prepare("SELECT * FROM Iscrizioni WHERE IDpost = ? AND IDuser = ?");
        $stmt->bind_param('ii', $postId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function insertSubscription($userId, $postId) {
        $stmt = $this->prepare("INSERT INTO Iscrizioni (IDuser, IDpost) VALUES (?, ?)");
        $stmt->bind_param('ii', $userId, $postId);
        return $stmt->execute();
    }

    public function removeSubscription($userId, $postId) {
        $stmt = $this->prepare("DELETE FROM Iscrizioni WHERE IDuser = ? AND IDpost = ?");
        $stmt->bind_param('ii', $userId, $postId);
        return $stmt->execute();
    }

    public function insertLike($IDpost, $IDuser) {
        $stmt = $this->prepare("INSERT INTO Likes (IDpost, IDuser) VALUES (?, ?)");
        $stmt->bind_param('ii', $IDpost, $IDuser);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function removeLike($IDpost, $IDuser) {
        $stmt = $this->prepare("DELETE FROM Likes WHERE IDpost=? AND IDuser=?");
        $stmt->bind_param('ii', $IDpost, $IDuser);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function isLiking($IDpost, $IDuser) {
        $stmt = $this->prepare("SELECT * FROM Likes WHERE IDpost=? AND IDuser=?");
        $stmt->bind_param('ii', $IDpost, $IDuser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function insertComment($text, $IDpost, $IDuser, $IDparent=null) {
        if ($IDparent == null) {
            $stmt = $this->prepare("INSERT INTO Commenti (text, IDpost, IDuser) VALUES (?, ?, ?)");
            $stmt->bind_param('sii', $text, $IDpost, $IDuser);
        } else {
            $stmt = $this->prepare("INSERT INTO Commenti (text, IDpost, IDuser, IDparent) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('siii', $text, $IDpost, $IDuser, $IDparent);
        }
        return $stmt->execute();
    }

    public function getComments($IDpost) {
        $stmt = $this->prepare("SELECT C.*, U.username, U.profilePic FROM Commenti C JOIN Utenti U ON C.IDuser = U.IDuser WHERE C.IDpost = ? ORDER BY C.date ASC");  
        $stmt->bind_param('i', $IDpost);
    
        if (!$stmt->execute()) {
            error_log('Execute statement failed: ' . $stmt->error); // Log statement execution error
            return [];
        }
    
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);
    
        return $this->buildCommentTree($comments);
    }
    
    private function buildCommentTree(array $comments, $parentId = null) {
        $branch = [];
        foreach ($comments as $comment) {
            if ($comment['profilePic'] !== null) {
                $comment['profilePic'] = base64_encode($comment['profilePic']);
            }
            if ($comment['IDparent'] == $parentId) {
                $children = $this->buildCommentTree($comments, $comment['IDcomment']);
                if ($children) {
                    $comment['children'] = $children;
                }
                $branch[] = $comment;
            }
        }
        return $branch;
    }

    public function getSimilarUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM Utenti WHERE username LIKE ?");
        $like_username = "%$username%";
        $stmt->bind_param('s', $like_username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRandomUsersNotFollowed($userId, $limit = 3) {
        $stmt = $this->prepare("SELECT IDuser, username, profilePic FROM Utenti
                                WHERE IDuser NOT IN (SELECT IDfollowed FROM Follower WHERE IDfollower = ?)
                                AND IDuser != ?
                                ORDER BY RAND()
                                LIMIT ?");
        $stmt->bind_param('iii', $userId, $userId, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
