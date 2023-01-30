<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();

    $sql1 = "SELECT *,supplier.sup_name FROM `stock` LEFT JOIN supplier ON stock.stock_supplier_id = supplier.sup_id WHERE MONTH(`stock_time`) = MONTH(CURRENT_DATE()) AND YEAR(`stock_time`) = YEAR(CURRENT_DATE()) GROUP BY stock.stock_id";
    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        echo("<html><head><style>table, th, td {border: 1px solid black; border-collapse: collapse; }</style></head><body><h1>Chinthana GSM, Stock - Monthly Report</h1><h2>In Stock</h2><table><tr><th>Item Name</th><th>Brand Name</th><th>Supplier</th><th>Man. Year</th><th>W.S.P</th><th>Quantity</th><th>Time</th></tr>");
        while($row1 = mysqli_fetch_assoc($result1)) {
            echo("<tr><td>".$row1['stock_item_name']."</td><td>".$row1['stock_brand_name']."</td><td>".$row1['sup_name']."</td><td>".$row1['stock_man_year']."</td><td>".$row1['stock_wsp']."</td><td>".$row1['stock_quantity']."</td><td>".$row1['stock_time']."</tr>");
        }
        echo("</table>");
        $sql1 = "SELECT *,supplier.sup_name FROM `sell_stock` LEFT JOIN supplier ON sell_stock.sellstock_supplier_id = supplier.sup_id WHERE MONTH(`sellstock_time`) = MONTH(CURRENT_DATE()) AND YEAR(`sellstock_time`) = YEAR(CURRENT_DATE()) GROUP BY sell_stock.sellstock_id";
        $result1 = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($result1) > 0) {
            echo("<h2>Sold Stocks</h2><table><tr><th>Item Name</th><th>Brand Name</th><th>Supplier</th><th>Man. Year</th><th>W.S.P</th><th>Quantity</th><th>Time</th></tr>");
            while($row1 = mysqli_fetch_assoc($result1)) {
                echo("<tr><td>".$row1['sellstock_item_name']."</td><td>".$row1['sellstock_brand_name']."</td><td>".$row1['sup_name']."</td><td>".$row1['sellstock_man_year']."</td><td>".$row1['sellstock_wsp']."</td><td>".$row1['sellstock_quantity']."</td><td>".$row1['sellstock_time']."</tr>");
            }
            echo("</table>");
            $sql1 = "SELECT *,supplier.sup_name FROM `return_stock` LEFT JOIN supplier ON return_stock.retstock_supplier_id = supplier.sup_id WHERE MONTH(`retstock_time`) = MONTH(CURRENT_DATE()) AND YEAR(`retstock_time`) = YEAR(CURRENT_DATE()) GROUP BY return_stock.retstock_id";
            $result1 = mysqli_query($conn, $sql1);
            echo("<h2>Returned Stocks</h2><table><tr><th>Item Name</th><th>Brand Name</th><th>Supplier</th><th>Man. Year</th><th>W.S.P</th><th>Quantity</th><th>Time</th></tr>");
            while($row1 = mysqli_fetch_assoc($result1)) {
                echo("<tr><td>".$row1['retstock_item_name']."</td><td>".$row1['retstock_brand_name']."</td><td>".$row1['sup_name']."</td><td>".$row1['retstock_man_year']."</td><td>".$row1['retstock_wsp']."</td><td>".$row1['retstock_quantity']."</td><td>".$row1['retstock_time']."</tr>");
            }
        }
        else {
            echo("");
        }


        echo("</table></body></html>");
    }
    else {
        echo("");
    }
?>