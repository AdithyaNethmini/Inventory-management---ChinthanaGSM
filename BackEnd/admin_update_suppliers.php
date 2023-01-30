<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();

    #Script for update supplier details
    $sql = "UPDATE `supplier` SET `sup_name` = ?, `sup_address` = ?, `sup_tele` = ?, `sup_email` = ? WHERE `supplier`.`sup_id` = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $editSupName, $editSupAddr, $editSupTp, $editSupEm, $editSupId);
            
    $editSupId = $_POST["editSupId"];
    $editSupName = $_POST["editSupName"];
    $editSupAddr = $_POST["editSupAddr"];
    $editSupTp = $_POST["editSupTp"];
    $editSupEm = $_POST["editSupEm"];

    if ($stmt->execute() === TRUE) {
        echo ("Update");
    } 
    else {
        echo ("Failed");
    }
?>