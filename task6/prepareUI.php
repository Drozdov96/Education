<?php

echo "<!DOCTYPE html>
              <html>
                <head>
                    <meta charset=\"utf-8\"/>
                    <title>Prepare to battle</title>
                </head>
                <body style=\"min-width: 1000px;\">
                    <div>
                     <form name='play-field' action method=\"post\">";
for ($i = 1; $i <= 10; $i++)
{
    for ($j = 1; $j <= 10; $j++)
    {
        echo "<input type=\"checkbox\" name\"${i}-$j\" >";
    }
    echo "<br>";
}
echo "        </form>
                    </div>
                </body>
              </html>";