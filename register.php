<?php

require_once 'src/connection.php';
require_once 'src/User.php';

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_POST['firstname']) && isset($_POST['secondname']) && isset($_POST['email']) && isset($_POST['password'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $firstname = $_POST['firstname'];
            $secondname = $_POST['secondname'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (strlen($password) < '8') {
                $error = "Hasło musi mieć minimum 8 znaków!";
                include('error.php');
            } elseif (!preg_match("#[0-9]+#", $password)) {
                $error = "Hasło musi mieć minimum 1 liczbe!";
                include('error.php');
            } elseif (!preg_match("#[A-Z]+#", $password)) {
                $error = "Hasło musi mieć minimum 1 duży znak!";
                include('error.php');
            } elseif (!preg_match("#[a-z]+#", $password)) {
                $error = "Hasło musi mieć minimum 1 mały znak!";
                include('error.php');
            } else {

                $user = new User();

                $user->setFirstname($firstname);
                $user->setSecondname($secondname);
                $user->setEmail($email);
                $user->setPassword($password);


                if (null !== $user->loadUserByEmail($conn, $email)) {
                    $error = "Błąd, Istnieje już użytkownik o podanym adresie Email!";
                    include('error.php');
                } else {
                    $user->saveToDB($conn);
                    require_once('web/includedFile/registersucces.html');
                    header("refresh:5;url=login.php");
                }
            }
        } else {
            $error = "Błąd, adres Email jest niepoprawny!";
            include('error.php');
        }
    }
} else {
    require_once('web/includedFile/register.html');
}