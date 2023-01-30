<?php
    #DB Connection function - This uses to connect to DB, it returns the connection
    #SENSITIVE DB CREDENTIALS MOVED OUT
    function getConnection () {

        $config = parse_ini_file("./ini/db.ini");
        $conn = new mysqli($config["servername"], $config["username"], $config["password"], $config["dbname"]);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        else {
            return $conn;
        }
    }
?>