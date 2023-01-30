<?php
#SELECT * FROM `stock` WHERE `stock_id` = 2

#Headers for accept requests from remote origin
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
session_start();

require_once('./db_connect.php');
    $conn = getConnection ();

    #This script returns stock names to front-end when there is an Ajax request
    $sql = "SELECT stock_id,stock_item_name,stock_brand_name,supplier.sup_name,supplier.sup_id,stock_man_year,stock_wsp,stock_quantity FROM `stock` LEFT JOIN supplier ON stock.stock_supplier_id = supplier.sup_id WHERE stock_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $stockId);
    $stockId = $_POST["stockId"];
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);

    echo("<script>
    document.getElementById('stockName').value = '".$row["stock_item_name"]."'
    document.getElementById('brandName').value = '".$row["stock_brand_name"]."'
    document.getElementById('supName').value = '".$row["sup_name"]."'
    document.getElementById('manYear').value = '".$row["stock_man_year"]."'
    document.getElementById('wholeSalePrice').value = '".$row["stock_wsp"]."'
    </script>");
?>