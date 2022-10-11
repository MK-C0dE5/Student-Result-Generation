<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Column</title>
</head>
<style>
    body{
        font-family: Arial, sans-serif;
        padding:5px;
        overflow:hidden;
    }
</style>
<body>
<center>
    <?php 
        require_once ("login.dbh.php");
        function add_column($conn, $name, $column, $new_position)
        {
            $error = "";
            $sql = "ALTER TABLE $name ADD COLUMN $column INT(15) AFTER $new_position;";
            if($conn->query($sql) == TRUE)
            {
                $error .= "Table $column added successfully";
            }
            else
            {
                $error .= "Table added Unsuccessfull ";
            }
            return $error;
        }
        ?>
    <form action="" method = "get">
        <table>
            <tr>
                <td><h2>Add Column</h2></td>
            </tr>
                <tr>
                <td style="font-size:15pt;">Select Table: </td>
                <td><select name = "class" style="height:30px; width:150px; border-radius:5px; margin-top:5px;">
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
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value = "Enter" style="width:100px; height:26px; border-radius:5px; margin-top:9px;"></td>
                </tr>
        </table>
    </form>
</center>
    <?php
        require_once ("Edit_class_function.php");
        $col = 0;
        $error = "";
        if(isset($_GET['submit']))
        {
            $name = $_GET['class'];
            $count = column_no($conn, $name);
            $col = $count;
            $result = column_info($conn, $name);
            $columnArr = array_column($result, 'COLUMN_NAME');
            $result1 = invert($columnArr);
            $error .= "<br>Class Names: <br><br>";
            for($i=2;$i<$count; $i++)
            {
                $j = $i-1;
                $error .= "$j. $result1[$i]<br>";
            }
            ?>
            <form action = "" method="post" style="margin-left:140px;">
                <?php echo $error; ?>
                <?php echo "<br><br>"; ?>
                <table>
                    <tr>
                        <td style="font-size:15pt;">Enter Subject Name: </td>
                        <td><input type= "text" name="column" value="" placeholder="Enter Subject name" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>
                    </tr>
                    <tr>
                        <td style="font-size:15pt;">Enter the position: </td>
                        <td><input type= "text" name="position" value="" placeholder="Enter position" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>
                    </tr>
                    <tr>                
                        <td colspan="2" align="left"><input type="submit" name = "Add" value="Add" style="width:100px; height:26px; border-radius:5px; margin-top:9px;"></td>
                    </tr>
                </table>
            </form>
            <?php
                $error1 = "";
                if(isset($_POST['Add']))
                {
                    $column1 = $_POST['column'];
                    $column = convert($column1);
                    $name = $_GET['class'];
                    $position = $_POST['position'];
                    $result = column_info($conn, $name);
                    $columnArr = array_column($result, 'COLUMN_NAME');
                    $result1 = $columnArr;
                    $new_position = $result1[$position];
                    for($i=0;$i<$col;$i++)
                    {
                        if($column == $result1[$i])
                        {
                            $error1 .= "Column Exists";
                        }
                        else
                        {
                            $error1 .= "";
                        }
                    }
                    if($error1 == "")
                    {
                        $error1 .= add_column($conn, $name, $column, $new_position);
                    }
                }
                else
                {

                }
            ?>
            <center>
            <table style="margin-top:50px;">
                <tr>
                    <td><b><?php echo $error1; ?></b></td>
                </tr>
            </table>
            </center>
            <?php
        }
    else
        {

        }
    ?>
</body>
</html>