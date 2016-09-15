<?php
    class Blackjack
    {
        public $deck;
        public $player;
        public $dealer;
        public $bank;
        public $bet;
        public $gameover;

        function __construct()
        {
            $this->deck = new Deck();
            $this->player = new Hand("player");
            $this->dealer = new Hand("dealer");
            $this->bank = 100;
            $this->bet = 5;
            $this->gameover = false;
            $this->initialDeal();
        }

        function initialDeal()
        {
            $this->player->getCard($this->deck->pullCard());
            $this->dealer->getCard($this->deck->pullCard());
            $this->dealer->cards[0]->img = '/img/back.jpg';
            $this->player->getCard($this->deck->pullCard());
            $this->dealer->getCard($this->deck->pullCard());
            $this->player->calculateScore();
            $this->dealer->calculateScore();
        }

        function processTurn()
        {
            if (!$this->player->stand && !$this->player->bust) {
                $this->player->getCard($this->deck->pullCard());
                $this->player->calculateScore();
                if ($this->player->bust) {
                    $this->bank -= $this->bet;
                    if ($this->bank <= 0) {
                        $this->gameover = true;
                    }
                    return;
                }
            } else {
                $this->dealerLogic();
                if (!$this->player->bust && $this->dealer->bust ||
                    !$this->player->bust && $this->player->score > $this->dealer->score) {
                    $this->bank += $this->bet;
                } elseif ($this->player->bust ||
                            !$this->dealer->bust && $this->dealer->score > $this->player->score) {
                    $this->bank -= $this->bet;
                    if ($this->bank <= 0) {
                        $this->gameover = true;
                    }
                }
            }
            return;
        }

        function newHand()
        {
            $this->player->cards = array();
            $this->dealer->cards = array();
            $this->player->stand = false;
            $this->player->bust = false;
            $this->dealer->stand = false;
            $this->dealer->bust = false;
            $this->initialDeal();
        }

        function dealerLogic()
        {
            $this->dealer->cards[0]->setImage();
            while ($this->dealer->score < 17) {
                $this->dealer->getCard($this->deck->pullCard());
                $this->dealer->calculateScore();
            }
            if (!$this->dealer->bust) {
                $this->dealer->stand = true;
            }
        }

        function getDeck()
        {
            return $this->deck;
        }
    }

    class Deck
    {
        public $cards;

        function __construct()
        {
            $this->cards = array();
            $this->buildDeck();
        }

        function buildDeck()
        {
            for ($i = 1; $i < 5; $i++) {
                for ($j = 1; $j < 14; $j++) {
                    $rank = strval($j);
                    switch ($i) {
                        case 1:
                            $suit = "clubs";
                            break;
                        case 2:
                            $suit = "spades";
                            break;
                        case 3:
                            $suit = "hearts";
                            break;
                        case 4:
                            $suit = "diamonds";
                            break;
                    }
                    array_push($this->cards, new Card($rank, $suit));
                }
            }
            for($i = 0; $i < 7; $i++) {
                $this->shuffle();
            }
        }

        function shuffle()
        {
            shuffle($this->cards);
        }

        function pullCard()
        {
            $card = array_pop($this->cards);
            if (sizeof($this->cards) == 0) {
                $this->buildDeck();
            }
            return $card;
        }

        function getSize()
        {
            return sizeof($this->cards);
        }
    }

    class Hand
    {
        public $name;
        public $cards;
        public $score;
        public $stand;
        public $bust;

        function __construct($name)
        {
            $this->name = $name;
            $this->stand = false;
            $this->bust = false;
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
            if ($this->score > 21) {
                for ($i = 0; $i <= sizeof($this->cards); $i++) {
                    if ($this->cards[$i]->blackjackValue == 11) {
                        $this->cards[$i]->blackjackValue = 1;
                        $this->calculateScore();
                        return;
                    }
                }
                $this->bust = true;
            }
        }
    }

    class Card
    {
        public $suit;
        public $rank;
        public $title;
        public $blackjackValue;
        public $img;

        function __construct($rank, $suit)
        {
            $this->suit = $suit;
            $this->rank = $rank;
            $this->getBlackjackValue();
            $this->setTitle();
            $this->setImage();
        }

        function setTitle()
        {
            switch ($this->rank) {
                case 1:
                    $this->title = 'ace';
                    break;
                case 11:
                    $this->title = 'jack';
                    break;
                case 12:
                    $this->title = 'queen';
                    break;
                case 13:
                    $this->title = 'king';
                    break;
                default:
                    $this->title = strval($this->rank);
            }
        }

        function setImage()
        {
            $this->img = '/img/' . $this->title . '_of_' . $this->suit . '.png';
            // $this->img = '/img/black_joker.png';
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
