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

if(empty($_SESSION['game'])) {
    $app= new Application;
}else{
    $app= new Application;
    $app->setGame($_SESSION['game']);
}

$app->doRoute($_GET['state']===null?"":$_GET['state']);



