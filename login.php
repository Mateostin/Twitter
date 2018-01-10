<?php
session_start();
require_once 'src/connection.php';
require_once 'src/User.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['action']) == "logout") {
        unset($_SESSION['user']);
    }
}

if (isset($_SESSION['user'])) {
    header("Location: index.php");
} else {

    if ('POST' === $_SERVER['REQUEST_METHOD']) {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'password');

            $user = User::loadUserByEmail($conn, $email);

            if (isset($user) && password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = $user->getId();
                $_SESSION['firstname'] = $user->getFirstname();
                $_SESSION['secondname'] = $user->getSecondname();
                header("Location: index.php");
            } else {
                $error = "Błędny adres email bądź hasło!";
                include('error.php');
                exit;
            }
        }
    } else {
        require_once('web/includedFile/login.html');
    }
}


