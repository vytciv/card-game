<?php
/**
 * A base class for player types
 */
abstract class Player
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var CardCollection
     */
    private $hand;

    /**
     * @param $name
     * @param CardCollection $hand
     */
    public function __construct($name, CardCollection $hand)
    {
        $this->name = $name;
        $this->hand = $hand;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Draws a card from the $deck into the player's hand
     *
     * @param CardCollection $deck
     */
    public function drawCard(CardCollection $deck)
    {
        $deck->moveTopCardTo($this->hand);
    }

    /**
     * @return CardCollection
     */
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * Checks for matches in the hand.
     *
     * Delegates to the game to notify of matches.
     *
     * @param GoFish $game
     */
    public function checkForMatches(GoFish $game)
    {
        $cardCollections = array();

        /* @var $card Card */
        foreach ($this->hand as $card) {
            $cardCollections[$card->getNumber()][] = $card;
        }

        foreach ($cardCollections as $cards) {
            while (count($cards) > 2) {
                $game->registerMatch($this, array_pop($cards), array_pop($cards));
            }
        }
    }

    /**
     * @param $cardNumber
     * @return bool
     */
    public function hasCard($cardNumber)
    {
        return $this->getCard($cardNumber) !== null;
    }

    /**
     * @param $cardNumber
     * @return Card|null
     */
    public function getCard($cardNumber)
    {
        $match = null;
        /* @var $card Card */
        foreach ($this->hand as $card) {
            if ($card->getNumber() == $cardNumber) {
                $match = $card;
            }
        }

        return $match;
    }

    /**
     * @return mixed
     * @throws RuntimeException
     */
    public function requestCard()
    {
        $cardNumber = $this->chooseCardNumber();

        if (!$this->hasCard($cardNumber)) {
            throw new RuntimeException('Invalid card chosen by player');
        }

        return $cardNumber;
    }

    /**
     * @return mixed
     */
    abstract protected function chooseCardNumber();

    /**
     * @param Player $player
     * @param $cardNumber
     * @return bool
     */
    public function takeCards(Player $player, $cardNumber)
    {
        $card = $player->getCard($cardNumber);

        if ($card !== null) {
            $this->getHand()->addCard($card);
            $player->getHand()->removeCard($card);
            return true;
        }
        return false;
    }
}
