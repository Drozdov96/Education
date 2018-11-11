<?php

define('SEABATTLE',$_SERVER['DOCUMENT_ROOT'].'/task6/sea_battle/');
spl_autoload_register('autoload');
function autoload($class)
{
    $file = SEABATTLE.$class.'.php';
    if (is_readable($file))
        include_once($file);
}

session_start();

//use sea_battle\Application;

if(!isset($app))
{
    $app= new Application;
}

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

