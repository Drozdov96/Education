<?php

require './course/task6/vendor/autoload.php';


session_start();

if(empty($_SESSION['gameId'])){
    $app= new Application(Application::NEW_GAME_NUM);
}else{
    $app= new Application($_SESSION['gameId']);
}

$app->doRoute(empty($_GET['state'])?"":$_GET['state']);

