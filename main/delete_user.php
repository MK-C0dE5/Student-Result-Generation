<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete User</title>
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
        function delete_user($conn, $new_name)
        {
            $sql = "DELETE FROM users WHERE name = '$new_name'";
            if($conn->query($sql) === TRUE)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        require_once "login.dbh.php";
        $error = "";
        if(isset($_POST['delete']))
        {
            $name = $_POST['class'];
            $new_name = invert($name);
            if(delete_user($conn, $new_name))
            {
                $error = "User Deleted Successfully";
            }
            else
            {
                $error = "User Not Deleted";
            }
        }
    ?>
    <div>
        <div>
            <form action="" method="post">
            <table>
                <tr>
                    <td>Select Name: </td>
                    <td><select name = "class" style="height:30px; width:150px; margin-left:5px; padding:3px; border-radius:5px;">
                        <option> Select table</option>
                        <?php
                            $sql = "SELECT name FROM users;";
                            $result = $conn->query($sql);
                            if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $name = $row['name'];
                                $new_name = convert($name);
                                echo "<option value = $new_name>$name</option>";
                                }
                            }
                        ?>
                    </td>
                    <td><input type="submit" name="delete" value="Delete" style="height:30px; width:100px; margin-left:5px; padding:3px; border-radius:5px;"></td>
                </tr>
            </table>
            </form>
        </div>
        <center><h3><?php echo $error; ?></h3></center>
    </div>
</body>
</html>