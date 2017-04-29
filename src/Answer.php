<?php
/* Odpowiedź:

    1.Ma mieć tekst odpowiedzi.
    2.Ma implementować metody:
        zmieniające tekst odpowiedzi,
        zwracające tekst odpowiedzi,
        zapamiętujące odpowiedź do bazy danych.
    3.Ma implementować statyczne metody:
        stworzenie nowej odpowiedzi (potrzebuje podania id pytania),
        wczytanie odpowiedzi o podanym id z bazy danych,
        usunięcie odpowiedzi o podanym id z bazy danych.  */

require_once 'connectToDB.php';

class Answer {
    static private $conn;

    private $answerId;
    private $answerText;
    private $answerQuestionId;
    
    public static function setConnection($newConn){
        self::$conn = $newConn;
    }
    
    public function __construct() {
        $this->answerId = -1;
        $this->answerText = "";
        $this->answerQuestionId = "";
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
