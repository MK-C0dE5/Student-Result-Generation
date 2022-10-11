<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>classes</title>
</head>
<body>
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
            $subject_1 = convert($subject_1);
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
            $subject_2 = convert($subject_2);
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
            $subject_3 = convert($subject_3);
        }
        if(empty($_POST['subject_4']))
        {
            $error .= '<p align="center" style="font-size:14pt; color:red;">Enter Subject 4</p>';
        }
        else
        {
            $subject_4 = clean_text($_POST['subject_4']);
            if(invalidtext($subject_4))
            {
                $error .= '<p align="center" style="font-size:14pt; color:red;">Only letter and whitespace allowed</p>';
            }
            $subject_4 = convert($subject_4);
        }
        if(empty($_POST['subject_5']))
        {
            $error .= '<p align="center" style="font-size:14pt; color:red;">Enter Subject 5</p>';
        }
        else
        {
            $subject_5 = clean_text($_POST['subject_5']);
            if(invalidtext($subject_5))
            {
                $error .= '<p align="center" style="font-size:14pt; color:red;">Only letter and whitespace allowed</p>';
            }
            $subject_5 = convert($subject_5);
        }
        if(empty($_POST['subject_6']))
        {
            $error .= '<p align="center" style="font-size:14pt; color:red;">Enter Subject 6</p>';
        }
        else
        {
            $subject_6 = clean_text($_POST['subject_6']);
            if(invalidtext($subject_6))
            {
                $error .= '<p align="center" style="font-size:14pt; color:red;">Only letter and whitespace allowed</p>';
            }
            $subject_6 = convert($subject_6);
        }
        if($error == "")
        {
            $result .= createclass($conn, $name, $subject_1, $subject_2, $subject_3, $subject_4, $subject_5, $subject_6);
            if($result !== "Class Already Existed")
            {
                $result .= createtable($conn, $name, $subject_1, $subject_2, $subject_3, $subject_4, $subject_5, $subject_6);
            }
        }
    }
    ?>
    <form action="" method="post">
        <div>
            <center><h2>Create a Class</h2></center>
            <hr style="width:50%;">
        </div>
        <div>
            <center><table>
                <tr>
                    <td style="font-size:15pt;">Enter class name : </td>
                    <td><input type="text" name="class_name" placeholder="Class name" style="padding:3px; width:200px; height:20px; margin-left:25px; border-radius:5px;"></td>
                </tr>
                <tr>
                    <td style="font-size:15pt;">Enter subject names : </td>
                    <td> 1. <input input type="text" name="subject_1" placeholder="1st subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>                   
                </tr>
                <tr>
                    <td></td>
                    <td> 2. <input input type="text" name="subject_2" placeholder="2nd subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td> 3. <input input type="text" name="subject_3" placeholder="3rd subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td> 4. <input input type="text" name="subject_4" placeholder="4th subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td> 5. <input input type="text" name="subject_5" placeholder="5th subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td> 6. <input input type="text" name="subject_6" placeholder="6th subject" style="padding:3px; width:200px; height:20px; border-radius:5px; margin-left:10px; "></td>
                </tr>
                <tr>
                    <td><input type="submit" name="create" value="Create Class" style="width:100px; height:30px; padding:3px; border-radius:5px; margin:10px;"></td>
                </tr>
            </table></center>
        </div>
        <div><center>
            <?php
                echo $error;
                echo $result;
            ?></center>
        </div>
           <br><br><br>
        <div>
            <h3><a href="delete_class.php" style="margin-left:500px;" target="delete">Delete Class</a></h3>
            <center><iframe style="height:300px; width:1000px;" name="delete" frameborder="0"></iframe></center>
        </div>
    <form>
</body>
</html>