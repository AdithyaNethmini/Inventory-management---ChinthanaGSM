<?php
#Headers for accept requests from remote origin
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
session_start();

require_once('./db_connect.php');
    $conn = getConnection ();
    $sql = "SELECT `stock_quantity`,`stock_supplier_id` FROM `stock` WHERE `stock_id` = ?";

    $quantity = $_POST["quantity"];
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $stockId);
    $stockId = $_POST["stockId"];
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);

    if (($row["stock_quantity"]) < $quantity) {
        echo ("<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Error!</strong> Not enough stocks to return. Please check again!</div>");
    }
    else {
        $stockName = $_POST["stockName"];
        $brandName = $_POST["brandName"];
        $supid = $row["stock_supplier_id"];
        $manYear = $_POST["manYear"];
        $wholeSalePrice = $_POST["wholeSalePrice"];
        $quantity = $_POST["quantity"];
        $return_note = $_POST["return_note"];

        $sql = "INSERT INTO `return_stock` (`retstock_id`, `retstock_item_name`, `retstock_brand_name`, `retstock_supplier_id`, `retstock_man_year`, `retstock_wsp`, `retstock_quantity`, `retstock_note`) 
        VALUES (NULL, '".$stockName."', '".$brandName."', '".$supid."', '".$manYear."', '".$wholeSalePrice."', '".$quantity."', '".$return_note."');";

        if ($conn->query($sql) === TRUE) {
            $sql = "UPDATE `stock` SET `stock_quantity` = '".$row["stock_quantity"]-$quantity."' WHERE `stock`.`stock_id` = ".$stockId."";
            if ($conn->query($sql) === TRUE) {
                echo ("<div class='alert alert-success alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Success!</strong> Stock returned successfully!</div>");
              } else {
                echo ("<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Error!</strong> Query failed!</div>");
              }
        } else {
            echo ("<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Error!</strong> Query failed!</div>");
        }
    }
?>