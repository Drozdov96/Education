<?php

/*$name="Никита";
$surname="Дроздов";
$age=20;
$isPregnant=false;
$isStudent=false;
$postCode="443567";
$gender="мужчина"; */

//Нормально ли для проверки заполнения всей формы использовать всего одну обязательно заполняемую переменную?
if(!empty($_POST['name'])){
    $name=strip_tags($_POST['name']);
    $surname=strip_tags($_POST['surname']);
    $age=(int)$_POST['age'];
    $gender=strip_tags($_POST['gender']);
    $gender==="мужчина"? $isPregnant=false : $isPregnant=(bool)$_POST['isPregnant'];
    $isStudent=(bool)$_POST['isStudent'];
    $postCode=(int)$_POST['postCode'];

    echo "Всем привет! Меня зовут ".$name." ".$surname.". Мне ".strval($age).
        " лет. Я ".$gender." и ". ($isStudent? "обучаюсь в ВУЗе. ": "не обучаюсь в ВУЗе. ").
        ($gender==="женщина" && $isPregnant?"Я беременна.": "")."Пишите мне на почтовый адрес: ".$postCode. ".";
}

