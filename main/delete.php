<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Data</title>
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
    function delete($conn, $id, $class)
    {
        $error = "";
        $sql = "DELETE FROM $class WHERE Roll_no = '$id'";
        if($conn->query($sql) === TRUE)
        {
            $error .= "Roll no $id Deleted Successfully";
        }
        else
        {
            $error .= "Connection Unsuccessfull".$conn->error;
        }
        return $error;
    }

    $id = $_GET['id'];
    $class = $_GET['class'];
    $error = delete($conn, $id, $class);
    ?>
    <h3><?php echo $error; ?></h3>
    </body>
</html>