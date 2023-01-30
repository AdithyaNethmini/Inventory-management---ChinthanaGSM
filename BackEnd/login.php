<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();
    #Check for the username is exist or not
    $sql = "SELECT user_name FROM user WHERE user_name = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $uname = $_POST["user"];
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);

    if (($row["user_name"]) === $uname) {
        #Check the submitted password is matching
        $sql = "SELECT user_pass,user_type FROM user WHERE user_name = ?;";
        $result = $conn->query($sql);
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        $pswd = $_POST["pass"];
        if (($row["user_pass"]) === $pswd) { 
            echo ("<div class='alert alert-success alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Success!</strong> Logged in successfully!</div>");
            if ($row["user_type"] === "admin") {
                echo ("<script>window.location.href = './admin_dash.html';</script>");
            }
            else if ($row["user_type"] === "mangr") {
                echo ("<script>window.location.href = './mngr_dash.html';</script>");
            }
        }
        else {
            echo ("<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Error!</strong> Password Incorrect!</div>");
        }
    }
    else {
        echo ("<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Error!</strong> Username not found</div>");
    }

?>