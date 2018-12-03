<?php

class HtmlHelper
{
    public static function getPlayersNamePage(): string
    {
        return "<!DOCTYPE html>
              <html>
                <head>
                    <meta charset=\"utf-8\"/>
                    <title>Welcome!</title>
                </head>
                <body style=\"min-width: 1000px;\">
                <h1>Enter player names</h1>
                    <div style='width: 220px'>
                     <form name='player_names' action=\"?state=setNames\" method=\"post\">
                     <p>Player one:</p><br>
                     <input type=\"text\" name=\"playerOneName\" required><br><br>
                     <p>Player two:</p><br>
                     <input type=\"text\" name='playerTwoName' required>
                     <input type='submit' name='submit_btn' value='Confirm'>
                     </form>
                    </div>
                </body>
              </html>";
    }

    public static function getShipsPlacementPage(string $playerName): string
    {
        //$playerOneShipsString="";
//        if(isset($_POST['submit_btn_place']))
//        {
//            if(empty($_POST['player_one']))
//            {
//                $playerOneShipsString=Helper::convertFieldArrayToString($_POST);
//            }else{
//                $_SESSION['player_one_field'] = $_POST['player_one'];
//                $_SESSION['player_two_field'] = Helper::convertFieldArrayToString($_POST);
//
//                header("Refresh:0; url=index.php?state=startGame");
//                exit;
//            }
//        }

        $resultPageString="<!DOCTYPE html>
              <html>
                <head>
                    <meta charset=\"utf-8\"/>
                    <title>Prepare to battle</title>
                </head>
                <body style=\"min-width: 1000px;\">
                <h1>Player ".$playerName." place ships on the field!</h1>
                    <div style='width: 220px'>
                     <form name='play-field' action=\"?state=preparePhase\" method=\"post\">";
        for ($i = 1; $i <= 10; $i++)
        {
            for ($j = 1; $j <= 10; $j++)
            {
                $resultPageString.="<input type=\"checkbox\" name=\"".(string)$i."-".(string)$j."\" value='ship'>";
            }
            $resultPageString.="<br>";
        }                   //нужно ли добавить условия проверки инициализации переменной
        $resultPageString.="<input type=\"hidden\" name=\"player_one\" 
            value=''>
                    <input type=\"submit\" name=\"submit_btn_place\" 
                        value=\"Confirm\" >
                </form>
                    </div>
                </body>
              </html>";
        return $resultPageString;
    }

    public static function getGamePage(string $currentPlayer, array $friendlyField,
                                       array $enemyField)
    {
//        $currentPlayerNum=$_SESSION['currentPlayerNum'];
//        if($currentPlayerNum===0){
//            $friendlyField=Helper::loadFieldOneFromFile();
//            $enemyField=Helper::loadFieldTwoFromFile();
//        }else{
//            $friendlyField=Helper::loadFieldTwoFromFile();
//            $enemyField=Helper::loadFieldOneFromFile();
//        }

        $resultPageString="<!DOCTYPE html>
              <html>
                <head>  
                    <meta charset=\"utf-8\"/>
                    <title>Sea battle</title>
                </head>
                <body style=\"min-width: 1000px;\">
                <h1>Turn for ".$currentPlayer."</h1>
                    <div style='width: 220px'>
                    <table>";
//вывод таблицы для атаки
        for ($i = 1; $i <= 10; $i++)
        {
            $resultPageString.="<tr>";
            for ($j = 1; $j <= 10; $j++)
            {
                $resultPageString.="<td><a href=\"index.php?x=".(string)$i."&y=".(string)$j."&state=doStep\" class='".
                    Helper::getEnemyClass($i, $j, $enemyField)."'>&nbsp;</a></td>";
            }
            $resultPageString.="</tr>";
        }
        $resultPageString.="</table>      
                 </div><div style='width: 220px'>
                    <table>";
//вывод таблицы игрока
        for ($i = 1; $i <= 10; $i++)
        {
            $resultPageString.="<tr>";
            for ($j = 1; $j <= 10; $j++)
            {
                $resultPageString.="<td class='".Helper::getFriendlyClass($i, $j, $friendlyField)."'>&nbsp;</td>";
            }
            $resultPageString.="</tr>";
        }
        $resultPageString.="</table>      
                 </div>
                </body>
              </html>";
        $resultPageString.="<style>
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
            height: 20px;
        }
        
        td{
            width: 20px;
            height: 20px;
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
        return $resultPageString;
    }
}