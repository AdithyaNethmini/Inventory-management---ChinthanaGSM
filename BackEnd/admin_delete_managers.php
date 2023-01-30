<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();

    #Just a simple script for delete a record
    $sql = "DELETE FROM `user` WHERE `user`.`user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delManId);
    $delManId = ($_POST['delManId']);

    if ($stmt->execute() === TRUE) {
        echo("Deleted");
    }
    else {
        echo("Cannot delete, Please check there is any stocks under selected supplier!");
    }
?>