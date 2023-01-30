<?php
    header("Access-Control-Allow-Origin: *");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();
    $sql = "SELECT user_name FROM user WHERE user_name collate utf8mb4_bin = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $uname = $_POST["user"];
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);

    if (($row["user_name"]) === $uname) {
        $sql = "SELECT user_pass FROM user WHERE user_name collate utf8mb4_bin = ?;";
        $result = $conn->query($sql);
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        $pswd = $_POST["pass"];
        if (($row["user_pass"]) === $pswd) { 
            if(count($_COOKIE) > 0) {
                setCookieFunction($uname);
                $_SESSION["session_psswd"] = $pswd;
            } else {
                echo("<script>alert('You have disabled cookies. This website need cookies to run');</script>");
            }
            echo ("<div class='alert alert-success alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong id='demo'>Success!</strong> Logged in successfully!</div>");
        }
        else {
            $contentHtmlCode = "<h1 class='mt-3 text-center'><i class='far fa-frown'></i> Error!<br><small><i class='fas fa-times-circle text-danger'></i> Your password is incorrect!</small></h1><br><p class='text-center'><i class='fas fa-undo-alt'></i> Please<a class='text-success' href='../pass_reset.html'> reset</a> your password if you forgot it...</p>";
            $btnHtmlCode = "<li class='nav-item'><a class='btn btn-secondary' href='../login.html'><i class='fas fa-sign-in-alt'></i> Login</a></li>";
        }
    }
    else {
        $contentHtmlCode = "<h1 class='mt-3 text-center'><i class='far fa-frown'></i> Error!<br><small><i class='fas fa-times-circle text-danger'></i> Your username is incorrect or does not exist!</small></h1><br><p class='text-center'><i class='fas fa-undo-alt'></i> Please recheck your username or <a class='text-success' href='../register.html'>create an account</a>.</p>";
        $btnHtmlCode = "<li class='nav-item'><a class='btn btn-secondary' href='../login.html'><i class='fas fa-sign-in-alt'></i> Login</a> <a class='btn btn-success' href='../register.html'><i class='fas fa-plus-circle'></i> Register</a></li>";
    }

?>