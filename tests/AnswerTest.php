<?php

require_once __DIR__ . '/../vendor/autoload.php';

class AnswerTest extends PHPUnit_Extensions_Database_TestCase {

    protected static $myConn;
    protected static $emptyAnswer;

    public function getConnection() {
        $conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
        $conn->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {
        return $this->createFlatXmlDataSet(__DIR__ . '/../datasets/answer.xml');
    }

    public static function setUpBeforeClass() {
        self::$myConn = new mysqli(
                $GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']
        );
        self::$emptyAnswer = new Answer();
    }
    
    // testy wlasciwe
    
    public function testConstruct() {
        $this->assertInstanceOf('Answer', self::$emptyAnswer);
    }
    
    public function testSetAndGetAnswerText() {
        self::$emptyAnswer->setAnswerText("nowyT");
        $this->assertSame("nowyT", self::$emptyAnswer->getAnswerText());
    }
    
    public function testSaveToDbIfDataIsIncorrect() {
        $this->assertNull(self::$emptyAnswer->saveToDB());
    }
    
    public function testCreateAnswer() {
        $answer = Answer::createAnswer(1, "textx");
        $this->assertInstanceOf('Answer', $answer);
    }
    
    public function testCreateAnswerIfDataIsIncorrect() {
        $this->assertFalse(Answer::createAnswer("14", "textx"));
        $this->assertFalse(Answer::createAnswer(2, ""));
        $this->assertFalse(Answer::createAnswer("2", ""));
    }
    
    public function testSaveToDbIfDataIsCorrect() {
        $answer = Answer::createAnswer(1, "textx");
        $this->assertTrue($answer->saveToDB());
    }
    
    public function testLoadAnswerById() {
        $answer1 = Answer::loadAnswerById(1);
        $answer2 = Answer::loadAnswerById(222);
        $this->assertInstanceOf('Answer', $answer1);
        $this->assertFalse($answer2);
    }

}
