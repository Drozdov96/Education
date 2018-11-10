<?php

session_start();
echo $_SESSION['player_one_field'];
echo $_SESSION['player_two_field'];
echo 1;
//use sea_battle\Application;

$app= new Application;

if(empty($_SESSION['player_one_field']) && empty($_SESSION['player_two_field']))
{
    $app->run();
}else{
    echo "s";
}
