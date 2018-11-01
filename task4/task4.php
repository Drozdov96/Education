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
    $decimalNumber=numToDecimal($number, $initialNumbSystem);
    return decToNumbSystem($decimalNumber, $nextNumbSystem);
}

//функция перевода числа из его системы счисления в десятичную систему счисления
function numToDecimal(string $number, int $initialNumbSystem)
{
    if($initialNumbSystem===10)
    {
        return (int)$number;
    }else{
        $separatedNumberArray=separateNumber($number);

        if($initialNumbSystem > 10)
        {
            $separatedNumberArray=letterToNumber($separatedNumberArray);
        }

        return addNumbers(multiplicationNumbers($separatedNumberArray, $initialNumbSystem));
    }

}

function decToNumbSystem(int $decimalNumber, int $nextNumbSystem)
{
    if ($nextNumbSystem === 10)
    {
        return (string)$decimalNumber;
    } else {
        return divisionDecimalOnNumberBase($decimalNumber, $nextNumbSystem);
    }
}

function divisionDecimalOnNumberBase(int $decimalNumber, int $nextNumbSystem)
{
    if($decimalNumber<$nextNumbSystem){
        $resultNumberInString=(string)$decimalNumber;
    }else{
        $resultNumberInString=(string)($decimalNumber%$nextNumbSystem);
        $resultNumberInString=(string)decToNumbSystem(intdiv($decimalNumber,$nextNumbSystem), $nextNumbSystem)
            .$resultNumberInString;
    }
    return $resultNumberInString;
}

function separateNumber(string $number)
{
    return str_split($number);
}

function multiplicationNumbers(array $separatedNumberArray, int $initialNumbSystem)
{
    $degreeForConvert = count($separatedNumberArray)-1;

    foreach($separatedNumberArray as &$arrayValue)
    {
        $arrayValue=(int)$arrayValue * ($initialNumbSystem**$degreeForConvert);
        $degreeForConvert--;
    }
    return $separatedNumberArray;
}

function addNumbers(array $separatedNumberArray)
{
    $total=0;

    foreach ($separatedNumberArray as $arrayValue)
    {
        $total+=$arrayValue;
    }
    return $total;
}

//перевод буквенных символов в их числовые эквиваленты
function letterToNumber(array $separatedNumberArray)
{
    foreach ($separatedNumberArray as &$arrayValue)
    {
        switch($arrayValue){
            case 'a':
                $arrayValue='10';
                break;
            case 'b':
                $arrayValue='11';
                break;
            case 'c':
                $arrayValue='12';
                break;
            case 'd':
                $arrayValue='13';
                break;
            case 'e':
                $arrayValue='14';
                break;
            case 'f':
                $arrayValue='15';
                break;
            case 'g':
                $arrayValue='16';
                break;
            case 'h':
                $arrayValue='17';
                break;
            case 'i':
                $arrayValue='18';
                break;
            case 'j':
                $arrayValue='19';
                break;
            case 'k':
                $arrayValue='20';
                break;
            case 'l':
                $arrayValue='21';
                break;
            case 'm':
                $arrayValue='22';
                break;
            case 'n':
                $arrayValue='23';
                break;
            case 'o':
                $arrayValue='24';
                break;
            case 'p':
                $arrayValue='25';
                break;
            case 'q':
                $arrayValue='26';
                break;
            case 'r':
                $arrayValue='27';
                break;
            case 's':
                $arrayValue='28';
                break;
            case 't':
                $arrayValue='29';
                break;
            case 'u':
                $arrayValue='30';
                break;
            case 'v':
                $arrayValue='31';
                break;
            case 'w':
                $arrayValue='32';
                break;
            case 'x':
                $arrayValue='33';
                break;
            case 'y':
                $arrayValue='34';
                break;
            case 'z':
                $arrayValue='35';
                break;
        }
    }
    return $separatedNumberArray;
}
