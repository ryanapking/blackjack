<?php
    class Blackjack
    {
        private $deck;
        private $player;
        private $dealer;

        function __construct()
        {
            $this->deck = new Deck();
            $this->player = new Hand("player");
            $this->dealer = new Hand("dealer");
        }
    }

    class Deck
    {
        public $cards;

        function __construct()
        {
            $this->cards = array();
            $this->buildDeck();
            $this->shuffle();
        }

        function buildDeck()
        {
            for ($i = 1; $i < 5; $i++) {
                for ($j = 1; $j < 14; $j++) {
                    $rank = strval($j);
                    switch ($i) {
                        case 1:
                            $suit .= "C";
                            break;
                        case 2:
                            $suit .= "S";
                            break;
                        case 3:
                            $suit .= "H";
                            break;
                        case 4:
                            $suit .= "D";
                            break;
                    }
                    array_push($this->cards, new Card($rank, $suit));
                }
            }
        }

        function shuffle()
        {
            shuffle($this->cards);
        }

        function pullCard()
        {
            return array_pop($this->cards);
        }
    }

    class Hand
    {
        public $name;
        public $cards;
        public $score;

        function __construct($name)
        {
            $this->name = $name;
            $this->score = 0;
            $this->cards = array();
        }

        function getCard($card)
        {
            array_push($this->cards, $card);
        }

        function calculateScore()
        {
            $this->score = 0;
            foreach ($this->cards as $card) {
                $this->score += $card->blackjackValue;
            }
        }
    }

    class Card
    {
        public $suit;
        public $rank;
        public $blackjackValue;

        function __construct($rank, $suit)
        {
            $this->suit = $suit;
            $this->rank = $rank;
        }

        function getBlackjackValue()
        {
            if ($this->rank == 1) {
                $this->blackjackValue = 11;
            } else if ($this->rank < 11) {
                $this->blackjackValue = $this->rank;
            } else {
                $this->blackjackValue = 10;
            }
        }
    }

 ?>
