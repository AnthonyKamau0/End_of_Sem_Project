<?php
// connection.php
require_once('constant.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Database {
    private $conn;

    //Establishing the database connection
    public function __construct() {
        $this->conn = new mysqli(Host_Name, Database_User, Password, Database_Name);

        // Check the connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } else {
            //echo "Connection successful!";
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function __destruct() {
        // Check if the connection is still open before closing
        if ($this->conn && $this->conn->ping()) {
            $this->conn->close();
        }
    }
}

$db = new Database();
$connection = $db->getConnection();

// Check if the connection is valid
if ($connection->ping()) {
     //echo "Database connection is valid.";
} else {
    echo "Database connection is not valid.";
}
?>
