<?php

class CliFormatterTest extends PHPUnit_Framework_TestCase
{
    private $formatter;

    public function setUp()
    {
        $this->formatter = new CliFormatter();
    }

    public function testAnnouncePlayerHand()
    {
        $cards = new CardCollection();
        $cards->addCard(new Card('A', 'Spades'));
        $cards->addCard(new Card('2', 'Spades'));

        $player = $this->getMock('HumanPlayer', array(), array(), '', false);
        $player->expects($this->once())
            ->method('getHand')
            ->will($this->returnValue($cards));

        $this->expectOutputString("Current Hand: AS 2S \n\n");
        $this->formatter->announcePlayerHand($player);
    }

    public function testAnnouncePlayerHandRegexMatch()
    {
        $cards = new CardCollection();
        $cards->addCard(new Card('A', 'Spades'));
        $cards->addCard(new Card('2', 'Spades'));

        $player = $this->getMock('HumanPlayer', array(), array(), '', false);
        $player->expects($this->once())
            ->method('getHand')
            ->will($this->returnValue($cards));

        $this->expectOutputRegex('/^Current Hand: AS 2S\s+$/');
        $this->formatter->announcePlayerHand($player);
    }

    public function testAnnouncePlayerHandCallback()
    {
        $cards = new CardCollection();
        $cards->addCard(new Card('A', 'Spades'));
        $cards->addCard(new Card('2', 'Spades'));

        $player = $this->getMock('HumanPlayer', array(), array(), '', false);
        $player->expects($this->once())
            ->method('getHand')
            ->will($this->returnValue($cards));

        $this->expectOutputString("Current Hand: AS 2S");
        $this->setOutputCallback(function ($output) {
            return trim($output);
        });
        $this->formatter->announcePlayerHand($player);
    }


    public function testGetCard()
    {
        $method = new ReflectionMethod('CliFormatter', 'getCard');
        $method->setAccessible(true);

        $card = new Card('A', 'Spades');
        $this->assertEquals('AS', $method->invoke($this->formatter, $card));
    }
}
