<?php

require_once 'connectToDB.php';

class Answer {
    static private $conn;
    
    private $answerId;
    private $answerText;
    private $answerQuestionId;

    public static function setConnection($newConn) {
        self::$conn = $newConn;
    }

    public function __construct() {
        $this->answerId = -1;
        $this->answerText = "";
        $this->answerQuestionId = "";
    }

    public function setAnswerText($newText) {
        $this->answerText = $newText;
    }

    public function getAnswerText() {
        return $this->answerText;
    }

    public function saveToDB() {
        if ($this->answerId == -1) {
            $sql = "INSERT INTO answer (answer_text, answer_question_id) VALUES "
                    . "('$this->answerText', $this->answerQuestionId)";
            $result = self::$conn->query($sql);
            if ($result) {
                $this->answerId = self::$conn->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE answer SET answer_text='$this->answerText', "
                    . "answer_question_id=$this->answerQuestionId WHERE "
                    . "answer_id=$this->answerId";
            $result = self::$conn->query($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function createAnswer($questionId, $answerText) {
        if (is_int($questionId) && $answerText != "") {
            $answer = new Answer();
            $answer->answerQuestionId = $questionId;
            $answer->answerText = $answerText;
            return $answer;
        } else {
            return false;
        }
    }

    public static function loadAnswerById($answerId) {
        $sql = "SELECT * FROM answer WHERE answer_id=$answerId";
        $result = self::$conn->query($sql);
        if ($result->num_rows == 1) {
            foreach ($result as $row) {
                $loadedAnswer = new Answer();
                $loadedAnswer->answerId = $row['answer_id'];
                $loadedAnswer->answerText = $row['answer_text'];
                $loadedAnswer->answerQuestionId = $row['answer_question_id'];
            }
            return $loadedAnswer;
        } else {
            return false;
        }
    }

    public static function deleteAnswerById($answerId) {
        $sql = "DELETE FROM answer WHERE answer_id=$answerId";
        $result = self::$conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAnswersByQuestionId($questionId) {
        $sql = "SELECT * FROM answer LEFT JOIN question ON question_id=answer_question_id "
                . "WHERE answer_id=$questionId";
        $result = self::$conn->query($sql);
        if ($result->num_rows > 0) {
            $ret = [];
            foreach ($result as $row) {
                $loadedAnswer = new Answer();
                $loadedAnswer->answerId = $row['answer_id'];
                $loadedAnswer->answerText = $row['answer_text'];
                $loadedAnswer->answerQuestionId = $row['answer_question_id'];
                $ret[] = $loadedAnswer;
            }
            return $ret;
        } else {
            return false;
        }
    }

}
