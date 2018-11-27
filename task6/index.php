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
    $app= new Application;
}else{
    $app=$_SESSION['app'];
}

$app->doRoute($_GET['state']===null?"":$_GET['state']);



