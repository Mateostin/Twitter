<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

require_once 'src/connection.php';
require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'src/Comment.php';
require_once 'src/Messages.php';


if (!isset($_GET['option'])) {
    $_GET['option'] = 1;
}
if (!isset($_POST['option'])) {
    $_POST['option'] = 1;
}

if ('GET' === $_SERVER['REQUEST_METHOD'] && isset($_GET['option']) && $_GET['option'] === "settings" || $_GET['option'] === 'security') {
    include('web/includedFile/userSettings.php');
} elseif ('POST' === $_SERVER['REQUEST_METHOD'] && isset($_GET['option']) && $_GET['option'] === "settings" || $_GET['option'] == 'security') {
    include('web/includedFile/userSettings.php');
} elseif ('GET' === $_SERVER['REQUEST_METHOD'] && isset($_GET['option']) && $_GET['option'] === "changename") {
    include('web/includedFile/changeSettings.php');
} elseif ('GET' === $_SERVER['REQUEST_METHOD'] && isset($_GET['option']) && $_GET['option'] === "changesurname") {
    include('web/includedFile/changeSettings.php');
} elseif ('GET' === $_SERVER['REQUEST_METHOD'] && isset($_GET['option']) && $_GET['option'] === "changemail") {
    include('web/includedFile/changeSettings.php');
} elseif ('GET' === $_SERVER['REQUEST_METHOD'] && isset($_GET['option']) && $_GET['option'] === "changepass") {
    include('web/includedFile/changeSettings.php');
} else {

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
    </head>
    <body>


    <!-- UPPER BAR (Browsing User) -->

    <?php include('web/includedFile/upperBar.php'); ?>

    <!-- USER PANEL DIV -->

    <?php include('web/includedFile/userPanel.php'); ?>

    <!-- TWEET FORM DIV -->

    <?php include('web/includedFile/tweetform.php'); ?>

    <!-- FOOTER -->

    <?php include('web/includedFile/footer.php'); ?>

    </body>
    </html>

<?php } ?>
