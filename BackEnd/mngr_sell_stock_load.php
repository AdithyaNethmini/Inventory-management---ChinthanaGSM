<?php
#Headers for accept requests from remote origin
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
session_start();

require_once('./db_connect.php');
    $conn = getConnection ();
    #This script returns stock names to front-end when there is an Ajax request
    $sql = "SELECT `stock_id`,`stock_item_name` FROM `stock`";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo("<select class='form-control form-control-user-dropdown' name='stockId' id='stockId' onchange='dropdownChange()'>
        <option value=''>Stock Name (Select One)</option>");
        while($row = mysqli_fetch_assoc($result)) {
            echo ("
            <option value=".$row["stock_id"].">".$row["stock_item_name"]."</option>
            ");
        }
        echo("</select>");
    } else {
        echo "0 results";
    } 
?>