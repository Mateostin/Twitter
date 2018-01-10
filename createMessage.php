<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Messages.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Twitter</title>
    <link rel="stylesheet" media="screen" href="web/CSS/indexBootstrap.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/css/emoji.css" rel="stylesheet">
    <link href="web/includedFile/emoji.css" rel="stylesheet">
    <style>
        html {
            height: 100%;
        }
    </style>
</head>
<body>

<?php include('web/includedFile/upperBar.php'); ?>

<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['sender']) && isset($_POST['receiver']) && isset($_POST['message'])) {
        if ($_SESSION['user'] != $_POST['receiver']) {
            $sender = $_POST['sender'];
            $receiver = $_POST['receiver'];
            $text = $_POST['message'];

            $sendMessage = New Messages();
            $sendMessage->setSender_id($sender);
            $sendMessage->setReceiver_id($receiver);
            $sendMessage->setText($text);
            $sendMessage->saveToDB($conn);
        }
    } else {
        echo "Błąd podczas wysyłania";
    }
    header('Location: messages.php');
} else {

    ?>

    <div class="container">
        <div class="card card-container">
            <form class="form-signin" action="createMessage.php" method="POST">
                <textarea class="form-control textarea-control your-div" maxlength="140" rows="6" cols="106"
                          name="message"
                          placeholder="Wyślij Wiadomość"></textarea>
                <input type="number" name="sender" value="<?php echo $_GET['sender']; ?>" hidden>
                <input type="number" name="receiver" value="<?php echo $_GET['receiver']; ?>" hidden>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Tweet</button>
        </div>
    </div>

<?php } ?>

</body>
</html>