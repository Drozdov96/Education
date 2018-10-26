<?php

$name="Никита";
$surname="Дроздов";
$age=20;
$isPregnant=false;
$isStudent=false;
$postCode="443567";
$gender="мужчина";

echo "Всем привет! Меня зовут ".$name." ".$surname.". Мне ".strval($age).
    " лет. Я ".$gender." и ".($isStudent? "обучаюсь в ВУЗе. ": "не обучаюсь в ВУЗе. ").
    ($gender==="женщина" && $isPregnant?"Я беременна.": "").
    "Пишите мне на почтовый адрес: ".$postCode.".";
