<?php

class Settings
{

    static function nameUpdate($conn)
    {
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            if (isset($_POST['pass']) && !empty($_POST['pass'])) {
                $name = filter_input(INPUT_POST, 'name');
                $pass = filter_input(INPUT_POST, 'pass');
                if (User::passVerification($conn, $_SESSION['user'], $pass) != false) {
                    $object = User::passVerification($conn, $_SESSION['user'], $pass);
                    $object->setFirstname($name);
                    $object->saveToDB($conn);
                    $_SESSION['firstname'] = ucfirst($name);

                    $error = "Dane zostały zmienione.";
                    include('information.php');
                } else {
                    $error = "Niepoprawne Dane!";
                    include('information.php');
                }

            }
        } else {
            $error = "Proszę uzupełnić wszystkie pola.";
            include('information.php');
        }
    }

    static function surnameUpdate($conn)
    {
        if (isset($_POST['surname']) && !empty($_POST['surname'])) {
            if (isset($_POST['pass']) && !empty($_POST['pass'])) {
                $surname = filter_input(INPUT_POST, 'surname');
                $pass = filter_input(INPUT_POST, 'pass');
                if (User::passVerification($conn, $_SESSION['user'], $pass) != false) {
                    $object = User::passVerification($conn, $_SESSION['user'], $pass);
                    $object->setSecondname($surname);
                    $object->saveToDB($conn);
                    $_SESSION['secondname'] = ucfirst($surname);

                    $error = "Dane zostały zmienione.";
                    include('information.php');
                } else {
                    $error = "Niepoprawne Dane!";
                    include('information.php');
                }

            }
        } else {
            $error = "Proszę uzupełnić wszystkie pola.";
            include('information.php');
        }
    }

    static function mailUpdate($conn)
    {
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            if (isset($_POST['pass']) && !empty($_POST['pass'])) {
                $email = filter_input(INPUT_POST, 'email');
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $pass = filter_input(INPUT_POST, 'pass');
                    if (User::passVerification($conn, $_SESSION['user'], $pass) != false) {

                        if (User::loadUserByEmail($conn, $email) == null) {
                            $object = User::passVerification($conn, $_SESSION['user'], $pass);
                            $object->setEmail($email);
                            $object->saveToDB($conn);

                            $error = "Dane zostały zmienione.";
                            include('information.php');
                        } else {
                            $error = "Adres Email jest juz zajęty!";
                            include('information.php');
                        }

                    } else {
                        $error = "Niepoprawne Dane!";
                        include('information.php');
                    }
                } else {
                    $error = "Wprowadzono niepoprawny Email";
                    include('information.php');
                }
            }
        } else {
            $error = "Proszę uzupełnić wszystkie pola.";
            include('information.php');
        }
    }

    static function passUpdate($conn)
    {
        if (isset($_POST['passNew']) && !empty($_POST['passNew'])) {
            if (isset($_POST['passNewSecond']) && !empty($_POST['passNewSecond'])) {
                if (isset($_POST['pass']) && !empty($_POST['pass'])) {
                    $passNew = filter_input(INPUT_POST, 'passNew');
                    $passNewSecond = filter_input(INPUT_POST, 'passNewSecond');
                    $pass = filter_input(INPUT_POST, 'pass');
                    if ((User::passVerification($conn, $_SESSION['user'], $pass) != false) && ($passNew === $passNewSecond)) {

                        if (strlen($passNew) < '8') {
                            $error = "Hasło musi mieć minimum 8 znaków!";
                            include('information.php');
                        } elseif (!preg_match("#[0-9]+#", $passNew)) {
                            $error = "Hasło musi mieć minimum 1 liczbe!";
                            include('information.php');
                        } elseif (!preg_match("#[A-Z]+#", $passNew)) {
                            $error = "Hasło musi mieć minimum 1 duży znak!";
                            include('information.php');
                        } elseif (!preg_match("#[a-z]+#", $passNew)) {
                            $error = "Hasło musi mieć minimum 1 mały znak!";
                            include('information.php');
                        } else {

                            $object = User::passVerification($conn, $_SESSION['user'], $pass);
                            $object->setPassword($passNew);
                            $object->saveToDB($conn);

                            $error = "Dane zostały zmienione.";
                            include('information.php');
                        }
                    } else {
                        $error = "Podano złe hasło lub hasła są różne!";
                        include('information.php');
                    }

                } else {
                    $error = "Niepoprawne Dane!";
                    include('information.php');
                }
            }
        } else {
            $error = "Proszę uzupełnić wszystkie pola.";
            include('information.php');
        }
    }

    static function avatarUpdate($conn, $path)
    {
        if (isset($path)) {
            session_start();
            $id = $_SESSION['user'];
            if (User::loadUserById($conn, $id)) {
                $object = User::loadUserById($conn, $id);
                $object->setAvatar($path);
                $object->saveToDB($conn);
            }
        } else {
            $error = "Błąd podczas dodawania Avatara";
            include('information.php');
        }
    }
}