<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Final Result</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
body{
        font-family: Arial, sans-serif;
        padding:5px;
    }
</style>
<body>
    <?php
    function get_data($conn, $Roll_no, $class)
    {
        $result = "";
        $records = ("SELECT * FROM $class WHERE Roll_no = '$Roll_no'");
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
    function get_data1($conn, $class)
    {
        $result = "";
        $records = ("SELECT * FROM marks WHERE class_name = '$class'");
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
    function invert($string)
    {
        $string = str_replace("_"," ",$string);
        return $string;
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
    require_once "login.dbh.php";
    $Roll_no = $_GET['Roll_no'];
    $class = $_GET['class'];
    $result = column_info($conn, $class);
    $columns = column_no($conn, $class);
    $columnArr = array_column($result, 'COLUMN_NAME');
    $result1 = $columnArr;
    $error = get_data($conn, $Roll_no, $class);
    if($error == "")
    {
        ?>
        <center><h2>Result Not found</h2></center>
        <?php
    }
    else
    {
    ?>
    <div>
        <div>
            <div style="height:900px; width:900px; border:2px black solid; margin-left:500px;">
                <center>
                <table style="margin-top:30px;">
                <tr>
                    <td><h1>Cusrow Wadia Institute of Technology</h1></td>
                </tr>
                <table>
                <tr>
                    <td><h2 style="margin-top:10px;">Result 2020-21</h2></td>
                </tr>
                </table>
                <tr>
                    <td><h3 style="margin-top:10px;">Department: <?php echo invert($class); ?></h3></td>
                </tr>
                </table>
                </center>
                <center>
                <table style="margin-left:-600px; font-size:15pt;">
                    <tr>
                        <td>Roll no: <?php echo $error[0]; ?></td>
                    </tr>
                    <tr>
                        <td>Name: <?php echo $error[1]; ?></td>
                    </tr>
                </table>
                <table style="margin-left:-640px; font-size:15pt;margin-top:30px;">
                    <tr>
                        <td>Marks: </td>
                    </tr>
                </table>
                </center>
                <table border = "1 solid black" class="table" style="width:700px; margin-left:100px;">
                    <tr>
                        <td scope="col"><b>#</b></td>
                        <td scope="col"><b>Subjects</b></td>
                        <td scope="col"><b>Marks</b></td>
                        <?php
                            for($i=2;$i<$columns;$i++)
                            {
                                ?>
                                <tr>
                                <td scope="row"><b><?php echo $i-1; ?></b></td>
                                <td scope="row"><?php echo $result1[$i]; ?></td>  
                                <td scope="row"><?php echo $error[$i]; ?></td>
                                </tr>
                                <?php                              
                            }
                        ?>
                    </tr>
                </table>
                <?php 
                $marks = get_data1($conn, $class);
                $sum = 0;
                $msg = "";
                $mark = 0;
                ?>
                <div style="margin-left:100px;">
                <?php
                for($i=2;$i<$columns;$i++){
                    if($error[$i] == NULL)
                    {
                        $msg = "Null Value: Result Could not be procced";
                        echo $msg;
                        exit();
                    }
                    if($error[$i] <= $marks[$i])
                    {
                        $mark = $mark + $marks[$i];
                        $sum = $sum + $error[$i];
                    }
                    else
                    {
                        $msg = "Value of $result1[$i] out of Range";
                        echo $msg;
                        $sum = 0;
                        exit();
                    }
                }
                $subject = $columns - 2;
                $total = ($sum/$mark)*100;
                ?>
                <br>
                <h5 style="margin-left:100px;">Total Marks: <?php echo $sum; ?></h5>
                <h5 style="margin-left:100px;">Percentage: <?php echo $total."%"; ?></h5>
            </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</body>
</html>