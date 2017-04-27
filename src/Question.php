<?php

/* Pytanie:
  1. Ma mieć tekst pytania.
  2. Ma implementować metody:

  zwracającą wszystkie udzielone odpowiedzi na to pytanie,
  zmieniające tekst pytania, zwracające tekst pytania,
  zapamiętujące pytanie do bazy danych.

  3. Ma implementować statyczne metody:

  stworzenie nowego pytania (potrzebuje podania id ankiety),
  wczytanie pytania o podanym id z bazy danych,
  usunięcie pytania o podanym id z bazy danych. */

require_once 'connectToDB.php';

class Question {

    static private $conn;
    private $questionText;
    private $questionId;
    private $questionSurveyId;

    public static function setConnection($newConn) {
        self::$conn = $newConn;
    }

    public function getQuestionId() {
        return $this->questionId;
    }

    public function getQuestionText() {
        return $this->questionText;
    }

    public function getQuestionSurveyId() {
        return $this->questionSurveyId;
    }

    public static function getQuestionsForSurvey($id) {
        $sql = "SELECT * FROM question LEFT JOIN survey ON survey_id=question_survey_id "
                . "WHERE survey_id=$id";
        $result = self::$conn->query($sql);
        if ($result->num_rows > 0) {
            $ret = [];
            foreach ($result as $row) {
                $loadedQuestion = new Question();
                $loadedQuestion->questionId = $row['question_id'];
                $loadedQuestion->questionText = $row['question_text'];
                $loadedQuestion->questionSurveyId = $row['question_survey_id'];
                $ret[] = $loadedQuestion;
            }
            return $ret;
        } else {
            return false;
        }
    }

}
