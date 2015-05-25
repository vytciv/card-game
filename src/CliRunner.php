<?php

/**
 * A cli based runner for the game
 */
class CliRunner
{
    /**
     * @var GoFish
     */
    private $game;

    public function __construct()
    {
        $deck = CardFactory::StandardDeck();
        $deck->shuffle();
        $this->game = new GoFish(new CliFormatter(), $deck, new HumanPlayer('Player1', new CardCollection()), new HumanPlayer('Player2', new CardCollection()));
    }

    /**
     * Runs the game
     */
    public function play()
    {
        echo "Welcome to Go Fish!\n";
        echo "Hands On Testing with PHPUnit\n\n";

        echo "\n";
        echo "Time to begin!\n\n";

        $this->game->deal();

        while (!$this->game->isOver()) {
            $this->game->startTurn();
            $this->game->takeTurn();
        }

        $this->game->finish();
    }
}
