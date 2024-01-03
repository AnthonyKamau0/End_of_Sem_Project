<?php
// Constants for database connection
$servername = "localhost";
$username = "user_admin";
$password = "12345";
$db = "semester_project";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database already exists
if (!$conn->select_db($db)) {

    $sql = "CREATE DATABASE $db";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
        $conn->close();
        exit;
    }
}

// Create connection to the specific database
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create userstb table
$sql = "CREATE TABLE userstb (
    userId INT(6) NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(255),
    user_name VARCHAR(255),
    password VARCHAR(255),
    user_type VARCHAR(255),
    access_time TIMESTAMP,
    profile_image VARCHAR(255),
    address VARCHAR(255),
    PRIMARY KEY (userId)
) ENGINE=INNODB";

// Create authortb table
$sql = "CREATE TABLE authortb (
    authorId INT(6) NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(255),
    user_name VARCHAR(255),
    password VARCHAR(255),
    user_type VARCHAR(255),
    access_time TIMESTAMP,
    profile_image VARCHAR(255),
    address VARCHAR(255),
    PRIMARY KEY (authorId)
) ENGINE=INNODB";

if ($conn->query($sql) === TRUE) {
    echo "Table userstb created successfully";
} else {
    echo "Error creating table userstb: " . $conn->error;
}

// Create articles table
$sql = "CREATE TABLE articles  (
    articleId INT(6) NOT NULL AUTO_INCREMENT,
    article_title VARCHAR(255) NOT NULL,
    article_full_text VARCHAR(255) NOT NULL,
    article_created_date TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    article_last_update TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    article_display BOOLEAN,
    article_order INT(50),
    authorId INT(6),
    FOREIGN KEY (authorId) REFERENCES userstb(userId),
    PRIMARY KEY (articleId)
) ENGINE=INNODB";

if ($conn->query($sql) === TRUE) {
    echo "Table articles created successfully";
} else {
    echo "Error creating table articles: " . $conn->error;
}

$conn->close();
?>
