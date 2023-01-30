<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();

    #Script for update stock details
    $sql = "UPDATE `stock` SET `stock_item_name` = ?, `stock_brand_name` = ?, `stock_supplier_id` = ?, `stock_man_year` = ?, `stock_wsp` = ?, `stock_quantity` = ? WHERE `stock`.`stock_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisdii", $itemName, $brandName, $supId, $manYear, $wholeSalep, $quantity, $itemId);    
    $itemName = $_POST["itemName"];
    $brandName = $_POST["brandName"];
    $supId = $_POST["supId"];
    $manYear = $_POST["manYear"];
    $wholeSalep = $_POST["wholeSalep"];
    $quantity = $_POST["quantity"];
    $itemId = $_POST["itemId"];

    if ($stmt->execute() === TRUE) {
        echo ("Update");
    } 
    else {
        echo ("Failed");
    }
?>