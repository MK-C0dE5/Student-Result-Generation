<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>classes</title>
</head>
<body>
    <style>
    body{
        font-family: Arial, sans-serif;
        padding:5px;
        overflow:hidden;
    }
    .div1{
        background: #fff;
        box-shadow: 1px 1px 10px #999;
        border-radius: 5px;
        padding: 50px 10px 20px;
    }
    </style>
    <?php
    require_once "function.php";
    require_once "login.dbh.php";
    $error = "";
    $name = "";
    $result = "";
    $subject_1 = "";
    $subject_2 = "";
    $subject_3 = "";
    $subject_4 = "";
    $subject_5 = "";
    $subject_6 = "";
    $subject = ['Roll_no','Student_name'];
    if(isset($_POST['create']))
    {
        if(empty($_POST['class_name']))
        {
            $error .= '<p align="center" style="font-size:14pt; color:red;">Enter Class Name</p>';
        }
        else
        {
            $name = clean_text($_POST['class_name']);
            if(invalidtext($name))
            {
                $error .= '<p align="center" style="font-size:14pt; color:red;">Only letter and whitespace allowed</p>';
            }
            $name = convert($name);
        }
        if(empty($_POST['subject_1']))
        {
            $error .= '<p align="center" style="font-size:14pt; color:red;">Enter Subject 1</p>';
        }
        else
        {
            $subject_1 = clean_text($_POST['subject_1']);
            if(invalidtext($subject_1))
            {
                $error .= '<p align="center" style="font-size:14pt; color:red;">Only letter and whitespace allowed</p>';
            }
            $subject[] .= convert($subject_1);
        }
        if(empty($_POST['subject_2']))
        {
            $error .= '<p align="center" style="font-size:14pt; color:red;">Enter Subject 2</p>';
        }
        else
        {
            $subject_2 = clean_text($_POST['subject_2']);
            if(invalidtext($subject_2))
            {
                $error .= '<p align="center" style="font-size:14pt; color:red;">Only letter and whitespace allowed</p>';
            }
            $subject[] .= convert($subject_2);
        }
        if(empty($_POST['subject_3']))
        {
            $error .= '<p align="center" style="font-size:14pt; color:red;">Enter Subject 3</p>';
        }
        else
        {
            $subject_3 = clean_text($_POST['subject_3']);
            if(invalidtext($subject_3))
            {
                $error .= '<p align="center" style="font-size:14pt; color:red;">Only letter and whitespace allowed</p>';
            }
            $subject[] .= convert($subject_3);
        }
        if(empty($_POST['subject_4']))
        {
            $error .= '<p align="center" style="font-size:14pt; color:red;">Enter Minumum 4 subject</p>';
        }
        else
        {
            $subject_4 = clean_text($_POST['subject_4']);
            if(invalidtext($subject_4))
            {
                $error .= '<p align="center" style="font-size:14pt; color:red;">Only letter and whitespace allowed</p>';
            }
            $subject[] .= convert($subject_4);
        }
        if(empty($_POST['subject_5']))
        {

        }
        else
        {
            $subject_5 = clean_text($_POST['subject_5']);
            if(invalidtext($subject_5))
            {
                $error .= '<p align="center" style="font-size:14pt; color:red;">Only letter and whitespace allowed</p>';
            }
            $subject[] .= convert($subject_5);
        }
        if(empty($_POST['subject_6']))
        {

        }
        else
        {
            $subject_6 = clean_text($_POST['subject_6']);
            if(invalidtext($subject_6))
            {
                $error .= '<p align="center" style="font-size:14pt; color:red;">Only letter and whitespace allowed</p>';
            }
            $subject[] .= convert($subject_6);
        }
        $count = sizeof($subject);
        if($error == "")
        {
            $result .= create($conn, $name, $subject, $count);
        }
    }
    ?>
    <center>
    <div class = "div1" style="height:750px; width:1000px;">
    <form action="" method="post">
        <div>
            <h2>Create a Class</h2>
        </div>
        <div>
        <div>
            <table>
                <tr>
                    <td style="font-size:15pt;">Enter class name: </td>
                    <td><input type="text" name="class_name" placeholder="Class name" style="padding:3px; width:200px; height:20px; margin-left:10px; border-radius:5px;"></td>
                </tr>
            </table>
            <br>
            <table>
                <tr>
                    <td style="font-size:15pt; align:center;">Enter subject names</td>
                </tr>
                <tr>
                    <td><input input type="text" name="subject_1" placeholder="1st subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-top:5px;"></td>                   
                </tr>
                <tr>
                    <td><input input type="text" name="subject_2" placeholder="2nd subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-top:5px;"></td>
                </tr>
                <tr>
                    <td><input input type="text" name="subject_3" placeholder="3rd subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-top:5px;"></td>
                </tr>
                <tr>
                    <td><input input type="text" name="subject_4" placeholder="4th subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-top:5px;"></td>
                </tr>
                <tr>
                    <td><input input type="text" name="subject_5" placeholder="5th subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-top:5px;"></td>
                </tr>
                <tr>
                    <td><input input type="text" name="subject_6" placeholder="6th subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-top:5px; "></td>
                </tr>
            </table>
            <input type="submit" name="create" value="Create Class" style="width:100px; height:30px; padding:3px; border-radius:5px; margin:10px;">
        </div>
        <div>
        <center><h3><?php echo $error; echo $result; ?></h3></center>
        </div>
           <br><br><br>
        <div>
            <center><h3 style="margin-top:-20px;"><a href="delete_class.php" style="text-decoration:none;" target="delete">Delete Class</a></h3></center>
            <center><iframe style="height:300px; width:1000px;" name="delete" frameborder="0"></iframe></center>
        </div>
        </div>
    <form>
    </div>
</center>
</body>
</html>