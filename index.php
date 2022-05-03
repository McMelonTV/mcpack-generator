<?php
echo <<<HTML_END_HERE

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World Generation Pack Editor</title>
</head>
<body>
<form action="action.php" method="post">
	<label for="height">Bottom Height </label><input name="height" type="number" min="-512" max="512"><br>
	<label for="theight">Top Height </label><input name="theight" type="number" min="-512" max="512"><br>
	<input type="submit" value="Download"><br><br>
    
    <h4>Note: </h4><h5>This will only work if the numbers are a multiplier of 16!</h5>
    <br>
    <h4>Made by <a href="https://github.com/WolfDen133">ฬ๏ɭŦ๔єภ133;#6969</a> and <a href="https://github.com/McMelonTV">McMelon#9999</a></h4>
</form>
</body>
</html>

HTML_END_HERE;