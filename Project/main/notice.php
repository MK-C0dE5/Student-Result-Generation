<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notice</title>
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
        $error = "";
        $text = "";
        if(isset($_POST['submit']))
        {
            $fp = fopen("notice.txt","w") or die ("Unable to open file!");
            $text = $_POST['message'];
            if(fwrite($fp, $text) == TRUE)
            {
                $error = "<br><b>Text Written Successfully</b>";
            }
            else
            {
                $error = "<b>Text Not Written</b>";
            }
        }
        else
        {
            
        }
        $fp = fopen("notice.txt","r") or die ("Unable to open file");
        if($fp == NULL)
        {

        }
        else
        {
            $read = fread($fp, filesize("notice.txt"));
            fclose($fp);
        }
    ?>
    <form align="center" method="post" action="">
        <h1>Notice Area</h1>
        <textarea name = "message" rows = "10" cols="100" placeholder="This is the notice area"><?php echo $read; ?></textarea>
        <br><br>
        <input type = "submit" name= "submit" style="height:20px; width:80px;">
    </form>
    <p align= "Center"><?php echo $error; ?></p>
</body>
</html>