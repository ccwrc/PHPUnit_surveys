<?php

require_once 'Answer.php';
require_once 'Question.php';
require_once 'Survey.php';

$DB_SERVER = "localhost";
$DB_USERNAME = "survey_user";
$DB_PASSWORD = "Fk2phgqMTdcNgBGw";
$DB_DATABASE = "survey_unit";

$conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);
$conn->query("SET CHARSET UTF8");

if ($conn->connect_error) {
    die("Brak połączenia z bazą danych, błąd: " . $conn->errno . "<br/><br/>");
}

Answer::setConnection($conn);
Question::setConnection($conn);
Survey::setConnection($conn);

