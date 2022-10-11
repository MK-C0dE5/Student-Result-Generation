<?php
    require_once "login.dbh.php";
    function emptyInput($username, $password)
    {
        if(empty($username) || empty($password))
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }
    function uidExists($conn, $username, $email) {
        $sql = "SELECT * FROM users WHERE user_Uid = ? OR email = ?;";
        $smt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($smt, $sql)) {
            header("location: ../Administrator.html?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($smt, "ss", $username, $email);
        mysqli_stmt_execute($smt);

        $resultData = mysqli_stmt_get_result($smt);
        if($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
        else{
            $result = false;
            return $result;
        }
        mysqli_stmt_close($smt);
    }
    function loginUser($conn, $username, $pass) {
        $uidExists = uidExists($conn, $username, $username);
        if($uidExists === false) {
            $error = "Username and Password is Wrong";
        }
        else
        {
          $pwdhashed = $uidExists["user_Pwd"];
          $checkPwd = password_verify($pass, $pwdhashed);
          if($checkPwd === false)
          {
            $error = "Incorrect Password";
          }
          /*if($pwdhashed != $pass) {
              header("location: ../Administrator.html?error=wronglog");
              exit();
          }*/
          elseif ($checkPwd === true) {
              session_start();
              $_SESSION["userid"] = $uidExists["id"];
              $_SESSION["useruid"] = $uidExists["user_Uid"];
              $_SESSION["name"] = $uidExists["name"];
              header("location: main/Result_management.php");
              exit();
          }
        }
        return $error;
    }
    function clean_text($string)
    {
            $string = trim($string);
            $string = stripslashes($string);
            return $string;
            
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

    function invalidtext($string)
    {
        $result;
        if(!preg_match("/^[a-zA-Z ]*$/",$string))
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }


/*   function createclass($conn, $name, $subject_1, $subject_2, $subject_3, $subject_4, $subject_5, $subject_6) {
    $error = "";
    $classExists = classExists($conn, $name);
    $sql = "INSERT INTO class (class_name, subject_1, subject_2, subject_3, subject_4, subject_5, subject_6) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $smt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($smt, $sql)) {
        $error = "<br>Class Not Created";
    }
    mysqli_stmt_bind_param($smt, "sssssss", $name, $subject_1, $subject_2, $subject_3, $subject_4, $subject_5, $subject_6);
    mysqli_stmt_execute($smt);
    mysqli_stmt_close($smt);
    $error = "<br>Class Created Successfully";
    return $error;
}*/

function createclass($conn, $name, $subject, $count) {
    $sub = ['subject_1','subject_2','subject_3','subject_4','subject_5','subject_6'];
    $error = "";
    $classExists = classExists($conn, convert($name));
    if($classExists == NULL)
    {
        $query = "";
        $sub = ['subject_1','subject_2','subject_3','subject_4','subject_5','subject_6'];
        $sql = "INSERT INTO class (class_name, subject_1) VALUES ('$name', '$subject[0]');";
        if($conn->query($sql) === TRUE) {
          for($i=1; $i<$count; $i++)
          {
              $query .="UPDATE class SET $sub[$i] = '$subject[$i]' WHERE class_name = '$name';";
          }
          if($conn->multi_query($query) === TRUE) {
              $error .= "<br>Class $name created Successfully";
          }
          else{
            $error .= "<br>Error creating table1: ".$conn->error;
          }
        }
        else {
          $error .= "<br>Error creating table: ".$conn->error;
        }
    }
    else
    {
      $position = $classExists["class_id"];
      $error = "Class Already Existed";
    }
    return $error;
    $conn->close();
  }
  function classExists($conn, $name) {
    $sql = "SELECT class_id FROM class WHERE class_name = ?;";
    $smt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($smt, $sql)){
        header("location = classes2.php?error=classExists_stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($smt, "s", $name);
    mysqli_stmt_execute($smt);
    $resultData = mysqli_stmt_get_result($smt);
    if($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
}
/*    function createtable($conn, $name, $subject_1, $subject_2, $subject_3, $subject_4, $subject_5, $subject_6) {
        $error = "";
        $sql = "CREATE TABLE '$name' (
                '$subject_1' VARCHAR(128),
                '$subject_2' VARCHAR(128),
                '$subject_3' VARCHAR(128),
                '$subject_4' VARCHAR(128),
                '$subject_5' VARCHAR(128),
                '$subject_6' VARCHAR(128)
                );";
        $smt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($smt, $sql)) {
            $error = "Table Not Created";
        }
        mysqli_stmt_bind_param($smt, "sssssss", $name, $subject_1, $subject_2, $subject_3, $subject_4, $subject_5, $subject_6);
        mysqli_stmt_execute($smt);
        mysqli_stmt_close($smt);
        $error = "Table Created Successfully";
        return $error;
    }*/
    function createtable($conn, $name, $subject_1, $subject_2, $subject_3, $subject_4, $subject_5, $subject_6) {
        $error = "";
        $sql = "CREATE TABLE $name (
                $subject_1 VARCHAR(128),
                $subject_2 VARCHAR(128),
                $subject_3 VARCHAR(128),
                $subject_4 VARCHAR(128),
                $subject_5 VARCHAR(128),
                $subject_6 VARCHAR(128)
                );";
        if($conn->query($sql) === TRUE) {
          $error .= "<br>Table $name created Successfully";
        }
        else {
          $error .= "<br>Error creating table: ".$conn->error;
        }
        return $error;
      }
    function delete_class($conn, $name){
        $error = "";
        $sql = "DELETE FROM class WHERE class_name = ?;";
        $smt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($smt, $sql)){
            header("location: delete_class.php?error=delete_class_stmt_failed");
            exit();
        }
        mysqli_stmt_bind_param($smt, "s", $name);
        mysqli_stmt_execute($smt);
        mysqli_stmt_close($smt);
        }
    function delete_table($conn, $name){
        $error = "";
        $sql = "DROP TABLE $name;";
        $smt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($smt, $sql)){
            $error = "Error in stmt";
        }
        mysqli_stmt_execute($smt);
        mysqli_stmt_close($smt);
        $error = "Class Deleted Successfully";
        return $error;
            }
        
    /*function select_data($conn, $class)
    {
        $row = "";
        $sql = "SELECT * FROM $class;";
        $smt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($smt, $sql)) {
            header("location: ../Result2.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_execute($smt);
        $resultData = mysqli_stmt_get_result($smt);
        if($row = mysqli_fetch_assoc($resultData)) {
            $row .= $row;
        }
        else{
            $result = false;
            return $result;
        }
        return $row;
    }*/
    function createta($conn, $name, $subject, $count) {
        $error = "";
        $query = "";
        $sql = "CREATE TABLE $name (
                $subject[0] VARCHAR(128),
                $subject[1] VARCHAR(128),
                $subject[2] VARCHAR(128)
                );";
        if($conn->query($sql) == TRUE) {
          for($i = 3; $i<$count; $i++)
          {
            $query .= "ALTER TABLE $name ADD $subject[$i] varchar(128);";
          }
            if($conn->multi_query($query) === TRUE) {
              $error .= "<br>Table $name Created Successfully";
            }
            else
            {
              $error .= "<br>Error Creating Table1: ".$conn->error;
            }
        }
        else {
          $error .= "<br>Error creating table: ".$conn->error;
        }
        return $error;
}
/*function createclass($conn, $name, $subject_1, $subject_2, $subject_3, $subject_4, $subject_5, $subject_6) {
    $error = "";
    $classExists = classExists($conn, convert($name));
    if($classExists == NULL)
    {
      $sql = "INSERT INTO class (class_name, subject_1, subject_2, subject_3, subject_4, subject_5, subject_6) VALUES (?, ?, ?, ?, ?, ?, ?);";
      $smt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($smt, $sql)) {
          $error = "<br>Class Not Created";
      }
      mysqli_stmt_bind_param($smt, "sssssss", $name, $subject_1, $subject_2, $subject_3, $subject_4, $subject_5, $subject_6);
      mysqli_stmt_execute($smt);
      mysqli_stmt_close($smt);
      $error = "<br>Class Created Successfully";
    }
    else
    {
      $position = $classExists["class_id"];
      $error = "Class Already Existed";
    }
    return $error;
  }*/
  function create($conn, $name, $subject, $count) {
    require_once "login.dbh.php";
    $sub = ['subject_1','subject_2','subject_3','subject_4','subject_5','subject_6'];
    $error = "";
    $classExists = classExists($conn, convert($name));
    if($classExists == NULL)
    {
        $querys = "";
        $sub = ['','','subject_1','subject_2','subject_3','subject_4','subject_5','subject_6'];
        $sql = "INSERT INTO class (class_name) VALUES ('$name')";
        if($conn->query($sql) === TRUE) {
            for($i=2; $i<$count; $i++)
            {
                $querys .="UPDATE class SET $sub[$i] = '$subject[$i]' WHERE class_name = '$name';";
            }
              $querys .= "CREATE TABLE $name ($subject[0] INT(128));";
              $querys .= "ALTER TABLE $name ADD COLUMN $subject[1] VARCHAR(128);";
            for($i=2;$i<$count; $i++)
            {
              $querys .= "ALTER TABLE $name ADD COLUMN $subject[$i] INT(10);";
            }
            if($conn->multi_query($querys) === TRUE) {
                $error .= "<br>Class and Table $name created Successfully";
            }
            else {
                  $error .= "<br>Error creating table: ".$conn->error;
                }
          }
        else {
          $error .= "<br>Error creating table1: ".$conn->error;
        }
      }
    else
    {
      $position = $classExists["class_id"];
      $error = "Class Already Existed";
    }
    return $error;
    $conn->close();
  }
?>