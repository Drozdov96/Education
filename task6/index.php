<?php

session_start();
//echo $_SESSION['player_one_field'];
//echo $_SESSION['player_two_field'];

//use sea_battle\Application;

if(!isset($app))
    $app= new Application;

if(!empty($_GET['x']) && !empty($_GET['y']))
{
    $app->addStep($_GET['x'], $_GET['y']);
    Helper::showGameView();
}else{
    if(empty($_SESSION['player_one_field']) && empty($_SESSION['player_two_field']))
    {
        $app->runPreparePhase();
    }else{
        echo "1";
        $app->run();
    }
}

