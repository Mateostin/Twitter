<?php

class Tweet
{

    private $id;
    private $user_id;
    private $text;
    private $creationDate;

    public function __construct()
    {
        $this->id = -1;
        $this->user_id = '';
        $this->text = '';
        $this->creationDate = '';
    }

    public function setUserId($userID)
    {
        $this->user_id = $userID;
    }

    public function settext($text)
    {
        $this->text = $text;
    }

    public function gettext()
    {
        return $this->text;
    }

    public function setcreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    static public function loadUserById(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM Users WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $name = $row['firstname'];
            $secondname = $row['secondname'];

            $username = $name . " $secondname";

            return $username;
        }
        return null;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function saveToDB(PDO $conn)
    {
        if ($this->id == -1) {

            $sql = 'INSERT INTO Tweet(user_id, text) VALUES(:user_id, :text)';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'user_id' => $this->user_id,
                'text' => $this->text,
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            return "ERROR";
        }
        return false;
    }

    static public function loadTweetById(PDO $conn, $id)
    {
        $ret = [];
        $sql = "SELECT * FROM Tweet WHERE user_id=$id ORDER BY creationDate DESC";
        $stmt = $conn->prepare('SELECT * FROM Tweet WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);
        $result = $result->fetchAll();
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->user_id = $row['user_id'];
                $loadedTweet->creationDate = $row['creationDate'];
                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }


    static public function loadTweetByUserId(PDO $conn, $id)
    {
        $ret = [];
        $sql = "SELECT * FROM Tweet WHERE user_id=$id ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->user_id = $row['user_id'];
                $loadedTweet->creationDate = $row['creationDate'];
                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }


    static public function loadAllTweet(PDO $conn)
    {
        $ret = [];
        $sql = "SELECT * FROM Tweet ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->user_id = $row['user_id'];
                $loadedTweet->creationDate = $row['creationDate'];
                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }

    public function delete(PDO $conn)
    {
        if ($this->id != -1) {
            $stmt = $conn->prepare('DELETE FROM Tweet WHERE id=:id');
            $result = $stmt->execute(['id' => $this->id]);
            if ($result === true) {
                return true;
            }
            return false;
        }
        return true;
    }


    static function makeLinks($str)
    {
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        $urls = array();
        $urlsToReplace = array();
        if (preg_match_all($reg_exUrl, $str, $urls)) {
            $numOfMatches = count($urls[0]);
            $numOfUrlsToReplace = 0;
            for ($i = 0; $i < $numOfMatches; $i++) {
                $alreadyAdded = false;
                $numOfUrlsToReplace = count($urlsToReplace);
                for ($j = 0; $j < $numOfUrlsToReplace; $j++) {
                    if ($urlsToReplace[$j] == $urls[0][$i]) {
                        $alreadyAdded = true;
                    }
                }
                if (!$alreadyAdded) {
                    array_push($urlsToReplace, $urls[0][$i]);
                }
            }
            $numOfUrlsToReplace = count($urlsToReplace);
            for ($i = 0; $i < $numOfUrlsToReplace; $i++) {
                $str = str_replace($urlsToReplace[$i], "<a href=\"" . $urlsToReplace[$i] . "\">" . $urlsToReplace[$i] . "</a> ", $str);
            }
            return $str;
        } else {
            return $str;
        }
    }

    static public function countTweets(PDO $conn, $user_id)
    {
        $stmt = $conn->prepare('SELECT COUNT(user_id) AS NumberOfTweets FROM Tweet WHERE user_id=:user_id');
        $result = $stmt->execute(['user_id' => $user_id]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $numberOfTweets = $row['NumberOfTweets'];
        }
    }

}