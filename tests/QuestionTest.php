<?php

require_once __DIR__ . '/../vendor/autoload.php';

class QuestionTest extends PHPUnit_Extensions_Database_TestCase {

    protected static $myConn;
    protected static $emptyQuestion;

    public function getConnection() {
        $conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
        $conn->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {
        return $this->createFlatXmlDataSet(__DIR__ . '/../datasets/question.xml');
    }

    public static function setUpBeforeClass() {
        self::$myConn = new mysqli(
                $GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']
        );
        self::$emptyQuestion = new Question();
    }
    
    // testy wlasciwe
    
    public function testConstruct() {
        $this->assertInstanceOf('Question', self::$emptyQuestion);
    }
    
    public function testGetQuestionId() {
        $this->assertEquals(-1, self::$emptyQuestion->getQuestionId());
    }
    
    public function testGetQuestionText() {
        $this->assertEquals("", self::$emptyQuestion->getQuestionText());
    }
    
    public function testGetQuestionSurveyId() {
        $this->assertEquals("", self::$emptyQuestion->getQuestionSurveyId());
    }
    
    public function testGetAnswersByQuestionIfIdIsIncorrect() {
        $this->assertFalse(self::$emptyQuestion->getAnswersByQuestion());
    }
    
    public function testLoadQuestionById() {
        $question = Question::loadQuestionById(1);
        $this->assertInstanceOf('Question', $question);
    }
    
    public function testGetAnswersByQuestionIfIdIsCorrect() {
        $question = Question::loadQuestionById(1);
        $answers = $question->getAnswersByQuestion();
        $this->assertInstanceOf('Answer', $answers[0]);
        $this->assertInternalType('array', $answers);
    }
    
    public function testSetQuestionText() {
        self::$emptyQuestion->setQuestionText("newText");
        $this->assertSame("newText", self::$emptyQuestion->getQuestionText());
    }
    
    public function testSaveToDbIfDataIsEmpty() {
        $this->assertNull(self::$emptyQuestion->saveToDB());
    }
    
    public function testSaveToDbIfDataIsCorrect() {
        $question = Question::createQuestion(2, "newtextxxx");
        $this->assertTrue($question->saveToDB());
    }
    
    public function testSaveToDbIfQuestionIsEdit() {
        $question = Question::loadQuestionById(1);
        $question->setQuestionText("tosave");
        $this->assertTrue($question->saveToDB());
    }
    
    public function testCreateQuestionIfdataIsIncorrect() {
        $this->assertFalse(Question::createQuestion("2", "newtextxxx"));
        $this->assertFalse(Question::createQuestion(2, ""));
    }
    
    public function testLoadQuestionByIdIfIdIsIncorrect() {
        $this->assertFalse(Question::loadQuestionById(13));
    }
    
    public function testDeleteQuestion() {
        $this->assertTrue(Question::deleteQuestionById(3));
    }
    
    
    
    
    
    
    

}