<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrator Login</title>
    <style>
        body{
        margin-top:80px;
        font-family: Arial, sans-serif;
        padding:5px;
    }
        div{
            background-color: #1e2833;
        }
        td{
            padding:10px;
        }
        input[type="text"]::placeholder { 
                  text-align: center;
              }
        .box{
        background: #fff;
        box-shadow: 1px 1px 10px #999;
        border-radius: 5px;
        padding: 50px 40px 20px;
        }
        input[type="password"]::placeholder { 
          text-align: center;
            }
        .box input[type="text"]{
            text-align:center;
        }
        .box input[type="password"]{
            text-align:center;
        }
        input::-ms-reveal,
        input::-ms-clear {
        display: none;
        }
    </style>
</head>
<body>
<?php
    require_once "main/login.dbh.php";
    require_once "main/function.php";
    $error = "";
    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(emptyInput($username, $password) !== false) {
            $error = "Empty Username and Password";
        }
        else
        {
            $error = loginUser($conn, $username, $password);
        }
    }
    ?>
    <form action="" method="post">
        <center>
        <div style="width:500px; height:350px;" class="box" >
                <table style="padding:10px;">
                <tr>
                    <h2>Administration Login</h2>
                </tr>
                <tr>
                    <br>
                    <botton style="border:2px black solid; padding:7px; border-radius: 3px; width:15px; height:3px; background-color:#214a80;">
                        <a href="Student_login.php" target="student" style="color:white; text-decoration: none;">Student Login</a>
                    </botton>
                    <br>
                    <br>
                </tr>
                <tr>
                    <td><input placeholder="Username/Email" type="text" name="username" style="width:300px; height:30px; border-radius: 5px;" ></td>
                </tr>
                <tr>
                    <td><input placeholder="Password" type="password" name="password" style="width:300px; height:30px; border-radius: 5px;" ></td>
                </tr>
                </table>
        <center><input type="submit" name="submit" value="submit" style="width:70px; height:40px; border-radius:5px; color:white; background-color: #214a80;"></center>
        </div></center>
    </form>
    <?php

?>
    <center><h3><?php echo $error; ?></h3></center>
</body>
</html>