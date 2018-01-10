<?php
$redirect = '';

if (!isset($_POST['confirm'])) {
    $redirect = 'index.php';
} else {

    if ($_POST['confirm'] === 'Zmień Hasło') {
        $redirect = "../../index.php?option=security";
    } else {
        $redirect = "../../index.php?option=settings";
    }
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
    <link rel="stylesheet" media="screen" href="../CSS/bootstrap.css">
</head>
<body>
<div class="container-error">
    <div class="card card-container-error">
        <img id="profile-img" class="profile-img-card"
             src="../images/twittericon.png"/>
        <span class="reauth-error"><?php echo $error; ?></span>
        <br>
        <br>
        <span class="reauth-text" style="font-size: medium"><a href="<?php echo $redirect; ?>">Powrót</a></span>
    </div>
</div>
</body>
</html>