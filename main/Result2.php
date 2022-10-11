<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result View</title>
</head>
<style>
.table_style {
  border-collapse: collapse;
  width: 100%;
  border: 3px solid #ddd;
  text-align: left;
}
body {
  font-family: Arial, sans-serif;
  padding:5px;
}
</style>
<body>
    <?php
        require_once "function.php";
        require_once "login.dbh.php";
    ?>
      <form action="" method="get">
        <br>
        <center>
        <table>
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
                <input type="submit" value = "Enter" name = "Select" style="height:30px; width:100px; margin-left:5px; padding:3px; border-radius:5px;">
              </td>
              </tr>
        </table>
        </center>
      </form>
<?php
    require_once "login.dbh.php";
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
    function add_result($conn, $col, $new_name, $new_result1, $result1)
    {
      $sql = "";
      $query = "";
      $error = "";
        $sql = "INSERT INTO $new_name ($result1[0]) VALUES($new_result1[0]);";
        if($conn->query($sql) === TRUE)
        {
          for($i=1;$i<$col;$i++)
          {
            $query .= "UPDATE $new_name SET $result1[$i] = '$new_result1[$i]' where Roll_no = $new_result1[0];";
          }
            if($conn->multi_query($query))
            {
              $error .= $new_result1[0]." Added Successfully";
            }
            else
            {
              $error .= "Connenction Unsuccessfull: ".$conn->error;
            }
        }
        else
        {
          $error = "Connection Unsuccessfull: ".$conn->error;
        }
      return $error;
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
    $col = 0;
    $column = ["name1","name2","name3","name4","name5","name6","name7","name8","name9","name10","name11"];
    $new_name = "";
    $result1 = "";
    if(isset($_GET['Select']))
    {
        $name = $_GET['class'];
        $result = column_info($conn, $name);
        $columns = column_no($conn, $name);
        $columnArr = array_column($result, 'COLUMN_NAME');
        $result1 = $columnArr;
        $new_name = $name;
    ?>
    <form action="" method="post">
        <table border = "1 solid black" style="margin:5px; margin-top:10px;" class = "table_style";>
        <tr>
          <?php
            for($i = 0; $i < $columns; $i++)
            {
              ?>
              <td scope="col"><b><?php echo invert($columnArr[$i]); ?></b></td>
              <?php
            }
          ?>
          <td colspan="2"><b>Operation</b></td>
        </tr>
        <tr>
            <?php
              require_once "login.dbh.php";
              $records = mysqli_query($conn, "SELECT * FROM $name ORDER BY Roll_no;");
              while($data = mysqli_fetch_array($records))
              {
                for($i = 0; $i<$columns; $i++)
                {
                ?>
                  <td><?php echo $data[$i]; ?></td>
                  <?php
                }
                ?>
                <td><a href="Edit.php?id=<?php echo $data[0];?>&class=<?php echo $name; ?>" target="frame1">Edit</a></td>
                <td><a href="delete.php?id=<?php echo $data[0];?>&class=<?php echo $name; ?>" target="frame1">Delete</a></td>
          </tr>
            <?php
              }
            ?>
            <tr>
              <?php
                $col = $columns;
                for($i=0;$i<$columns; $i++)
                {
                  ?>
                    <td><input name="<?php echo $column[$i]; ?>" value="" placeholder="Enter Value" style="width: 150px;"></td>
                  <?php
                }
                ?>
              <td colspan="2" align="center"><input type="submit" name = "add" value="add"></td>
            </tr>
            </table>
    </form>
    <?php
    }
    else{

    }
    $new_result = "";
    $error = "";
    $marks = get_data1($conn, $new_name);
    if(isset($_POST['add']))
    {
      for($i=0; $i<$col; $i++)
      {
        $new_result .= $_POST[$column[$i]];
        $new_result .= "_";
      }
      $new_result1 = explode("_",$new_result);
      if(preg_match('/^[0-9]*$/', $new_result1[0]))
            {
              if(preg_match('/^[a-zA-Z ]*$/', $new_result1[1]))
              {
                for($i=2;$i<$col;$i++)
                {
                  if(preg_match('/^[0-9]*$/', $new_result1[$i]))
                  {
                    
                  }
                  else
                  {
                    $error .= "$result1[$i] Need to be numeric<br>";
                  }
                }
              }
              else
              {
                $error .= "Name need to be string<br>";
              }
            }
      else
      {
        $error .= "Roll_no Need to be numeric<br>";
      }
      for($i=2;$i<$col; $i++)
      {
        $j = $i-1;
        if($new_result1[$i] <= $marks[$j])
        {
          
        }
        else
        {
          $error .= invert($result1[$i])." is out of bound<br>";
        }
      }
      $Roll_no = $new_result1[0];
      if($error == "")
      {
          if(get_data($conn, $new_name, $Roll_no) === "")
        {
          $error .= add_result($conn, $col, $new_name, $new_result1, $result1);
        }
        else
        {
          $error .= "Data Exists";
        }
      }
    }
    else{
      
    }
      ?>
    <center>
    <table>
      <tr><td><?php echo $error; ?></td></tr>
    </table>
    </center>
      <br><br>
  <iframe name="frame1" style="width:900px; height:480px; border:0px black solid;"></iframe>
</body>
</html>