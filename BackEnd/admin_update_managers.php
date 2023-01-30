<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();
    #Script for update manager details
    $sql = "UPDATE `user` SET `user_fname` = ?, `user_lname` = ?, `user_pass` = ?, `user_tp` = ?, `user_email` = ? WHERE `user`.`user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $editFname, $editLname, $editPass, $editTp, $editEmail, $editUserId);     
    $editFname = $_POST["editFname"];
    $editLname = $_POST["editLname"];
    $editPass = "12345";
    $editTp = $_POST["editTp"];
    $editEmail = $_POST["editEmail"];
    $editUserId = $_POST["editUserId"];

    if ($stmt->execute() === TRUE) {
        echo ("Update");
    } 
    else {
        echo ("Failed");
    } 
    
?>