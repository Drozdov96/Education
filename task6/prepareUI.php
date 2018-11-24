<?php

$fieldKeysString="";
if(isset($_POST['submit_btn']))
{
    if(empty($_POST['player_one']))
    {
        $fieldKeysString=Helper::convertFieldArrayToString($fieldKeysString, $_POST);
    }else{
        $_SESSION['player_one_field'] = $_POST['player_one'];
        $_SESSION['player_two_field'] = Helper::convertFieldArrayToString($fieldKeysString, $_POST);

        header("Refresh:0; url=index.php?state=startGame");
        exit;
    }
}

echo "<!DOCTYPE html>
              <html>
                <head>
                    <meta charset=\"utf-8\"/>
                    <title>Prepare to battle</title>
                </head>
                <body style=\"min-width: 1000px;\">
                <h1>Place ships on the field!</h1>
                    <div style='width: 220px'>
                     <form name='play-field' action=\"?state=preparePhase\" method=\"post\">";
for ($i = 1; $i <= 10; $i++)
{
    for ($j = 1; $j <= 10; $j++)
    {
        echo "<input type=\"checkbox\" name=\"${i}-${j}\" value='ship'>";
    }
    echo "<br>";
}                   //нужно ли добавить условия проверки инициализации переменной
echo "              <input type=\"hidden\" name=\"player_one\" value=\"".$fieldKeysString."\" >
                    <input type=\"submit\" name=\"submit_btn\" value=\"Confirm\" >
                </form>
                    </div>
                </body>
              </html>";