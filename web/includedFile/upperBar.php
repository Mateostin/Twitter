<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="//netsh.pp.ua/upwork-demo/1/js/typeahead.js"></script>
<script>
    $(document).ready(function () {

        $('input.usersearcher').typeahead({
            name: 'usersearcher',
            remote: 'web/includedFile/searchUser.php?query=%QUERY'

        });

    })
</script>

<div class="card-bar card-container-bar">
    <div class="card-container-barparent">
        <div class="logoDiv">
            <a href="index.php">
                <img src="web/images/twittericon.png" height="40" width="40">
            </a>
        </div>
        <div class="barDiv">
            <?php
            echo "<input type='text' name='usersearcher' class='usersearcher' placeholder='Szukaj Użytkowników'>";
            ?>
        </div>
        <div class="logoutDiv">
            <?php
            echo "<button class='dropbtn btn btn-warning' onclick=\"location.href = 'login.php?action=logout';\">Wyloguj Się</button>";

            ?>
        </div>
        <div class="logoutDiv dropdown">
            <button onclick="myFunction()" class="dropbtn btn btn-warning"><img src="web/images/Usersettings.ico"
                                                                                width="30" height="30"></button>
            <div id="myDropdown" class="dropdown-content">
                <a href="index.php?option=settings"><img src="web/images/settings.ico" width="20" height="20">
                    Ustawienia Ogólne</a>
                <a href="index.php?option=security"><img src="web/images/settings.ico" width="20" height="20">
                    Bezpieczeństwo</a>
            </div>
        </div>
        <div class="logoutDiv">
            <button class="btn btn-warning text" onclick="location.href = 'messages.php';"><img
                        src="web/images/message.png" width="25" height="25">
                <?php
                if (Messages::countMessages($conn, $_SESSION['user']) != 0) {
                    echo Messages::countMessages($conn, $_SESSION['user']);
                }
                ?>
            </button>
        </div>
    </div>
</div>

<script>
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

