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

if(empty($_SESSION['gameId'])){
    $app= new Application(Application::NEW_GAME_NUM);
}else{
    $app= new Application($_SESSION['gameId']);
}

$app->doRoute(empty($_GET['state'])?"":$_GET['state']);

