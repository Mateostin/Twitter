<?php

class Comment
{

    private $comment_id;
    private $user_id;
    private $tweet_id;
    private $text;
    private $creationDate;

    public function __construct()
    {
        $this->comment_id = -1;
        $this->user_id = '';
        $this->tweet_id = '';
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

    public function getCommentId()
    {
        return $this->comment_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getTweetId()
    {
        return $this->tweet_id;
    }

    public function setTweetId($tweet_id)
    {
        $this->tweet_id = $tweet_id;
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
        if ($this->comment_id == -1) {

            $sql = 'INSERT INTO Comments(user_id, tweet_id, text) VALUES(:user_id, :tweet_id, :text)';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'user_id' => $this->user_id,
                'tweet_id' => $this->tweet_id,
                'text' => $this->text,
            ]);
            if ($result !== false) {
                $this->comment_id = $conn->lastInsertId();
                return true;
            }
        } else {
            return "ERROR";
        }
        return false;
    }

    static public function loadCommentsById(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM Comments WHERE comment_id=:id');
        $result = $stmt->execute(['id' => $id]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedComment = new Comment();
            $loadedComment->comment_id = $row['comment_id'];
            $loadedComment->user_id = $row['user_id'];
            $loadedComment->tweet_id = $row['tweet_id'];
            $loadedComment->text = $row['text'];
            $loadedComment->creationDate = $row['creationDate'];
            return $loadedComment;
        }
        return null;
    }

    static public function loadCommentsByTweetId(PDO $conn, $id)
    {
        $ret = [];
        $sql = "SELECT * FROM Comments WHERE tweet_id=$id ORDER BY creationDate ASC";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedComment = new Comment();
                $loadedComment->comment_id = $row['comment_id'];
                $loadedComment->user_id = $row['user_id'];
                $loadedComment->tweet_id = $row['tweet_id'];
                $loadedComment->text = $row['text'];
                $loadedComment->creationDate = $row['creationDate'];
                $ret[] = $loadedComment;
            }
        }
        return $ret;
    }

    static public function loadCommentsByUserId(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM Comments WHERE user_id=:id');
        $result = $stmt->execute(['id' => $id]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedComment = new Comment();
            $loadedComment->comment_id = $row['comment_id'];
            $loadedComment->user_id = $row['user_id'];
            $loadedComment->tweet_id = $row['tweet_id'];
            $loadedComment->text = $row['text'];
            $loadedComment->creationDate = $row['creationDate'];
            return $loadedComment;
        }
        return null;
    }

    static public function loadAllComments(PDO $conn)
    {
        $ret = [];
        $sql = "SELECT * FROM Comments ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedComment = new Comment();
                $loadedComment->comment_id = $row['comment_id'];
                $loadedComment->user_id = $row['user_id'];
                $loadedComment->tweet_id = $row['tweet_id'];
                $loadedComment->text = $row['text'];
                $loadedComment->creationDate = $row['creationDate'];
                $ret[] = $loadedComment;
            }
        }
        return $ret;
    }

    public function delete(PDO $conn)
    {
        if ($this->id != -1) {
            $stmt = $conn->prepare('DELETE FROM Comments WHERE id=:id');
            $result = $stmt->execute(['id' => $this->comment_id]);
            if ($result === true) {
                return true;
            }
            return false;
        }
        return true;
    }

    static public function countComments(PDO $conn, $tweet_id)
    {
        $stmt = $conn->prepare('SELECT COUNT(tweet_id) AS NumberOfComments FROM Comments WHERE tweet_id=:id');
        $result = $stmt->execute(['id' => $tweet_id]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $numberOfComments = $row['NumberOfComments'];
        }
    }

}