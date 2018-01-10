<?php

$error = '';
$errorcomment = '';

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_POST['tweet']) && !empty($_POST['tweet'])) {


        $tweetText = $_POST['tweet'];
        $user_id = $_SESSION['user'];

        if (strlen($tweetText) <= 140) {
            $tweet = new Tweet();

            $tweet->settext($tweetText);
            $tweet->setUserId($user_id);
            $tweet->saveToDB($conn);

            // Czyszczenie POST zapobiegając dodawania podczas odswiezenia strony
            unset($_POST);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error = "Twoj tweet jest zbyt długi";
        }
    }

    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
        $commentText = $_POST['comment'];
        $user_id = $_SESSION['user'];
        $tweet_id = $_POST['tweet_id'];

        if (strlen($commentText) <= 60) {
            $comment = new Comment();

            $comment->settext($commentText);
            $comment->setUserId($user_id);
            $comment->setTweetId($tweet_id);
            $comment->saveToDB($conn);

            // Czyszczenie POST zapobiegając dodawania podczas odswiezenia strony
            unset($_POST);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $errorcomment = "Twoj komentarz jest zbyt długi";
        }
    }

}

?>
<div class="container">
    <div class="card card-container">
        <span id="reauth-email" style="color: red; class=" reauth-text"><?php echo $error . $errorcomment; ?></span>
        <form class="form-signin" action="index.php" method="POST">
            <p class="lead emoji-picker-container">
                <textarea class="form-control textarea-control your-div" maxlength="140" rows="2" name="tweet"
                          placeholder="Tweetnij coś... ! :)" data-emojiable="true"></textarea>
            </p>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Tweet</button>
        </form>
    </div>
</div>

<script src="lib/js/config.js"></script>
<script src="lib/js/util.js"></script>
<script src="lib/js/jquery.emojiarea.js"></script>
<script src="lib/js/emoji-picker.js"></script>

<div class="container">
    <div class="card card-container">
        <?php

        include('emoji.php');

        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            if (isset($_GET['user']) && !empty($_GET['user']) && is_numeric($_GET['user'])) {
                $user_id = $_GET['user'];
                $array = Tweet::loadTweetByUserId($conn, $user_id);
            } else {
                $array = Tweet::loadAllTweet($conn);
            }
        }

        $counter = 0;
        $counterComments = 10 * 10 * 10;
        foreach ($array as $key => $value) {

            $arrayComments = Comment::loadCommentsByTweetId($conn, $value->getId());

            echo "<table class='bordered' style='font-size: small'>";
            echo "<thead>";
            echo "<tr>";
            $userID = $value->getUserId();
            $avatar = User::loadUserById($conn, $userID);
            echo "<th><span><img src='" . $avatar->getAvatar() . "' width='30' height='30' align='middle'> " . $value->loadUserById($conn, $userID) . "</span> <span style='float: right; font-weight: lighter'>" . $value->getCreationDate() . "</span></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tr>";
            echo "<td colspan='2'>" . emoji_unified_to_html(Tweet::makeLinks($value->gettext())) . "</td>";
            echo "</tr>";

            // COMMENTS VIEW FORM

            if (isset($arrayComments)) {

                foreach ($arrayComments as $keyComments => $valueComments) {
                    $userComment = User::loadUserById($conn, $valueComments->getUserId());
                    echo "<tr class='$counterComments' style='display: none;'>";
                    echo "<td colspan='2'>
                      <span><img src='" . $userComment->getAvatar() . "' width='30' height='30' align='middle'><b> " . $userComment->getFirstname() . " " . $userComment->getSecondname() . "</b> : " . emoji_unified_to_html(Tweet::makeLinks($valueComments->gettext())) . "</span>
                  </td>";
                    echo "</tr>";
                }
                echo "</tr>";

            }
            // ADD COMMENTS RENDER FORM

            echo "<tr>";
            echo "<td id='$counter' colspan='2' style='display: none;'>
                      <form action='index.php' method='post'>
                          <p class='lead emoji-picker-container'>
                              <textarea class='form-control textarea-control your-div' maxlength='60' rows='2' name='comment' placeholder='Napisz komentarz...' data-emojiable='true'></textarea>
                          </p>
                          <input style='display: none;' type='text' name='tweet_id' value='" . $value->getId() . "'>
                          <button type='submit'>Dodaj Komentarz</button>
                      </form>
                  </td>";
            echo "</tr>";

            // OPTIONS

            echo "<td colspan='2' style='text-align: right; background-color: seashell'>
                      <a href='JavaScript:void(0);' onClick='showHide($counter);'>Dodaj Komentarz</a> |
                      <a href='JavaScript:void(0);' onClick='showComments($counterComments, " . Comment::countComments($conn, $value->getId()) . ");'>Pokaż Komentarze(" . Comment::countComments($conn, $value->getId()) . ")</a>
                  </td>";
            echo "</table>";
            echo "<br>";

            $counter += 1;
            $counterComments += 1;
        }

        ?>

    </div>
</div>

<!-- DODAJ KOMENTARZ -->
<script>
    function showHide($counter) {
        var x = document.getElementById($counter);
        if (x.style.display === "none") {
            x.style.display = "";
        } else {
            x.style.display = "none";
        }
    }
</script>

<!-- POKARZ KOMENTARZE -->
<script>
    function showComments($counterComments, $countElement) {
        for (i = 0; i < $countElement; i++) {

            var x = document.getElementsByClassName($counterComments)[i];
            if (x.style.display === "none") {
                x.style.display = "";
            } else {
                x.style.display = "none";
            }
        }
    }
</script>

<!-- EMOJI -->
<script>
    $(function () {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: 'lib/img/',
            popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
    });
</script>
