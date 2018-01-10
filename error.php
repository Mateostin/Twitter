<?php

if (!isset($error)) {
    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rejestracja</title>
    <link rel="stylesheet" media="screen" href="web/CSS/bootstrap.css">
</head>
<body>
<div class="container-error">
    <div class="card card-container-error">
        <img id="profile-img" class="profile-img-card"
             src="web/images/twittericon.png"/>
        <span class="reauth-error"><?php echo $error; ?></span>
        <br>
        <br>
        <span class="reauth-text" style="font-size: medium"><a href="javascript:history.go(-1);">Powrót</a></span>
    </div>
</div>
</body>
</html>