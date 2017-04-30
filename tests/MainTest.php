<?php

require_once __DIR__ . '/../vendor/autoload.php';

class MainTest extends PHPUnit_Extensions_Database_TestCase {

    protected static $myConn;
    protected static $mainSurvey;
    protected static $mainQuestion;
    protected static $mainAnswer;

    public function getConnection() {
        $conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
        $conn->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {
        $dataSetQuestion = $this->createFlatXmlDataSet(__DIR__ . '/../datasets_main/question.xml');
        $dataSetAnswer = $this->createFlatXmlDataSet(__DIR__ . '/../datasets_main/answer.xml');
        $dataSetSurvey = $this->createFlatXmlDataSet(__DIR__ . '/../datasets_main/survey.xml');

        $compositeDataSet = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet();
        $compositeDataSet->addDataSet($dataSetSurvey);
        $compositeDataSet->addDataSet($dataSetQuestion);
        $compositeDataSet->addDataSet($dataSetAnswer);

        return $compositeDataSet;
    }

    public static function setUpBeforeClass() {
        self::$myConn = new mysqli(
                $GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']
        );
        self::$mainAnswer = new Answer();
        self::$mainQuestion = new Question();
        self::$mainSurvey = new Survey();
    }

    // testy wlasciwe

    public function testConstructQuestion() {
        $this->assertInstanceOf('Question', self::$mainQuestion);
    }
    
    public function testConstructSurvey() {
        $this->assertInstanceOf('Survey', self::$mainSurvey);
    }    
    
    public function testConstructAnswer() {
        $this->assertInstanceOf('Answer', self::$mainAnswer);
    }    
    
    public function testSaveAnswerToDb() {
        $answer = Answer::createAnswer(1, "answerText");
        $this->assertTrue($answer->saveToDB());
    }
    
    public function testLoadAnswerById() {
        $this->assertInstanceOf('Answer', Answer::loadAnswerById(2));
    }
    
    public function testGetQuestionsForSurvey() {
        $survey = Survey::loadSurveyById(1);
        $questions = $survey->getQuestionsForSurvey();
        $this->assertInternalType("array", $questions);
    }
    
    public function testDeleteSurveyById() {
        $this->assertTrue(Survey::deleteSurveyById(22));
    }
    
    public function testLoadQuestionByIdIfIdNotExist() {
        $this->assertFalse(Question::loadQuestionById(322));
    }

}
