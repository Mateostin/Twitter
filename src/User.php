<?php

class User
{

    private $id;
    private $firstname;
    private $secondname;
    private $hashPass;
    private $email;
    private $avatar;

    public function __construct()
    {
        $this->id = -1;
        $this->firstname = '';
        $this->secondname = '';
        $this->email = '';
        $this->hashPass = '';
        $this->avatar = 'user_avatars/customavatar.png';
    }

    public function setFirstname($newFirstname)
    {
        $newFirstname = ucfirst($newFirstname);
        $this->firstname = $newFirstname;
    }

    public function setSecondname($newSecondname)
    {
        $newSecondname = ucfirst($newSecondname);
        $this->secondname = $newSecondname;
    }

    public function setEmail($newEmail)
    {
        $this->email = $newEmail;
    }

    public function setPassword($newPassword)
    {
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->hashPass = $newHashedPassword;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getSecondname()
    {
        return $this->secondname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->hashPass;
    }

    public function saveToDB(PDO $conn)
    {
        if ($this->id == -1) {
            $sql = 'INSERT INTO Users(firstname, secondname, email, hash_pass, avatar) VALUES(:firstname, :secondname, :email, :pass, :avatar)';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute(['firstname' => $this->firstname, 'secondname' => $this->secondname, 'email' => $this->email, 'pass' => $this->hashPass, 'avatar' => $this->avatar]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            $stmt = $conn->prepare('UPDATE Users SET email=:email, firstname=:firstname, secondname=:secondname, hash_pass=:hash_pass, avatar=:avatar WHERE  id=:id ');
            $result = $stmt->execute(['email' => $this->email, 'firstname' => $this->firstname, 'secondname' => $this->secondname, 'hash_pass' => $this->hashPass, 'id' => $this->id, 'avatar' => $this->avatar]);
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    static public function loadUserById(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM Users WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->firstname = $row['firstname'];
            $loadedUser->secondname = $row['secondname'];
            $loadedUser->hashPass = $row['hash_pass'];
            $loadedUser->email = $row['email'];
            $loadedUser->avatar = $row['avatar'];
            return $loadedUser;
        }
        return null;
    }

    static public function loadUserByEmail(PDO $conn, $email)
    {
        $stmt = $conn->prepare('SELECT * FROM Users WHERE email=:email');
        $result = $stmt->execute(['email' => $email]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->firstname = $row['firstname'];
            $loadedUser->secondname = $row['secondname'];
            $loadedUser->hashPass = $row['hash_pass'];
            $loadedUser->email = $row['email'];
            $loadedUser->avatar = $row['avatar'];
            return $loadedUser;
        }
        return null;
    }

    static public function loadAllUsers(PDO $conn)
    {
        $ret = [];
        $sql = "SELECT * FROM Users";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->firstname = $row['firstname'];
                $loadedUser->secondname = $row['secondname'];
                $loadedUser->hashPass = $row['hash_pass'];
                $loadedUser->email = $row['email'];
                $loadedUser->avatar = $row['avatar'];
                $ret[] = $loadedUser;
            }
        }
        return $ret;
    }

    public function delete(PDO $conn)
    {
        if ($this->id != -1) {
            $stmt = $conn->prepare('DELETE FROM Users WHERE id=:id');
            $result = $stmt->execute(['id' => $this->id]);
            if ($result === true) {
                return true;
            }
            return false;
        }
        return true;
    }

    static public function login(PDO $conn, $email, $passFromUser)
    {
        $user = User::loadUserByEmail($conn, $email);

        if ($user !== null && password_verify($passFromUser, $user->getPassword()) == $passFromUser) {
            return $user;
        } else {
            return false;
        }
    }

    static public function passVerification(PDO $conn, $id, $passFromUser)
    {
        $user = User::loadUserById($conn, $id);

        if ($user !== null && password_verify($passFromUser, $user->getPassword()) == $passFromUser) {
            return $user;
        } else {
            return false;
        }
    }

}