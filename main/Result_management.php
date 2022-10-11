<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<style>
    body{
        font-family: Arial, sans-serif;
        padding:5px;
    }
    a{
        text-decoration: none;
    }
    </style>
<?php
    session_start();
    if (isset($_SESSION['userid']) && isset($_SESSION['useruid'])) {
        $name = $_SESSION["name"];
?>
<body>
    <form action="" method="post" style = "height:45px;">
        <table>
        <tr>
            <td><h2 style="margin:0px 20px 0px 20px; padding:2px; width:600px;">Student Result Management System</h2></td>
            <td><h2 style="margin:0px 20px 0px 600px; padding:2px; width:500px;"> Welcome, <?php echo $name; ?></h2></td>
            <td><button style="margin-left:0px; width:60px; padding:4px; border-radius: 10px; " name = "Logout">Logout</button></td>
        </tr>
        </table>
        <hr style="width:1850px;">
            <div style="height:200px; width:100px; margin-left:20px;" class = "">
                    <a href="classes.php" target="frame"><h4> Classes</h4></a>
                    <a href="Result.php" target="frame"><h4>Column</h4></a>
                    <a href="add_result2.php" target="frame"><h4>Add Result</h4></a>
                    <a href="Result2.php" target="frame"><h4>View Result</h4></a>
                    <a href="notice.php" target="frame"><h4>Notice</h4></a>
                    <a href="user.php" target="frame"><h4>Users</h4></a>
            </div>
        <div>
            <iframe style="height:850px; width:1650px; margin-top:-200px; margin-left:200px;  position:absolute; float:right; border:0px black solid;" name="frame" frameborder="2|2" ></iframe>
        </div>
    </form>
    <?php
    }
    else
    {
        header("location: ../Administrator.html");
        exit();
    }
    ?>
</body>
</html>