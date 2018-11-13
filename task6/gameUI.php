<?php

$currentPlayer=$_SESSION['currentPlayer'];
if($currentPlayer===0){
    $friendlyField=$_SESSION['app']->getPlayerFieldOne();
    $enemyField=$_SESSION['app']->getPlayerFieldTwo();
}else{
    $friendlyField=$_SESSION['app']->getPlayerFieldTwo();
    $enemyField=$_SESSION['app']->getPlayerFieldOne();
}
echo "<!DOCTYPE html>
              <html>
                <head>
                    <meta charset=\"utf-8\"/>
                    <title>Sea battle</title>
                </head>
                <body style=\"min-width: 1000px;\">
                <h1>Turn for ".($currentPlayer===0? "Player 1" : "Player 2")."</h1>
                    <div style='width: 220px'>";
for ($i = 1; $i <= 10; $i++)
{
    for ($j = 1; $j <= 10; $j++)
    {
        echo "<a href=\"index.php?x=${i}&y=${j}\" class='".Helper::addEnemyClass($i, $j, $enemyField)."'> </a>";
    }
    echo "<br>";
}
echo "             </div>
                </body>
              </html>";