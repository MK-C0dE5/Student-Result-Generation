<?php
    require_once "main/login.dbh.php";
    require_once "main/function.php";
    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(emptyInput($username, $password) !== false) {
            header("location: Administrator.html?error=emptyinput");
            exit();
        }

        echo loginUser($conn, $username, $password);
    }
    else
    {
        header("location: Administrator.html?error=can'tgo");
        exit();
    }
    ?>