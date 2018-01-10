<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    require_once('../../src/connection.php');
    require_once('../../src/User.php');
    require_once('../../src/Settings.php');
    session_start();

    switch ($_POST['confirm']) {
        case "Zmień Imię":
            Settings::nameUpdate($conn);
            break;
        case "Zmień Nazwisko":
            Settings::surnameUpdate($conn);
            break;
        case "Zmień Email":
            Settings::mailUpdate($conn);
            break;
        case "Zmień Hasło":
            Settings::passUpdate($conn);
            break;
    }

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
        <style>
            html {
                height: 100%;
            }
        </style>
    </head>
    <body>

    <!-- UPPER BAR (Browsing User) -->

    <?php include('web/includedFile/upperBar.php'); ?>

    <!-- USER PANEL DIV -->

    <?php include('web/includedFile/userPanel.php'); ?>

    <!-- SETTINGS -->
    <?php $array = User::loadUserById($conn, $_SESSION['user']); ?>

    <div class="container">
        <div class="card card-container">
            <table class='bordered'>
                <?php if (isset($_GET['option']) && $_GET['option'] == 'changename') { ?>

                    <!-- FORMULARZ ZMIANY IMIENIA -->

                    <form action="web/includedFile/changeSettings.php" method="POST">
                        <tr>
                            <th style="text-align: center;">

                                Wprowadź nowe imię:
                                <input type="text" id="inputEmail" class="form-control" name="name"
                                       placeholder="Wpisz nowe imię" required autofocus>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                Wprowadź obecne hasło:
                                <input type="password" id="inputEmail" class="form-control" name="pass"
                                       placeholder="Wpisz obecne hasło" required>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                <input type="submit" name="confirm" value="Zmień Imię">
                            </th>
                        <tr>
                    </form>

                <?php } elseif (isset($_GET['option']) && $_GET['option'] == 'changesurname') { ?>

                    <!-- FORMULARZ ZMIANY NAZWISKA -->

                    <form action="web/includedFile/changeSettings.php" method="POST">
                        <tr>
                            <th style="text-align: center;">

                                Wprowadź nowe nazwisko:
                                <input type="text" id="inputEmail" class="form-control" name="surname"
                                       placeholder="Wpisz nowe nazwisko" required autofocus>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                Wprowadź obecne hasło:
                                <input type="password" id="inputEmail" class="form-control" name="pass"
                                       placeholder="Wpisz obecne hasło" required>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                <input type="submit" name="confirm" value="Zmień Nazwisko">
                            </th>
                        <tr>
                    </form>

                <?php } elseif (isset($_GET['option']) && $_GET['option'] == 'changemail') { ?>

                    <!-- FORMULARZ ZMIANY MAILA -->

                    <form action="web/includedFile/changeSettings.php" method="POST">
                        <tr>
                            <th style="text-align: center;">

                                Wprowadź nowy adres email:
                                <input type="text" id="inputEmail" class="form-control" name="email"
                                       placeholder="Wprowadź nowy adres Email" required autofocus>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                Wprowadź obecne hasło:
                                <input type="password" id="inputEmail" class="form-control" name="pass"
                                       placeholder="Wpisz obecne hasło" required>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                <input type="submit" name="confirm" value="Zmień Email">
                            </th>
                        <tr>
                    </form>

                <?php } elseif (isset($_GET['option']) && $_GET['option'] == 'changepass') { ?>

                    <!-- FORMULARZ ZMIANY MAILA -->

                    <form action="web/includedFile/changeSettings.php" method="POST">
                        <tr>
                            <th style="text-align: center;">

                                Wprowadź nowe hasło:
                                <input type="password" id="inputEmail" class="form-control" name="passNew"
                                       placeholder="Wprowadź nowe hasło" required autofocus>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">

                                Wprowadź nowe hasło:
                                <input type="password" id="inputEmail" class="form-control" name="passNewSecond"
                                       placeholder="Wprowadź nowe hasło" required autofocus>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                Wprowadź obecne hasło:
                                <input type="password" id="inputEmail" class="form-control" name="pass"
                                       placeholder="Wpisz obecne hasło" required>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                <input type="submit" name="confirm" value="Zmień Hasło">
                            </th>
                        <tr>
                    </form>

                <?php } ?>

            </table>


        </div>
    </div>

    </body>
    </html>

<?php } ?>