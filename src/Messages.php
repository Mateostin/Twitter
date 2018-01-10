<?php

class Messages
{

    private $message_id;
    private $sender_id;
    private $receiver_id;
    private $text;
    private $status;
    private $creationDate;

    public function __construct()
    {
        $this->message_id = -1;
        $this->sender_id = '';
        $this->receiver_id = '';
        $this->text = '';
        $this->status = 0;
        $this->creationDate = '';
    }

    public function setSender_id($sender_id)
    {
        $this->sender_id = $sender_id;
    }

    public function setReceiver_id($receiver_id)
    {
        $this->receiver_id = $receiver_id;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getMessageId()
    {
        return $this->message_id;
    }

    public function getSenderId()
    {
        return $this->sender_id;
    }

    public function getReceiverId()
    {
        return $this->receiver_id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
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

    public function saveToDB(PDO $conn)
    {
        if ($this->message_id == -1) {

            $sql = 'INSERT INTO Messages(sender_id, receiver_id, text, status) VALUES(:sender_id, :receiver_id, :text, :status)';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'sender_id' => $this->sender_id,
                'receiver_id' => $this->receiver_id,
                'text' => $this->text,
                'status' => $this->status,
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

    static public function loadMessageById(PDO $conn, $id)
    {
        $ret = [];
        $sql = "SELECT * FROM Messages WHERE message_id=:$id ORDER BY creationDate DESC";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['message_id' => $id]);
        $result = $result->fetchAll();
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedMessage = new Messages();
                $loadedMessage->message_id = $row['message_id'];
                $loadedMessage->sender_id = $row['sender_id'];
                $loadedMessage->receiver_id = $row['receiver_id'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->creationDate = $row['creationDate'];
                $ret[] = $loadedMessage;
            }
        }
        return $ret;
    }


    static public function loadMessagesByReceiverUserId(PDO $conn, $id)
    {
        $ret = [];
        $sql = "SELECT * FROM Messages WHERE receiver_id=$id ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedMessage = new Messages();
                $loadedMessage->message_id = $row['message_id'];
                $loadedMessage->sender_id = $row['sender_id'];
                $loadedMessage->receiver_id = $row['receiver_id'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->creationDate = $row['creationDate'];
                $ret[] = $loadedMessage;
            }
        }
        return $ret;
    }

    static public function loadFirstMessagesByReceiverUserId(PDO $conn, $id)
    {
        $ret = [];
        $sql = "SELECT * FROM Messages WHERE receiver_id=$id GROUP BY sender_id DESC ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedMessage = new Messages();
                $loadedMessage->message_id = $row['message_id'];
                $loadedMessage->sender_id = $row['sender_id'];
                $loadedMessage->receiver_id = $row['receiver_id'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->status = $row['status'];
                $loadedMessage->creationDate = $row['creationDate'];
                $ret[] = $loadedMessage;
            }
        }
        return $ret;
    }

    static public function loadMessagesBySenderUserId(PDO $conn, $sender_id, $receiver_id)
    {
        $ret = [];
        $sql = "(SELECT * FROM Messages WHERE sender_id=$receiver_id AND receiver_id=$sender_id) union (SELECT * FROM Messages WHERE sender_id=$sender_id AND receiver_id=$receiver_id) ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedMessage = new Messages();
                $loadedMessage->message_id = $row['message_id'];
                $loadedMessage->sender_id = $row['sender_id'];
                $loadedMessage->receiver_id = $row['receiver_id'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->status = $row['status'];
                $loadedMessage->creationDate = $row['creationDate'];
                $ret[] = $loadedMessage;
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

    static public function setReaded(PDO $conn, $sender_id, $receiver_id)
    {

        $sql = "UPDATE Messages SET status=1 WHERE sender_id=$sender_id AND receiver_id=$receiver_id";
        $conn->query($sql);
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

    static public function countMessages(PDO $conn, $user_id)
    {
        $stmt = $conn->prepare('SELECT COUNT(receiver_id) AS NumberOfMessages FROM Messages WHERE receiver_id=:receiver_id AND status=0');
        $result = $stmt->execute(['receiver_id' => $user_id]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $numberOfMessages = $row['NumberOfMessages'];
        }
    }

}