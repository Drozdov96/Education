<?php
/**
 * Задание: написать функцию для перевода чисел из любой системы счисления
 * в любую. Желательно разделять уровни абстракции в алгоритме.
 *
 *
 */

echo convertNumberToOtherNumberSystem("12cda",16,2);

function convertNumberToOtherNumberSystem(string $number, int $initialNumbSystem, int $nextNumbSystem)
{
    numToDecimal($number, $initialNumbSystem);
    return decToNumbSystem(numToDecimal($number, $initialNumbSystem), $nextNumbSystem);
}

//функция перевода числа из его системы счисления в десятичную систему счисления
function numToDecimal(string $number, int $initialNumbSystem)
{
    if($initialNumbSystem!==10){
        $separatedNumberArray=separateNumber($number);

        if($initialNumbSystem > 10){
            $separatedNumberArray=letterToNumber($separatedNumberArray);
        }

        return addNumbers(multiplicationNumbers($separatedNumberArray, $initialNumbSystem));
    }else{
        return (int)$number;
    }

}

function decToNumbSystem(int $decimalNumber, int $nextNumbSystem)
{
    if ($nextNumbSystem === 10){
        return $decimalNumber;
    } else {
        return divisionDecimalOnNumberBase($decimalNumber, $nextNumbSystem);
    }
}

function divisionDecimalOnNumberBase(int $decimalNumber, int $nextNumbSystem)
{
    //var_dump($decimalNumber);
    //var_dump($nextNumbSystem);
    if($decimalNumber<$nextNumbSystem){
        $resultNumber=(string)$decimalNumber;
    }else{
        $resultNumber=(string)($decimalNumber%$nextNumbSystem);
        $resultNumber=(string)decToNumbSystem(intdiv($decimalNumber,$nextNumbSystem), $nextNumbSystem).$resultNumber;
    }
    return $resultNumber;
}

function separateNumber(string $number)
{
    return str_split($number);
}

//перевод буквенных символов в их числовые эквиваленты
function letterToNumber(array $separatedNumberArray)
{
    foreach ($separatedNumberArray as $key => $arrayValue){
        switch($arrayValue){
            case 'a':
                $separatedNumberArray[$key]='10';
                break;
            case 'b':
                $separatedNumberArray[$key]='11';
                break;
            case 'c':
                $separatedNumberArray[$key]='12';
                break;
            case 'd':
                $separatedNumberArray[$key]='13';
                break;
            case 'e':
                $separatedNumberArray[$key]='14';
                break;
            case 'f':
                $separatedNumberArray[$key]='15';
                break;
            case 'g':
                $separatedNumberArray[$key]='16';
                break;
            case 'h':
                $separatedNumberArray[$key]='17';
                break;
            case 'i':
                $separatedNumberArray[$key]='18';
                break;
            case 'j':
                $separatedNumberArray[$key]='19';
                break;
            case 'k':
                $separatedNumberArray[$key]='20';
                break;
            case 'l':
                $separatedNumberArray[$key]='21';
                break;
            case 'm':
                $separatedNumberArray[$key]='22';
                break;
            case 'n':
                $separatedNumberArray[$key]='23';
                break;
            case 'o':
                $separatedNumberArray[$key]='24';
                break;
            case 'p':
                $separatedNumberArray[$key]='25';
                break;
            case 'q':
                $separatedNumberArray[$key]='26';
                break;
            case 'r':
                $separatedNumberArray[$key]='27';
                break;
            case 's':
                $separatedNumberArray[$key]='28';
                break;
            case 't':
                $separatedNumberArray[$key]='29';
                break;
            case 'u':
                $separatedNumberArray[$key]='30';
                break;
            case 'v':
                $separatedNumberArray[$key]='31';
                break;
            case 'w':
                $separatedNumberArray[$key]='32';
                break;
            case 'x':
                $separatedNumberArray[$key]='33';
                break;
            case 'y':
                $separatedNumberArray[$key]='34';
                break;
            case 'z':
                $separatedNumberArray[$key]='35';
                break;
        }
    }
    return $separatedNumberArray;
}

function multiplicationNumbers(array $separatedNumberArray, int $initialNumbSystem)
{
    $arrayRange = count($separatedNumberArray)-1;
    for($i=$arrayRange;$i>=0;$i--){
        //echo $separatedNumberArray[$arrayRange-$i];
        //echo ($initialNumbSystem**$i);
        $separatedNumberArray[$arrayRange-$i]=(int)$separatedNumberArray[$arrayRange-$i] * ($initialNumbSystem**$i);
        //var_dump($separatedNumberArray[$arrayRange-$i]);
    }
    //var_dump($separatedNumberArray);
    return $separatedNumberArray;
}

function addNumbers(array $separatedNumberArray)
{
    $total=0;

    foreach ($separatedNumberArray as $arrayValue){
        $total+=$arrayValue;
    }
    return $total;
}
