<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();
    $totalStock = 0;
    $totalArrivedStock = 0;
    $totalSoldStock = 0;
    $totalReturnedStock = 0;

    #This script returns stock details to front-end when there is an Ajax request
    $sql1 = "SELECT SUM(`stock_quantity`) AS `total_stocks` FROM `stock` WHERE MONTH(`stock_time`) = MONTH(CURRENT_DATE()) AND YEAR(`stock_time`) = YEAR(CURRENT_DATE())";
    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        while($row1 = mysqli_fetch_assoc($result1)) {
            $totalArrivedStock = $row1["total_stocks"];
            echo ("<script>
            document.getElementById('stocksCount').innerHTML = ".$totalArrivedStock.";
            ");
        }
        $sql2 = "SELECT SUM(`sellstock_quantity`) AS `total_sold_stocks` FROM `sell_stock` WHERE MONTH(`sellstock_time`) = MONTH(CURRENT_DATE()) AND YEAR(`sellstock_time`) = YEAR(CURRENT_DATE())";
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) > 0) {
            while($row2 = mysqli_fetch_assoc($result2)) {
                $totalSoldStock = $row2["total_sold_stocks"];
                echo ("
                document.getElementById('soldStocksCount').innerHTML = ".$row2["total_sold_stocks"].";
                ");
            }
            $sql3 = "SELECT SUM(`retstock_quantity`) AS `total_return_stocks` FROM `return_stock` WHERE MONTH(`retstock_time`) = MONTH(CURRENT_DATE()) AND YEAR(`retstock_time`) = YEAR(CURRENT_DATE())";
            $result3 = mysqli_query($conn, $sql3);
            if (mysqli_num_rows($result3) > 0) {
                while($row3 = mysqli_fetch_assoc($result3)) {
                    $totalReturnedStock = $row3["total_return_stocks"];
                    $returnPercentage = round(($totalReturnedStock/$totalSoldStock)*100, 2);
                    echo ("
                    document.getElementById('returnStocksCount').innerHTML = '".$returnPercentage."%';
                    document.getElementById('returnStocksBar').setAttribute('style', 'width: 70%'); 
                    ");
                }
                $sql4 = "SELECT COUNT(`sup_id`) AS `suppliers_count` FROM `supplier` WHERE 1";
                $result4 = mysqli_query($conn, $sql4);
                if (mysqli_num_rows($result4) > 0) {
                    while($row4 = mysqli_fetch_assoc($result4)) {
                        echo ("
                        document.getElementById('suppliersCount').innerHTML = ".$row4["suppliers_count"].";
                        ");
                    }
                    $totalStock = $totalArrivedStock+$totalSoldStock+$totalReturnedStock;

                    $arrivedPercent = round(($totalArrivedStock/$totalStock)*100, 2);
                    $soldPercent = round(($totalSoldStock/$totalStock)*100,2);
                    $returnedPercent = round(($totalReturnedStock/$totalStock)*100,2);

                    echo("
        Chart.defaults.global.defaultFontColor = '#858796';

        var ctx = document.getElementById('myPieChart');
        var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Arrived', 'Sold', 'Remaining'],
            datasets: [{
                data: [".$arrivedPercent.", ".$soldPercent.", ".$returnedPercent."],
                backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: 'rgba(234, 236, 244, 1)',
            }],
        },

        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: 'rgb(255,255,255)',
                bodyFontColor: '#858796',
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
        },
    });
                    </script>");
                }
                else {
                    echo "";
                }
            }
            else {
                echo "";
            }
        }
        else {
            echo "";
        }
    } else {
        echo "";
    } 
?>