<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Result</title>
</head>
<style>
    body{
        font-family: Arial, sans-serif;
        padding:5px;
        overflow:hidden;
    }
    a{
        text-decoration: none;
    }
    .td1{
        background-color:black;
        border-radius:5px;
    }
    .div1{
        background: #fff;
        box-shadow: 1px 1px 10px #999;
        border-radius: 5px;
        padding: 50px 40px 20px;
    }
</style>
<body>
    <center>
    <div class="div1" style="width:1000px; height:750px; border:0px black solid;">
        <div class="td1" style="height:80px;">
        <table>
            <tr>
                <td><b><h2><a href="add_column.php" target="frame3" style="color:white; margin-left:50px;">Add Column</a></h2></b></td>
                <td><b><h2><a href="edit_column.php" target="frame3" style="color:white; margin-left:180px;" >Edit Column</a></h2></b></td>
                <td><b><h2><a href="delete_column.php" target="frame3" style="color:white; margin-left:200px;">Delete Column</a></h2></b></td>
            </tr>
        </table>
        </div>
        <div>
            <iframe name="frame3" style="width:600px; height:580px; border:0px black solid;"></iframe>
        </div>
    </div>
</center>
</body>
</html>