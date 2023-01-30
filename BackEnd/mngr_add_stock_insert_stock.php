<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();
    $sql = "INSERT INTO `stock` (`stock_item_name`, `stock_brand_name`, `stock_supplier_id`, `stock_man_year`, `stock_wsp`, `stock_quantity`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisdi", $itemname, $itembrand, $supid, $manyear, $wholesp, $quantity);
    
    $itemname = $_POST["itemName"];
    $itembrand = $_POST["brandName"];
    $supid = $_POST["supId"];
    $manyear = $_POST["manYear"];
    $wholesp = $_POST["wholeSalep"];
    $quantity = $_POST["quantity"];

    if ($stmt->execute() === TRUE) {
        echo ("<div class='alert alert-success alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Success!</strong> Stock added successfully!</div>");
    } else {
        echo ("<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Error!</strong> Query failed!</div>"); 
    }
    
?>