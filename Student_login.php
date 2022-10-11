<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student_login</title>
</head>
<style>
    body{
        font-family: Arial, sans-serif;
        padding:5px;
    }
    .login_form{
        background: #fff;
        box-shadow: 1px 1px 10px #999;
        border-radius: 5px;
        padding: 50px 40px 20px;
    }
    td{
            padding:10px;
        }
    input[type="text"]::placeholder { 
        text-align: center;
        }
    </style>
<body>
    <?php
        require_once "main/login.dbh.php";
        $fp = fopen("main/notice.txt","r") or die ("Unable to open file");
        $read = fread($fp, filesize("main/notice.txt"));
        fclose($fp);
        $error = "";
        if(isset($_POST['submit']))
        {
                $Roll_no = $_POST["roll_no"];
                $name = $_POST["class"];
                if(empty($Roll_no))
                {
                    $error = "Roll_no is empty";
                }
                else if($name == "Select table")
                {
                    $error = "Select Column Name";
                }
                else
                {
                    header("location: main/final_result.php?Roll_no=$Roll_no&class=$name");
                    exit();
                }
        }
    ?>
        <div align = "center">
            <h2>Notice Area</h2>
            <h3 style="color:red">*<?php echo $read; ?>*</h3>
            <div style="width:500px; height:400px;" class="login_form">
                <center>
                <form action="" method="post" style="border:2px black;">
                    <table style="padding:3px;">
                        <tr>
                            <h2>Student Login</h2>
                        </tr>
                        <tr>
                            <br>
                            <botton style= "border:2px black solid; padding:7px; border-radius: 3px; width:15px; height:3px; background-color:#214a80;">
                                <a href="Administrator.php" style="text-decoration: none; color:white;" target="student">Administration Login</a>
                            </botton>
                            <br>
                            <br>
                        </tr>
                        <tr>
                            <td><input type="text" name="roll_no" placeholder="Enter Roll no." value="" style="width:300px; text-align:center; height:25px; border-radius:3px;" ></td>
                        </tr>
                        <tr>
                            <td><select name = "class" style="border:2px black solid; height:30px; width:300px; margin-left:5px; padding:3px; border-radius:5px; -webkit-appearance: none; ">
                            <option align="center"> Select table</option>
                            <?php
                                $name = "class";
                                $sql = "SELECT class_name FROM class;";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option align='center' value = ".$row['class_name'].">".$row['class_name']."</option>";
                                }
                                }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td><center><input type="submit" name="submit" value="submit" style="color:white; width:90px; height:35px; border-radius:5px; align-content:center; background-color:blue;"><a href="main/final_result?roll_no='<?php echo $Roll_no; ?>'&class='<?php echo $class; ?>'"></center></td>
                        </tr>
                    </table>
                </form>
                </center>
            </div>
        </div>
        <center><h3><b><?php echo $error; ?></b></h3></center>
</body>
</html>
<!--<center><br><button style=" color:white; width:90px; height:35px; border-radius:5px; align-content:center; background-color:blue;"><a href="main/final_result.php?Roll_no =<?php //echo $roll_no = $_GET['roll_no']; ?>&class=<?php //echo $class = $_GET['class']; ?>">Submit</a></button></center>-->
