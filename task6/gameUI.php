<?php

$currentPlayer=$_SESSION['currentPlayerNum'];
if($currentPlayer===0){
//    $friendlyField=$_SESSION['app']->getPlayerFieldOne();
//    $enemyField=$_SESSION['app']->getPlayerFieldTwo();
    $friendlyField=Helper::loadFieldOneFromFile();
    $enemyField=Helper::loadFieldTwoFromFile();
}else{
//    $friendlyField=$_SESSION['app']->getPlayerFieldTwo();
//    $enemyField=$_SESSION['app']->getPlayerFieldOne();
    $friendlyField=Helper::loadFieldTwoFromFile();
    $enemyField=Helper::loadFieldOneFromFile();
}
echo "<!DOCTYPE html>
              <html>
                <head>  
                    <meta charset=\"utf-8\"/>
                    <title>Sea battle</title>
                </head>
                <body style=\"min-width: 1000px;\">
                <h1>Turn for ".($currentPlayer===0? "Player 1" : "Player 2")."</h1>
                    <div style='width: 220px'>
                    <table>";
//вывод таблицы для атаки
for ($i = 1; $i <= 10; $i++)
{
    echo "<tr>";
    for ($j = 1; $j <= 10; $j++)
    {
        echo "<td><a href=\"index.php?x=${i}&y=${j}\" class='".
            Helper::getEnemyClass($i, $j, $enemyField)."'>&nbsp;</a></td>";
    }
    echo "</tr>";
}
echo "           </table>      
                 </div>
                 <div style='width: 220px'>
                    <table>";
//вывод таблицы игрока
for ($i = 1; $i <= 10; $i++)
{
    echo "<tr>";
    for ($j = 1; $j <= 10; $j++)
    {
        echo "<td class='".Helper::getFriendlyClass($i, $j, $friendlyField)."'>&nbsp;</td>";
    }
    echo "</tr>";
}
echo "           </table>      
                 </div>
                </body>
              </html>";
echo "<style>
        .hide{
            background-color: gray;
        }
        
        .breakShipCell{
            background-color: red;
        }
        
        .emptyCell{
            background-color: white;
        }
        
        .ship{
            background-color: green;
        }
        
        .miss{
            background-color: orange;
        }
        
        a{
            display: block;
            text-decoration: none;
            width: 20px;
            heigth: 20px;
        }
        
        td{
            width: 20px;
            heigth: 20px;
        }
        
        tr{
            height: 20px;
        }
        
        table, tr, td{
            border: 1px solid black;
        }
        
        div{
            display: inline-block;
            margin-left: 200px;
        }
      </style>";