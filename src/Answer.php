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
    
}
