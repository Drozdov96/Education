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

$controller=new Controller();
$controller->doRoute($_GET['state']);



