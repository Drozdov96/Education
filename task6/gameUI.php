<?php


echo "<!DOCTYPE html>
              <html>
                <head>
                    <meta charset=\"utf-8\"/>
                    <title>Sea battle</title>
                </head>
                <body style=\"min-width: 1000px;\">
                <h1>Turn for 'currentplayer'</h1>
                    <div style='width: 220px'>";
for ($i = 1; $i <= 10; $i++)
{
    for ($j = 1; $j <= 10; $j++)
    {
        echo "<a href=\"index.php?x=${i}&y=${j}\" >as </a>";
    }
    echo "<br>";
}
echo "             </div>
                </body>
              </html>";