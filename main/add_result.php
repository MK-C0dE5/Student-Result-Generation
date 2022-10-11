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
    }
  </style>
<body>
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
        function check_data_no($data)
        {
          if(is_numeric($data))
          {
            return true;
          }
          else
          {
            return false;
          }
        }
        function check_data_word($data)
        {
          if(is_string($data))
          {
            return true;
          }
          else
          {
            return false;
          }
        }
        function convert($string)
        {
            $string = str_replace(" ","_",$string);
            $str = ucfirst($string);
            return $str;
        }
        function invert($string)
    {
        $string = str_replace("_"," ",$string);
        return $string;
    }
    ?>
    <center>
    <form action="" method = "get">
        <table>
          <tr>
              <td><h2>Add Result</h2></td>
          </tr>
                <tr>
                <td style="font-size:15pt;">Select Table: </td>
                <td><select name = "class" style="height:30px; width:150px; border-radius:5px; margin-top:5px; margin-left:25px;">
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
        </table>
        <input type="submit" name="submit" value = "Enter" style="width:100px; height:26px; border-radius:5px; margin-top:9px;">
    </form></center>
    <form action="" method="post" style="margin-left:130px;">
    <br>
    <?php
    $col = 0;
    $column = ["name1","name2","name3","name4","name5","name6","name7","name8"];
            if(isset($_GET['submit']))
            {
                $class = $_GET['class'];
                $result = column_info($conn, $class);
                $columnArr = array_column($result, 'COLUMN_NAME');
                $result1 = $columnArr;

                $count = column_no($conn, $class);
                $col = $count;
                ?>
                <table style="margin-top:5px;">
                <?php
                for($i=0;$i<$count; $i++)
                {
                  ?>
                  <tr>
                    <td style="font-size:15pt;"><?php echo $result1[$i].":"; ?></td>
                    <td><input input type="text" name="<?php echo $column[$i]; ?>" value="" placeholder="Enter Value" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>
                </tr>
                  <?php
                }
                ?>
                <td colspan="2" align="left"><input type="submit" name = "add" value="add" style="width:100px; height:26px; border-radius:5px; margin-top:9px;"></td>
            </form>
                <?php
            }
            else
            {
    
            }
    ?>
    </form>
    <?php
          $error = "";
          if(isset($_POST['add']))
          {
            $name = $_GET['class'];
            $new_result = "";
            for($i=0; $i<$col; $i++)
            {
              $new_result .= $_POST[$column[$i]];
              $new_result .= "_";
            }
            $new_result1 = explode("_",$new_result);
            $Roll_no = $new_result1[0];
            if(preg_match('/^[0-9]*$/', $Roll_no))
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
                    $error .= "$result1[$i] Need to be numeric";
                  }
                }
              }
              else
              {
                $error .= "Name need to be string";
              }
            }
            else
            {
              $error .= "Roll_no Need to be numeric";
            }
            if($error == "")
            {
              if(get_data($conn, $name, $Roll_no) === "")
              {
                $error .= add_result($conn, $col, $name, $new_result1, $result1);
              }
              else
              {
                $error .= "Data Exists";
              }
            }
          }
          else
          {
    
          }
    ?>
    <center>
    <table style="margin-top:50px;">
    <tr>
      <td><b><?php echo $error .= ""."<br>" ?></b></td>
        </tr>
        </table>
        </center>
    </form>
</body>
</html>