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

        class Deck
        {
            private $cards;

            function __construct()
            {
                $this->cards = array();
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
        }

        class Hand
        {
            private $name;
            private $cards;
            private $score;

            function __construct($name)
            {
                $this->name = $name;
                $this->score = 0;
                $this->cards = array();
            }
        }

        class Card
        {
            private $suit;
            private $rank;

            function __construct($rank, $suit)
            {
                $this->suit = $suit;
                $this->rank = $rank;
            }
        }
    }
 ?>
