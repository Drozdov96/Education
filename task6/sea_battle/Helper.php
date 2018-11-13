<?php

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
    }

    /*
     * Enemy html classes:
     * hide= invisible node
     * show= visible node
     */
    public static function addEnemyClass(int $x, int $y, array $field)
    {
        if($field[$x][$y]===2 || $field[$x][$y]===3){
            return "show";
        }else{
            return "hide";
        }
    }

    /*
     * Enemy html classes:
     * hide= invisible node
     * show= visible node
     */
    public static function addFriendlyClass(int $x, int $y, array $field)
    {
        switch ($field[$x][$y]){
            case 0: return "empty";
                break;
            case 1: return "ship";
                break;
            case 2: return "breakShip";
                break;
            case 3: return "miss";
                break;
            default: return "";
        }
    }

}