<?php
require_once dirname( __FILE__ ) . '/../vendor/autoload.php';
abstract class BaseDatabaseTest extends PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var PDO
     */
    protected static $testPdo;

    /**
     * @var PDO
     */
    protected static $systemPdo;

    public static function setUpBeforeClass()
    {
//        self::$testPdo = new PDO(DB_DSN);
//        self::$testPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        self::$systemPdo = new PDO(DB_DSN);
//        self::$systemPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function tearDownAfterClass()
    {
        //self::$testPdo = null;
        //self::$systemPdo = null;
    }

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        //return $this->createDefaultDBConnection(self::$testPdo);
    }

    public function testKazkas()
    {
        $this->markTestIncomplete('dasdas');
    }

}