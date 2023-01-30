<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();

    #This script returns stock details to front-end when there is an Ajax request
    $sql = "SELECT *,`supplier`.`sup_name`,profit_view.sell_profit FROM `sell_stock` LEFT JOIN supplier ON sell_stock.sellstock_supplier_id = supplier.sup_id LEFT JOIN profit_view ON sell_stock.sellstock_id = profit_view.sellstock_id GROUP BY sell_stock.sellstock_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo ("
            <li class='list-group-item'>
            <div class='row'>
                <div class='col-xl-1 col-lg-1'>
                    ".$row["sellstock_id"]."
                </div>
                <div class='col-xl-2 col-lg-2'>
                    ".$row["sellstock_item_name"]."
                </div>
                <div class='col-xl-1 col-lg-1'>
                    ".$row["sellstock_brand_name"]."
                </div>
                <div class='col-xl-2 col-lg-2'>
                    ".$row["sup_name"]."
                </div>
                <div class='col-xl-1 col-lg-1'>
                    ".$row["sellstock_man_year"]."
                </div>
                <div class='col-xl-2 col-lg-2'>
                    ".$row["sell_profit"].".00
                </div>
                <div class='col-xl-1 col-lg-1'>
                    ".$row["sellstock_quantity"]."
                </div>
                <div class='col-xl-2 col-lg-2'>
                    ".$row["sellstock_note"]."
                </div>
            </div>
        </li>
            ");
        }
    } else {
        echo "0 results";
    } 
?>