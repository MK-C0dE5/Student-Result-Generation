<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Class</title>
</head>
<style>
    body{
        font-family: Arial, sans-serif;
        padding:5px;
    }
</style>
<?php
    require_once "login.dbh.php";
    require_once "function.php";
    $error = "";
    if(isset($_POST['delete_class']))
    {
        $name = $_POST['class'];
        $error .= "You Selected $name"."<br>";
        $error .= delete_class($conn, $name);
        $error .= delete_table($conn, $name);
    }
?>
<body>
        <form action="" method="post">
            <center><table>
                <tr>
                    <td style="font-size:15pt;">Select Class name : </td>
                    <td><select name = "class" style="height:30px; width:150px; padding:3px; border-radius:5px;">
                    <option>Select table</option>
                    <?php
                        $name = "class";
                        $sql = "SELECT class_name FROM class;";
                        $result = $conn->query($sql);
                        if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value = ".$row['class_name'].">".$row['class_name']."</option>";
                        }
                    }
                    ?>
                    </td>
                    </select>
                    <td>
                    <input type="submit" value = "delete" name = "delete_class" style="height:30px; width:100px; padding:3px; border-radius:5px;">
                </td>
                </tr>
            </table></center>
        </form>
        <br><br>
        <center><h3><?php echo $error; ?></h3></center>
</body>
</html>