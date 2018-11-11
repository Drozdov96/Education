<?php
/**
 * Created by PhpStorm.
 * User: Flatty
 * Date: 10.11.2018
 * Time: 12:21
 */

class Helper
{
    public static function showPrepareView()
    {
        require_once("../code/task6/prepareUI.php");
    }

    public static function convertFieldArrayToString(string $fieldKeysString, array $fieldArray): string
    {
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                if(!empty($fieldArray["${i}-${j}"]))
                {
                    $fieldKeysString.=" ${i}-${j}";
                }
            }
        }

        return trim($fieldKeysString);
    }

    public static function convertStringToFieldArray(string $fieldKeysString): array
    {
        $initialKeysArray=explode(" ",$fieldKeysString);
        $newKeysArray=array();
        foreach ($initialKeysArray as &$value)
        {
            $newKeysArray[]=explode("-",$value);
        }

        return $newKeysArray;
    }

    public static function showGameView()
    {
        require_once("../code/task6/gameUI.php");
        return $_GET['x'].$_GET['y'];
    }

}