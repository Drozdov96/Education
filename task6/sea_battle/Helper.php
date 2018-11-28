<?php

class Helper
{
//    public static function showPrepareView()
//    {
//        require_once("../code/task6/prepareUI.php");
//    }

    public static function convertFieldArrayToString(array $fieldArray): string
    {
        $fieldString="";
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                if(!empty($fieldArray[(string)$i.'-'.(string)$j]))
                {
                    $fieldString.=(string)$i.'-'.(string)$j;
                }
            }
        }

        return trim($fieldString);
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

//    public static function showGameView()
//    {
//        require_once("../code/task6/gameUI.php");
//    }

    /*
     * Enemy html classes:
     * breakShipCell= visible node with ship
     * hide= invisible node
     * emptyCell= visible node without ship
     */
    public static function getEnemyClass(int $x, int $y, array $field): string
    {
        foreach ($field as $value){
            if($value->coordinateX===$x && $value->coordinateY===$y){
                switch ($value->cellState){
                    case 'hit': return "breakShipCell";
                        break;
                    case 'miss': return "emptyCell";
                        break;
                    default: return "hide";
                }
            }
        }
        return "";
    }

    public static function getFriendlyClass(int $x, int $y, array $field): string
    {
        foreach ($field as $value){
            if($value->coordinateX===$x && $value->coordinateY===$y){
                switch ($value->cellState){
                    case 'empty': return "emptyCell";
                        break;
                    case 'ship': return "ship";
                        break;
                    case 'hit': return "breakShipCell";
                        break;
                    case 'miss': return "miss";
                        break;
                    default: return "";
                }
            }
        }
        return "";
    }

    public static function loadFieldOneFromFile(){
        $file=fopen("./task6/sea_battle/files/field_one.txt","r");
        $result=json_decode(fread($file,
            filesize("./task6/sea_battle/files/field_one.txt")));
        fclose($file);
        return $result;
    }

    public static function loadFieldTwoFromFile(){
        $file=fopen("./task6/sea_battle/files/field_two.txt","r");
        $result=json_decode(fread($file,
            filesize("./task6/sea_battle/files/field_two.txt")));
        fclose($file);
        return $result;
    }

}