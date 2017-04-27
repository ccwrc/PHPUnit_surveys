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
    usunięcie pytania o podanym id z bazy danych.   */

require_once 'connectToDB.php';

class Question {
    static private $conn;
    
    private $questionText;
    private $questionId;
    private $questionSurveyId;
    
    public static function setConnection($newConn){
        self::$conn = $newConn;
    }
    
}

