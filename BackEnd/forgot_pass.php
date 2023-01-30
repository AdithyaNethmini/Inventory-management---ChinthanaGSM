<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    #A temporary script for reset password. I have plans for create an email system to send password reset instructions
    require_once('./db_connect.php');
    $conn = getConnection ();
    $sql = "SELECT user_email,user_pass FROM user WHERE user_email = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $email = $_POST["email"];
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    
    if (($row["user_email"]) === $email) {
        echo ("<div class='alert alert-success alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Success!</strong> Your password is: ".$row["user_pass"]." </div>");
    }
    else {
        echo ("<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Error!</strong> Email not found</div>");
    }
?>