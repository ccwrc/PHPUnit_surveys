<?php

require_once __DIR__ . '/../vendor/autoload.php';

class MainTest extends PHPUnit_Extensions_Database_TestCase {

    protected static $myConn;

    public function getConnection() {
        $conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
        $conn->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {
//        $dataSetQuestion = $this->createFlatXmlDataSet(__DIR__ . '/../datasets/question.xml');
//        $dataSetAnswer = $this->createFlatXmlDataSet(__DIR__ . '/../datasets/answer.xml');
//        $dataSetSurvey = $this->createFlatXmlDataSet(__DIR__ . '/../datasets/survey.xml');
//
//        $compositeDataSet = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet();
//        $compositeDataSet->addDataSet($dataSetQuestion);
//        $compositeDataSet->addDataSet($dataSetAnswer);
//        $compositeDataSet->addDataSet($dataSetSurvey);
//
//        return $compositeDataSet;
    }

    public static function setUpBeforeClass() {
        self::$myConn = new mysqli(
                $GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']
        );
    }

    // testy wlasciwe

//    public function testTrue() {
//        $this->assertTrue(true);
//    }

}
