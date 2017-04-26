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

class Answer {
    private $answerId;
    private $answerText;
    private $answerQuestionId;
    
}
