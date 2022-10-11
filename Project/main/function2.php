<?php
require_once("login.dbh.php");
function convert($string)
    {
        $string = str_replace(" ","_",$string);
        return $string;
    }
function create($conn, $name, $subject, $count) {
  require_once "login.dbh.php";
  $sub = ['subject_1','subject_2','subject_3','subject_4','subject_5','subject_6'];
  $error = "";
  $classExists = classExists($conn, convert($name));
  if($classExists == NULL)
  {
      $querys = "";
      $query = "";
      $sub = ['subject_1','subject_2','subject_3','subject_4','subject_5','subject_6'];
      $sql = "INSERT INTO class (class_name) VALUES ('$name')";
      if($conn->query($sql) === TRUE) {
          for($i=0; $i<$count; $i++)
          {
              $querys .="UPDATE class SET $sub[$i] = '$subject[$i]' WHERE class_name = '$name';";
          }
            $querys .= "CREATE TABLE $name ($subject[0] VARCHAR(128));";
          for($i=1;$i<$count; $i++)
          {
            $querys .= "ALTER TABLE $name ADD $subject[$i] varchar(128);";
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