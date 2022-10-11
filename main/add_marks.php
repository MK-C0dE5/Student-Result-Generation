<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Marks</title>
</head>
<style>
    body {
  font-family: Arial, sans-serif;
  padding:5px;
  overflow:hidden;
}
</style>
<body>
    <?php
        function column_info($conn, $name)
        {
          $result[] = "";
            $query = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'phpproject' AND TABLE_NAME = '$name'");
            $count = 0;
            while($row = $query->fetch_assoc()){
                $count = $count + 1;
                $result[] = $row;
            }
            return $result;
        }
        function column_no($conn, $name)
        {
        $query = $conn->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$name'");
        //$query .= ("SELECT * FROM COUNT(*)");
        if($row = mysqli_fetch_array($query)) {
            return $row['COUNT(*)'];
        }
        else {
            $error = "Error creating table: ".$conn->error;
            return $error;
        }
        }
        require_once "login.dbh.php";
        $error = "";

    ?>
    <div>
        <center>
        <div>
            <form action="" method="get">
        <table>
            <tr>
                <td><h2>Enter Subject Marks</h2></td>
            </tr>
            <tr>
              <td style="font-size:15pt;">Select Class name: </td>
              <td><select name = "class" style="height:30px; width:150px; margin-left:5px; padding:3px; border-radius:5px;">
              <option> Select table</option>
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
                <input type="submit" value = "Enter" name = "Enter" style="height:30px; width:100px; margin-left:5px; padding:3px; border-radius:5px;">
              </td>
              </tr>
            </table>
            </form>
        </div>
        <center>
        <center><h3><?php echo $error; ?></h3></center>
    </div>
    <?php
        $column = ["subject_1","subject_2","subject_3","subject_4","subject_5","subject_6","subject_7","subject_8","subject_9","subject_10"];
        $class = "";
        if(isset($_GET['Enter']))
        {
            $name = $_GET['class'];
            $class = $name;
            $column_name = column_info($conn, $name);
            $column_no = column_no($conn, $name);
            $columnArr = array_column($column_name, 'COLUMN_NAME');
            $result = $columnArr;
            ?>
            <center>
            <form action="" method="post">
                <table>
                    <?php
                        for($i=2;$i<$column_no;$i++)
                        {
                            $j = $i-2;
                            ?>
                            <tr>
                                <td><b><?php echo $result[$i] ?></b></td>
                                <td><input type="text" value="" placeholder="Enter Marks" style="height:20px; width:200px;" name="<?php echo $column[$j]; ?>"></td>
                            <?php
                        }
                        ?>
                        </table></center>
                        <center><table>
                        <tr>
                            <td><input type="submit" valur="Enter" name="Submit" style="height:30px; width:100px; margin-top:10px; padding:3px; border-radius:5px;">
                        </tr>
                    </table></center>
                    </form>
                <?php
        }
        else
        {

        }
            $new_result = "";
            $error = "";
            if(isset($_POST['Submit']))
            {
                for($i=2; $i<$column_no; $i++)
                {
                    $j=$i-2;
                    $new_result .= $_POST[$column[$j]];
                    $new_result .= " ";
                }
                $new_result1 = explode(" ",$new_result);
                $sql1 = "SELECT class_name FROM marks";
                $data = $conn->query($sql1);
                if($data->num_rows > 0)
                {
                    while($date = mysqli_fetch_array($data))
                    {
                    $result = $date;
                    }
                }
                    if($result[0] == $class)
                    {
                        for($i=2;$i<$column_no;$i++)
                            {
                                $j=$i-2;
                                $new_sql = "UPDATE marks SET $column[$j] = $new_result1[$j] WHERE class_name='$class';";
                                if($conn->query($new_sql) === TRUE)
                                {
                                    $error = "Data 1 trasmitted successfully";
                                }
                                else
                                {
                                    $error = "Connection Error: ".$conn->error;
                                }
                            }
                    }
                    else
                        {
                            $sql = "INSERT INTO marks (class_name) VALUES ('$name');";
                            if($conn->query($sql) === TRUE)
                            {
                                for($i=2;$i<$column_no;$i++)
                                {
                                    $j=$i-2;
                                    $new_sql = "UPDATE marks SET $column[$j] = $new_result1[$j] WHERE class_name='$name';";
                                    if($conn->query($new_sql) === TRUE)
                                    {
                                        $error = "Data trasmitted successfully";
                                    }
                                    else
                                    {
                                        $error = "Connection Error: ".$conn->error;
                                    }
                                }
                            }
                            else
                            {
                                $error = "Connection Error1: ".$conn->error;
                            }                          
                        }
        } 
            else
            {

            }
    ?>
    <center><h3><?php echo $error; ?></h3></center>
</body>
</html>