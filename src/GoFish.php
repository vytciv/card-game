<?php

/**
 * Contains the logic necessary to run a go fish game.
 */
class GoFish
{
    /**
     * @var CliFormatter
     */
    private $formatter;

    /**
     * @var CardCollection
     */
    private $deck;

    /**
     * @var ScoreBoard
     */
    private $score;

    private $currentPlayer;

    private $players;

    /**
     * @param CliFormatter $formatter
     * @param CardCollection $deck
     * @param Player $player1
     * @param Player $player2
     */
    public function __construct(CliFormatter $formatter, CardCollection $deck, Player $player1, Player $player2)
    {
        $this->formatter = $formatter;
        $this->deck = $deck;
        $this->players = array($player1, $player2);
        $this->currentPlayer = 0;
        $this->score = new ScoreBoard();
        $this->score->addPlayer($player1);
        $this->score->addPlayer($player2);
    }

    /**
     * Returns a list of players
     *
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Deals cards to players
     */
    public function deal()
    {
        $cardsToDeal = 7;
        $deck = $this->deck;

        while ($cardsToDeal--) {
            array_walk($this->players, function (Player $player) use ($deck) {
                $player->drawCard($deck);
            });
        }

        /* @var $player Player */
        foreach ($this->players as $player) {
            $this->scoreMatches($player, $player->getHand());
        }

        $this->showScore();
        $this->formatter->announceNewTurn($this->getCurrentPlayer());
    }

    /**
     * The player who currently has the turn
     *
     * @return Player
     */
    public function getCurrentPlayer()
    {
        return $this->players[$this->currentPlayer];
    }

    /**
     * The player who doesn't have a turn
     *
     * @return Player
     */
    private function getOtherPlayer()
    {
        return $this->players[($this->currentPlayer + 1) % 2];
    }

    /**
     * Returns true when the game is over
     *
     * @return bool
     */
    public function isOver()
    {
        return $this->deck->count() == 0 && $this->players[0]->getHand()->count() == 0 && $this->players[1]->getHand()->count() == 0;
    }

    /**
     * Prints the score
     */
    private function showScore()
    {
        $score = $this->score;
        $this->formatter->announceScore(function (Closure $printer) use ($score) {
            $score->forEachScore($printer);
        });
    }

    /**
     * Starts the current player's turn
     */
    public function startTurn()
    {
        $player = $this->getCurrentPlayer();

        if ($player->getHand()->count() == 0) {
            $cardsToDeal = 7;
            while ($cardsToDeal--) {
                $this->deck->moveTopCardTo($player->getHand());
            }

            $this->formatter->announceEmptyHand($player);
        }
    }

    /**
     * @param Player $player
     * @param CardCollection $hand
     * @return int
     */
    private function scoreMatches(Player $player, CardCollection $hand)
    {
        $matches = 0;
        $cardCollections = array();

        /* @var $card Card */
        foreach ($hand as $card) {
            $cardCollections[$card->getNumber()][] = $card;
        }

        foreach ($cardCollections as $cards) {
            while (count($cards) >= 2) {
                $matches++;
                $card1 = array_pop($cards);
                $card2 = array_pop($cards);

                $hand->removeCard($card1);
                $hand->removeCard($card2);
                $this->score->givePoint($player);
                $this->formatter->announceMatch($player, $card1, $card2);
            }
        }

        return $matches;
    }

    /**
     * Executes a player's turn
     *
     */
    public function takeTurn()
    {
        $cardNumber = $this->getCurrentPlayer()->requestCard();

        if ($this->getCurrentPlayer()->takeCards($this->getOtherPlayer(), $cardNumber)) {
            $this->scoreMatches($this->getCurrentPlayer(), $this->getCurrentPlayer()->getHand());
            $this->formatter->announceReplay($this->getCurrentPlayer());
        } else {
            $this->formatter->announceGoFish($this->getCurrentPlayer());
            $this->deck->moveTopCardTo($this->getCurrentPlayer()->getHand());
            if ($this->scoreMatches($this->getCurrentPlayer(), $this->getCurrentPlayer()->getHand())) {
                $this->formatter->announceMatchDrawn($this->getCurrentPlayer());
                $this->formatter->announceReplay($this->getCurrentPlayer());
            } else {
                $this->formatter->announceTurnOver($this->getCurrentPlayer());
                $this->showScore();
                $this->currentPlayer += 1;
                $this->currentPlayer %= 2;
                $this->formatter->announceNewTurn($this->getCurrentPlayer());
            }
        }
    }

    /**
     * Wraps up the game
     */
    public function finish()
    {
        $this->showScore();
    }
}