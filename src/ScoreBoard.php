<?php
/**
 * Represents a full score board for a game
 */
class ScoreBoard
{
    /**
     * @var array
     */
    private $scores;

    public function __construct()
    {
        $this->scores = array();
    }

    /**
     * @param $player
     */
    public function addPlayer($player)
    {
        $this->scores[] = new Score($player);
    }

    /**
     * @param $player
     */
    public function givePoint($player)
    {
        /* @var $score Score */
        foreach ($this->scores as $score) {
            if ($score->getPlayer() === $player) {
                $score->increment();
            }
        }
    }

    /**
     * executes a callable for each score on the board.
     *
     * @param callable $func
     */
    public function forEachScore(Closure $func)
    {
        usort($this->scores, function ($score1, $score2) {
            Score::cmp($score1, $score2);
        });

        array_walk($this->scores, function (Score $score) use ($func) {
            $func($score->getPlayer(), $score->getScore());
        });
    }
}
