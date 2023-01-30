<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();

    #This script returns supplier details to front-end when there is an Ajax request
    $sql = "SELECT * FROM `supplier`";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo ("
            <li class='list-group-item'>
            <div class='row'>
            <div class='col-xl-1 col-lg-1'>
            ".$row["sup_id"]."
        </div>
        <div class='col-xl-2 col-lg-2'>
            ".$row["sup_name"]."
        </div>
        <div class='col-xl-4 col-lg-4'>
            ".$row["sup_address"]."
        </div>
        <div class='col-xl-2 col-lg-2'>
            ".$row["sup_tele"]."
        </div>
        <div class='col-xl-3 col-lg-3'>
            ".$row["sup_email"]."
        </div>
            </div>
        </li>
            ");
        }
    } else {
        echo "0 results";
    } 
?>