<?php

if (!isset($_GET['user'])) {
    $avatar = User::loadUserById($conn, $_SESSION['user']); ?>

    <div class="card-user card-container-user">
        <div class="avatarDiv">
            <img class="avatarImage" src="<?php echo $avatar->getAvatar(); ?>" alt="Avatar">
        </div>
        <div class="usernameDiv">
            <?php
            if (isset($_SESSION['user'])) {
            echo "<span>" . $_SESSION['firstname'] . " " . $_SESSION['secondname'] . "</span><br>";
            echo "<button style='font-size: x-small'>Ilość Tweetów: <b>" . Tweet::countTweets($conn, $_SESSION['user']) . "</b></button>";
            ?>
        </div>
        <?php
        } else {
            header("Location: login.php");
        }
        ?>
    </div>

    <?php
} else {
    $avatar = User::loadUserById($conn, $_GET['user']); ?>

    <div class="card-user card-container-user">
        <div class="avatarDiv">
            <img class="avatarImage" src="<?php echo $avatar->getAvatar(); ?>" alt="Avatar">
        </div>
        <div class="usernameDiv">
            <?php
            if (isset($_SESSION['user'])) {
            echo "<span>" . $avatar->getFirstname() . " " . $avatar->getSecondname() . "</span><br>";
            echo "<button style='font-size: x-small'>Ilość Tweetów: <b>" . Tweet::countTweets($conn, $_GET['user']) . "</b></button>";
            if ($_SESSION['user'] != $avatar->getId()) {
                echo "<button style='font-size: x-small' onclick=\"location.href='createMessage.php?sender=" . $_SESSION['user'] . "&receiver=" . $avatar->getId() . "';\">Wyslij Wiadomość</b></button>";
            }
            ?>
        </div>
        <?php
        } else {
            header("Location: login.php");
        }
        ?>
    </div>

<?php } ?>
