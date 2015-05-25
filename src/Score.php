<?php

/**
 * Represents the score for a player
 */
class Score
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var int
     */
    private $score;

    /**
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->score = 0;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Compares two scores. Returns > 0 if score 1 is greater. < 0 if score 2 is greater. 0 if they are equal.
     * @param Score $score1
     * @param Score $score2
     * @return int
     */
    public static function cmp(Score $score1, Score $score2)
    {
        return $score2->score - $score1->score;
    }

    /**
     * Increment's the score.
     */
    public function increment()
    {
        $this->score++;
    }
}
