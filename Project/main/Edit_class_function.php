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
    function invert($string)
    {
        $string = str_replace("_"," ",$string);
        return $string;
    }
    function convert($string)
    {
        $string = str_replace(" ","_",$string);
        return $string;
    }
    function change_column($conn, $class, $column, $column1)
    {
        $error = "";
        $sql = "ALTER TABLE $class CHANGE $column $column1 INT(128)";
        if($conn->query($sql) == TRUE)
        {
            $error .= "Column Rename Successfully";
        }
        else
        {
            $error .= "Subject $column Does not exists";
        }
        return $error;
    }
    ?>