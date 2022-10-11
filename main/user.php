<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
</head>
<style>
    body {
  font-family: Arial, sans-serif;
  padding:5px;
  overflow:hidden;
}
a{
    text-decoration:none;
    color:Black;
}
</style>
<body>
    <?php
        session_start();
        if (isset($_SESSION['userid']) && isset($_SESSION['useruid'])) {
            $user = $_SESSION['useruid'];
            $name = $_SESSION["name"];
            if($user == "mayur" && $name == "Mayur Khadde")
            {
    ?>
    <center>
    <div class = "div1" style="height:800px; width:800px; border:2px solid black;">
        <table>
            <tr>
                <td><h2><a href="add_user.php" target="frame4" style="margin-left:0px;">Add User</a></h2></td>
                <td><h2><a href="delete_user.php" target ="frame4"style="margin-left:250px;">Delete User</a></h2></td>
            </tr>
        </table>
        <div>
            <iframe style="height:600px; width:500px; border:0px; " name = "frame4">
            <div>
        </div>
        </div>
        </div>
        </center>
    <?php
            }
            else
            {
                ?>
                <center><h2>You are not allowed</h2></center>
                <?php
            }
        }
        ?>
</body>
</html>