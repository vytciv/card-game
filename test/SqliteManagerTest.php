<?php

require_once 'BaseDatabaseTest.php';

class SqliteManagerTest extends BaseDatabaseTest
{

    /**
     * @var SqliteManager
     */
    private $sqliteManager;

    public function setUp()
    {
        parent::setUp();

        $this->sqliteManager = new SqliteManager(self::$systemPdo);
    }

    /**
     * @group db
     */
    public function testUpdateGame()
    {
        $this->sqliteManager->updateGame(1, 'Player2');

        $expectedDataSet = $this->createXMLDataSet(__DIR__ . '/expected/SqliteManagerTestUpdateGame.xml');
        $actualTable = $this->getConnection()->createQueryTable("game", "SELECT * FROM game");
        $this->assertTablesEqual($expectedDataSet->getTable('game'), $actualTable);
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return $this->createXMLDataSet(__DIR__ . '/fixtures/SqliteManagerTest.xml');
    }
}