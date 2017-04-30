<?php

require_once __DIR__ . '/../vendor/autoload.php';

class SurveyTest extends PHPUnit_Extensions_Database_TestCase {
    protected static $myConn;

    public function getConnection() {
        $conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
        $conn->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {
        return $this->createFlatXmlDataSet(__DIR__ . '/../datasets/survey.xml');
    }

    public static function setUpBeforeClass() {
        self::$myConn = new mysqli(
                $GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']
        );
    }

    // testy wlasciwe

    public function testIsNewSurveyIsObject() {
        $survey = new Survey();
        $this->assertInstanceOf('Survey', $survey);
    }

    public function testGetQuestionsForSurveyIsArray() {
        $survey = Survey::loadSurveyById(1);
        $this->assertInternalType('array', $survey->getQuestionsForSurvey());
    }

    public function testGetQuestionsForSurveyIfNoQuestions() {
        $survey = new Survey();
        $this->assertFalse($survey->getQuestionsForSurvey());
    }

    public function testGetQuestionsForSurveyIsCellAobject() {
        $survey = Survey::loadSurveyById(1);
        $objects = $survey->getQuestionsForSurvey();
        $this->assertInstanceOf('Question', $objects[0]);
    }

    public function testGetSurveyName() {
        $survey = Survey::loadSurveyById(1);
        $this->assertSame("survey1", $survey->getSurveyName());
    }

    public function testGetSurveyId() {
        $survey = Survey::loadSurveyById(1);
        $this->assertSame("1", $survey->getSurveyId());
    }

    public function testChangeSurveyName() {
        $survey = Survey::loadSurveyById(1);
        $survey->changeSurveyName("newname");
        $this->assertSame("newname", $survey->getSurveyName());
    }

    public function testSaveToDB() {
        $survey = new Survey();
        $this->assertTrue($survey->saveToDB());
    }

    public function testSaveToDbIfSurveyIsEdit() {
        $survey = Survey::loadSurveyById(1);
        $survey->changeSurveyName("new name 1");
        $this->assertTrue($survey->saveToDB());
    }

    public function testCreateSurvey() {
        $this->assertInstanceOf('Survey', Survey::createSurvey("justlink", "justname"));
    }

    public function testLoadSurveyById() {
        $survey = Survey::loadSurveyById(3);
        $this->assertEquals(3, $survey->getSurveyId());
    }

    public function testDeleteSurveyById() {
        $this->assertTrue(Survey::deleteSurveyById(222));
    }

}
