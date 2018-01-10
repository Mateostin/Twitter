<?php
if (isset($_FILES)) {
    include('src/uploadAvatar.php');
}
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
            <?php if (isset($_GET['option']) && $_GET['option'] != 'security') { ?>
            <tr>
                <form action="src/uploadAvatar.php" method="POST" enctype="multipart/form-data"
                <th>
                </th>
                <th>
                    <input type="file" name="fileToUpload" id="fileToUpload"/>
                </th>
                <th>
                    <button type="submit">Zmień Avatar</button>
                    <br>
                </th>
                </form>
            </tr>
        </table>
        <?php } ?>
    </div>
</div>

<div class="container">
    <div class="card card-container">
        <table class='bordered'>
            <?php if (isset($_GET['option']) && $_GET['option'] != 'security') { ?>
                <tr>
                    <th colspan="3" style="text-align: center; font-size: small">
                        Aby zmienić dane konieczne będzię podanie obecnego hasła w celu weryfikacji.
                    </th>
                </tr>
                <tr>
                    <th>
                        Imię:
                    </th>
                    <th>
                        <?php echo $array->getFirstname(); ?>
                    </th>
                    <th>
                        <button type="button" onclick="location.href = 'index.php?option=changename';">Zmień Imię
                        </button>
                        <br>
                    </th>
                </tr>
                <tr>
                    <th>
                        Nazwisko:
                    </th>
                    <th>
                        <?php echo $array->getSecondname(); ?>
                    </th>
                    <th>
                        <button type="button" onclick="location.href = 'index.php?option=changesurname';">Zmień
                            Nazwisko
                        </button>
                        <br>
                    </th>
                </tr>
                <tr>
                    <th>
                        Adres Email:
                    </th>
                    <th>
                        <?php echo $array->getEmail(); ?>
                    </th>
                    <th>
                        <button type="button" onclick="location.href = 'index.php?option=changemail';">Zmień Email
                        </button>
                        <br>
                    </th>
                </tr>
            <?php } else { ?>
                <tr>
                    <th style="text-align: center; font-size: small">
                        Aby zmienić hasło konieczne będzię podanie obecnego hasła w celu weryfikacji.
                    </th>
                </tr>
                <tr>
                    <th style="text-align: center">
                        <button type="button" onclick="location.href = 'index.php?option=changepass';">Zmień Hasło
                        </button>
                        <br>
                    </th>
                </tr>
            <?php } ?>
        </table>

    </div>
</div>

</body>
</html>
