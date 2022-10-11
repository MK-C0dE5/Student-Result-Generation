<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
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
        require_once("login.dbh.php");
        function emptyInputSignup($name, $email, $username, $password, $check_again, $contact)
        {
            $result;
            if(empty($name) || empty($email) || empty($username) || empty($password) || empty($check_again) || empty($contact)) {
                $result = true;
            }
            else
            {
                $result = false;
            }
            return $result;
        }
        function InvalidUid($username)
        {
            $result;
            if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                $result = true;
            }
            else
            {
                $result = false;
            }
            return $result;
        }
        function InvalidEmail($email)
        {
            $result;
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $result = true;
            }
            else
            {
                $result = false;
            }
            return $result;
        }
        function passmatch($password, $check_again)
        {
            $result;
            if($password !== $check_again) {
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
                return "Stmt Failed";
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
        function createuser($conn, $name, $email, $username, $password, $contact){
            $error1 = "";
            $sql = "INSERT INTO users (name, email, user_Uid, user_Pwd, Contact) VALUES(?,?,?,?,?)";
            $smt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($smt, $sql)) {
                $error1 = "Stmt Failed";
            }

            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($smt, "sssss", $name, $email, $username, $hashedPwd, $contact);
            mysqli_stmt_execute($smt);
            mysqli_stmt_close($smt);
            $error1 = "Data Added Successfully";
            return $error1;
        }
        $error = "";
        if(isset($_POST['submit']))
        {
            $name = $_POST['name'];
            $email = $_POST['Email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $check_again = $_POST['password1'];
            $contact = $_POST['contact'];
            if(emptyInputSignup($name, $email, $username, $password, $check_again, $contact) !== false)
            {
                $error .= "Enter the inputs";
            }
            if(InvalidUid($username) !== false)
            {
                $error .= "<br>Invalid Username";
            }
            if(InvalidEmail($email) !== false)
            {
                $error .= "<br>Invalid Email";
            }
            if(passmatch($password, $check_again) !== false)
            {
                $error .= "<br>Password Not match";
            }
            if(UidExists($conn, $username, $email) !== false)
            {
                $error .= "<br>Username Exists";
            }
            if(!(is_numeric($contact)))
            {
                $error .= "<br>Enter Contact No";
            }
            if($error == "")
            {
                $error .= createuser($conn, $name, $email, $username, $password, $contact);
            }
        }

    ?>
    <div>
        <div>
            <div>
            <form action="" method="post">
                <table>
                    <tr>
                        <td><h3>Enter Name: </h3></td>
                        <td><input type="text" name="name" placeholder="Enter name" style="width:300px; height:25px; border-radius:3px;"></td>
                    </tr>
                    <tr>
                        <td><h3>Enter Email: </h3></td>
                        <td><input type="text" name="Email" placeholder="Enter email" style="width:300px; height:25px; border-radius:3px;"></td>
                    </td>
                    <tr>
                        <td><h3>Enter Username: </h3></td>
                        <td><input type="text" name="username" placeholder="Enter Username" style="width:300px; height:25px; border-radius:3px;"></td>
                    </tr>
                    <tr>
                        <td><h3>Enter Password: </h3></td>
                        <td><input type="text" name="password" placeholder="Enter Password" style="width:300px; height:25px; border-radius:3px;"></td>
                    </tr>
                    <tr>
                        <td><h3>Comform Password: </h3></td>
                        <td><input type="password" name="password1" placeholder="Enter Password" style="width:300px; height:25px; border-radius:3px;"></td>
                    </tr>
                    <tr>
                        <td><h3>Contact No: </h3></td>
                        <td><input type="text" name="contact" placeholder="Enter Phone No" style="width:300px; height:25px; border-radius:3px;"></td>
                    </tr>
                </table>
                <center><br><br><input type="submit" name="submit" value="Add User" style="width:70px; height:40px; border-radius:10px;"></center>
            </form>
            </div>
            <center><h3><?php echo $error; ?></h3></center>
        </div>
    </div>
</body>
</html>