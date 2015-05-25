<?php
/**
 * Handles DB communication
 */
class SqliteManager
{
    /**
     * @var PDO
     */
    private $sqliteConnection;

    /**
     * @param PDO $sqliteConnection
     */
    public function __construct(PDO $sqliteConnection)
    {
        $this->sqliteConnection = $sqliteConnection;
    }

    /**
     * @param $gameId
     * @param $currentPlayerName
     */
    public function updateGame($gameId, $currentPlayerName)
    {
        $gameUpdateQuery = "
      UPDATE game
      SET current_player_id = (
        SELECT id
        FROM player
        WHERE
          game_id = ?
          AND name = ?
        )
      WHERE id = ?
     ";

        $stm = $this->sqliteConnection->prepare($gameUpdateQuery);
        $stm->execute(array($gameId, $currentPlayerName, $gameId));
    }

    /**
     * @param $gameId
     * @param $playerName
     * @param $hand
     */
    public function updatePlayer($gameId, $playerName, $hand)
    {
        $playerUpdateQuery = "
      UPDATE player
      SET hand = ?
      WHERE
        game_id = ?
        AND name = ?

    ";

        $stm = $this->sqliteConnection->prepare($playerUpdateQuery);
        $stm->execute(array($hand, $gameId, $playerName));
    }

    /**
     * @param $date
     * @return string
     */
    public function createNewGame($date)
    {
        $gameInsertQuery = "
      INSERT INTO game (date_created) VALUES (?)
    ";

        $stm = $this->sqliteConnection->prepare($gameInsertQuery);
        $stm->execute(array($date));

        return $this->sqliteConnection->lastInsertId();
    }

    /**
     * @param $gameId
     * @param $name
     * @param $hand
     * @return string
     */
    public function createNewPlayer($gameId, $name, $hand)
    {
        $playerInsertQuery = "
      INSERT INTO player (game_id, name, hand) VALUES (?, ?, ?)
    ";

        $stm = $this->sqliteConnection->prepare($playerInsertQuery);
        $stm->execute(array($gameId, $name, $hand));

        return $this->sqliteConnection->lastInsertId();
    }

    /**
     * @param $gameId
     * @return array
     */
    public function getGame($gameId)
    {
        $gameQuery = "SELECT * FROM game WHERE id = ?";

        $stm = $this->sqliteConnection->prepare($gameQuery);
        $stm->execute(array($gameId));

        return $stm->fetchAll();
    }

    /**
     * @param $gameId
     * @return array
     */
    public function getPlayers($gameId)
    {
        $playersQuery = "SELECT * FROM player WHERE game_id = ?";

        $stm = $this->sqliteConnection->prepare($playersQuery);
        $stm->execute(array($gameId));

        return $stm->fetchAll();
    }
}