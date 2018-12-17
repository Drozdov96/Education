<?php

class HtmlHelper
{
    public const CELL_WITH_SHIP_STRING='ship';
    public const EMPTY_CELL_CLASS_STRING='emptyCell';
    public const BREAK_SHIP_CLASS_STRING='breakShipCell';
    public const SHIP_CLASS_STRING='ship';
    public const MISS_CELL_CLASS_STRING='miss';
    public const HIDE_CELL_CLASS_STRING='hide';

    /**
     * @return string
     */
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

    /**
     * @param string $playerName
     * @return string
     */
    public static function getShipsPlacementPage(string $playerName): string
    {
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
                $resultPageString.="<input type=\"checkbox\" name=\"".(string)$i."-".(string)$j."\" value='".self::CELL_WITH_SHIP_STRING."'>";
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

    /**
     * @param string $currentPlayer
     * @param array $friendlyField
     * @param array $enemyField
     * @return string
     */
    public static function getGamePage(string $currentPlayer, array $friendlyField,
                                       array $enemyField)
    {
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
        .".self::HIDE_CELL_CLASS_STRING."{
            background-color: gray;
        }
        
        .".self::BREAK_SHIP_CLASS_STRING."{
            background-color: red;
        }
        
        .".self::EMPTY_CELL_CLASS_STRING."{
            background-color: white;
        }
        
        .".self::SHIP_CLASS_STRING."{
            background-color: green;
        }
        
        .".self::MISS_CELL_CLASS_STRING."{
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

    /**
     * @param string $winnerName
     * @return string
     */
    public static function getEndGamePage(string $winnerName)
    {
        return "<!DOCTYPE html>
              <html>
                <head>
                    <meta charset=\"utf-8\"/>
                    <title>Game end</title>
                </head>
                <body style=\"min-width: 1000px;\">
                <h1>Player ".$winnerName." has won!</h1>
                </body>
              </html>";
    }
}