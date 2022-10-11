<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modification</title>
</head>
<style>
body {
  font-family: Arial, sans-serif;
  padding:5px;
  margin-left:40px;
}
    </style>
<body>
<?php
    require_once ("login.dbh.php");
    function get_data($conn, $class, $Roll_no)
    {
        $result = "";
        $records = ("SELECT * FROM $class WHERE Roll_no = $Roll_no");
        $data = $conn->query($records);
        if($data->num_rows > 0)
        {
            while($date = mysqli_fetch_array($data))
            {
            $result = $date;
            } 
            return $result;
        }
        else
        {
            return $conn->error;
        }
    }
    function get_data2($conn, $class, $Roll_no)
    {
    $sql = "SELECT * FROM $class WHERE Roll_no = $Roll_no";
    $smt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($smt, $sql)){
        header("location = test.php?error=classExists_stmtfailed");
        exit();
    }
        mysqli_stmt_execute($smt);
        $resultData = mysqli_stmt_get_result($smt);
        if($row = mysqli_fetch_array($resultData)) {
            return $row;
        }
        else{
            $result = $conn->error;
            return $result;
        }
    smt->close();
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
    function column_name($conn, $class)
    {
      $result = "";
      $query = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$class'");
        if($query->num_rows > 0)
        {
            while($row = mysqli_fetch_array($query))
            {
                $result .= $row['COLUMN_NAME']." ";
            }
            return $result;
        }
        else
        {
            $result = "Not Found".$conn->error;
            return $result;
        }
    }
    $Roll_no = $_GET['id'];
    $class = $_GET['class'];
    $result = get_data($conn, strtolower($class), $Roll_no);
    $count = column_no($conn, $class);
    $column = column_name($conn, $class);
    $res = explode(" ", $column);
    $error = "";
    if(isset($_POST['Edit']))
    {
        $name = $_POST['name'];
        $new_result = "";
        $subject = ['subject_1','subject_2','subject_3','subject_4','subject_5','subject_6'];
        for($i=2;$i<$count;$i++)
        {
            $new_result .= $_POST["Subject_".$i-1];
            $new_result .= " ";
        }
        $new_result1 = explode(" ",$new_result);
        for($i=0;$i<$count-2;$i++)
        {
            if(is_numeric($new_result1[$i]))
            {
                $error = "";
            }
            else
            {
                $error = "Subject_$i Must be numeric";
            }
        }
        if($error == "")
        {
            $sql = "";
            $sql .= "UPDATE $class SET Student_name = '$name' WHERE Roll_no = $Roll_no;";
            for($i=2;$i<$count;$i++)
            {
                $j = $i-2;
                $sql .= "UPDATE $class SET $res[$i] = $new_result1[$j] WHERE Roll_no = '$Roll_no';";
            }
            if($conn->multi_query($sql) === true)
            {
                $error .= "Class $class Editied Successfully";
            }
            else{
                $error .= "Error: ".$conn->error;
            }
        }
    }
    ?>

<div>
    <form action = "" method="post">
    <table>
        <tr>
            <td><h2>Edit Result</h2></td>
        </tr>
        <tr>
            <td style="font-size:15pt;">Roll_no: </td>
            <td><input type="text" name ="Roll_no" value="<?php echo $result[0]; ?>" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>
        </tr>
        <tr>
            <td style="font-size:15pt;">Name: </td>
            <td><input type="text" name = "name" value="<?php echo $result[1]; ?>" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>
        </tr>
        <?php
        for($i=2;$i<$count;$i++)
        {
            ?>
            <tr>
                <td style="font-size:15pt;">Subject_<?php echo $i-1; ?>: </td>
                <td><input type="text" name = "Subject_<?php echo $i-1 ?>" value="<?php echo $result[$i]; ?>" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td><input type="submit" name="Edit" value="Edit" style="width:100px; height:30px; padding:3px; border-radius:5px; margin:10px;"></td>
        </tr>
    </table>
    <table>
        <tr><td><b><?php echo "<br>$error"; ?></b></td></tr>
    </table>

    </form>
</div>
</body>
</html>
