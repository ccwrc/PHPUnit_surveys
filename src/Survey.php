<?php

/* Ankieta:
  1.Ma mieć własną nazwę, unikatowy link.
  2.Ma implementować następujące metody:

  zwracającą listę pytań dla danej ankiety,
  zwracanie nazwy,
  zmiana nazwy,
  zapisanie zmian do bazy danych.

  3.Ma implementować następujące statyczne metody:

  stworzenie nowej ankiety,
  wczytanie ankiety o podanym id z bazy danych,
  usunięcie ankiety o podanym id z bazy danych. */

require_once 'connectToDB.php';

class Survey {
    static private $conn;
    
    private $surveyName;
    private $surveyLink;
    private $surveyId;

    public static function setConnection($newConn) {
        self::$conn = $newConn;
    }

    public function __construct() {
        $this->surveyId = -1;
        $this->surveyLink = "";
        $this->surveyName = "";
    }

    public function getQuestionsForSurvey() {
        $sql = "SELECT * FROM question LEFT JOIN survey ON survey_id=question_survey_id "
                . "WHERE survey_id=$this->surveyId";
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

    public function getSurveyName() {
        return $this->surveyName;
    }
    
    public function getSurveyId() {
        return $this->surveyId;
    }

    public function changeSurveyName($newName) {
        $this->surveyName = $newName;
    }

    public function saveToDB() {
        if ($this->surveyId == -1) {
            $sql = "INSERT INTO survey (survey_link, survey_name) VALUES "
                    . "($this->surveyLink, $this->surveyName)";
            $result = self::$conn->query($sql);
            if ($result) {
                $this->surveyId = self::$conn->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE survey SET survey_link=$this->surveyLink, survey_name=$this->surveyName "
                    . "WHERE survey_id=$this->surveyId";
            $result = self::$conn->query($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function createSurvey($surveyLink, $surveyName) {
        $sql = "INSERT INTO survey (survey_link, survey_name) VALUES "
                . "($surveyLink, $surveyName)";
        $result = self::$conn->query($sql);
        if ($result) {
            $survey = new Survey();
            $survey->surveyId = self::$conn->insert_id;
            $survey->surveyLink = $surveyLink;
            $survey->surveyName = $surveyName;
            return $survey;
        } else {
            return false;
        }
    }

    public static function loadSurveyById($surveyId) {
        $sql = "SELECT * FROM survey WHERE survey_id=$surveyId";
        $result = self::$conn->query($sql);
        if ($result->num_rows == 1) {
            $ret = [];
            foreach ($result as $row) {
                $loadedSurvey = new Survey();
                $loadedSurvey->surveyId = $row['survey_id'];
                $loadedSurvey->surveyLink = $row['survey_link'];
                $loadedSurvey->surveyName = $row['survey_name'];
                $ret[] = $loadedSurvey;
            }
            return $ret;
        } else {
            return false;
        }
    }

    public static function deleteSurveyById($surveyId) {
        $sql = "DELETE FROM survey WHERE survey_id=$surveyId";
        $result = self::$conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}
