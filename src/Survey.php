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

class Survey {
    static private $conn;    
    
    private $surveyName;
    private $surveyLink;
    private $surveyId;
    
    public static function setConnection($newConn){
        self::$conn = $newConn;
    }
    
    public function __construct() {
        $this->surveyId = -1;
        $this->surveyLink = "";
        $this->surveyName = "";
    }
    
    public function getQuestionsForSurvey() {
        $sql = "SELECT * FROM survey LEFT JOIN question ON survey_id=question_survey_id "
                . "WHERE survey_id=$this->surveyId";
        $result = self::$conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getSurveyName() {
        return $this->surveyName;
    }
    
    public function changeSurveyName($newName) {
        //
    }
    
    public function saveToDB() {
        //
    }
    
    public static function createSurvey($surveyLink, $surveyName) {
        //
    }
    
    public static function loadSurveyById($surveyId) {
        //
    }
    
    public static function deleteSurveyById($surveyId) {
        //
    }
    
}


