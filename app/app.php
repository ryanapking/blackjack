<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Blackjack.php';

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    session_start();
    if (empty($_SESSION['game'])) {
        $_SESSION['game'] = new Blackjack();
    }

    $app->get('/', function() use ($app) {
        return $app['twig']->render('gameDisplay.html.twig', array('game' => $_SESSION['game']));
    });

    $app->post('/postChoice', function() use ($app) {
        if ($_POST['playerChoice'] == 'hit') {
            $_SESSION['game']->processTurn();
        } elseif ($_POST['playerChoice'] == 'stand') {
            $_SESSION['game']->player->stand = true;
            $_SESSION['game']->processTurn();
        } elseif ($_POST['playerChoice'] == 'new') {
            $_SESSION['game'] = new Blackjack();
        }
        return $app->redirect('/');
    });

    return $app;
 ?>
