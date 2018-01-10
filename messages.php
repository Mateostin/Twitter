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
    $senderID = $_POST['sender_id'];
    $arrayOfMessages = Messages::loadMessagesBySenderUserId($conn, $senderID, $_SESSION['user']);
} else {
    $arrayOfMessages = Messages::loadFirstMessagesByReceiverUserId($conn, $_SESSION['user']);
}
?>

<div class="container">
    <div class="card card-container">
        <table>
            <?php

            echo "<table class='bordered' style='font-size: small'>";
            echo "<thead>";


            foreach ($arrayOfMessages as $key => $value) {
                echo "<tr>";
                echo "<th class='messages'>";

                if ($value->getStatus() == 0) {
                    $senderName = "<b>" . Messages::loadUserById($conn, $value->getSenderId());
                } else {
                    $senderName = Messages::loadUserById($conn, $value->getSenderId());
                }

                echo "
                <form method='post' action='messages.php' class='inline'>
                    <input type='hidden' name='sender_id' value='" . $value->getSenderId() . "'>
                        <button type='submit' class='link-button'>
                        $senderName
                        </button>
                </form>
                <span style='float: right;'>" . $value->getcreationDate() . "</span>";
                echo "</th>";
                echo "<tr>";
                echo "<td>";
                echo $value->getText();
                echo "</td>";
                echo "</tr>";
                echo "</tr>";
            }


            echo "<thead>";
            echo "</table>";
            ?>
        </table>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    Messages::setReaded($conn, $senderID, $_SESSION['user']);
}
?>


</body>
</html>