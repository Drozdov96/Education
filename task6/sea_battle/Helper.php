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
    public static function getEnemyClass(int $x, int $y, StdClass $field)
    {
        switch ($field->{$x}->{$y}->cellState){
            case 2: return "breakShipCell";
                break;
            case 3: return "emptyCell";
                break;
            default: return "hide";
        }
    }

    /*
     * Enemy html classes:
     * hide= invisible node
     * show= visible node
     */
    public static function getFriendlyClass(int $x, int $y, StdClass $field)
    {
        switch ($field->{$x}->{$y}->cellState){
            case 0: return "emptyCell";
                break;
            case 1: return "ship";
                break;
            case 2: return "breakShipCell";
                break;
            case 3: return "miss";
                break;
            default: return "";
        }
    }

    public static function loadFieldOneFromFile(){
        $file=fopen("/task6/sea_battle/files/field_one.txt","r");
        $result=json_decode(fread($file,
            filesize("/task6/sea_battle/files/field_one.txt")));
        fclose($file);
        return $result;
    }

    public static function loadFieldTwoFromFile(){
        $file=fopen("/task6/sea_battle/files/field_two.txt","r");
        $result=json_decode(fread($file,
            filesize("/task6/sea_battle/files/field_two.txt")));
        fclose($file);
        return $result;
    }

}