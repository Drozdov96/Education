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


if(empty($_SESSION['app'])) {
   $app=$_SESSION['app'];
}else{
    $app= new Application;
}
if(!empty($_GET['x']) && !empty($_GET['y'])){
    $app->doStep($_GET['x'], $_GET['y'], $_SESSION['currentPlayerNum']);
    unset($_GET['x'], $_GET['y']);
}elseif(empty($_SESSION['player_one_field']) || empty($_SESSION['player_two_field']))
{
    $app->runPreparePhase();
}else{
    echo "1";
    $app->runGame($_SESSION['player_one_field'], $_SESSION['player_two_field']);
    unset($_SESSION['player_one_field'],$_SESSION['player_two_field']);
}


