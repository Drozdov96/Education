<?php

class Helper
{

    public static function convertFieldArrayToString(array $fieldArray): string
    {
        $resultString="";
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                if(!empty($fieldArray[(string)$i.'-'.(string)$j])) {
                    $resultString.=' '.(string)$i.'-'.(string)$j;
                }
            }
        }

        return trim($resultString);
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

    public static function verifyInputFieldArray(array $fieldArray): bool
    {
        $oneDeckCount=0;
        $twoDeckCount=0;
        $threeDeckCount=0;
        $fourDeckCount=0;
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                if(!empty($fieldArray[(string)$i.'-'.(string)$j]) &&
                    $fieldArray[(string)$i.'-'.(string)$j]===HtmlHelper::CELL_WITH_SHIP_STRING) {
                    switch(Helper::checkShip($i, $j, $fieldArray, 0)){
                        case 0:
                            return false;
                        case 1:
                            $oneDeckCount++;
                            break;
                        case 2:
                            $twoDeckCount++;
                            break;
                        case 3:
                            $threeDeckCount++;
                            break;
                        case 4:
                            $fourDeckCount++;
                            break;
                    }
                }
            }
        }
        //убрал условие на проверку количества кораблей, для облегчения отладки.
        //if($oneDeckCount===4 && $twoDeckCount===3 && $threeDeckCount===2 &&
        //$fourDeckCount===1)
        return true;
    }

    public static function checkShip(int $x, int $y, array &$fieldArray, int $deckCount)
    {
        $deckCount++;

        if(Helper::checkExistDiagonalNodes($x, $y, $fieldArray)){
            return 0;
        }
        switch (Helper::checkNearShipsNum($x, $y, $fieldArray)){
            case 0:
                $fieldArray[(string)$x.'-'.(string)$y]='checked';
                return $deckCount;
                break;
            case 1:
                if($deckCount<4){
                    $fieldArray[(string)$x.'-'.(string)$y]='checked';
                    $neighbourX=$x;
                    $neighbourY=$y;
                    Helper::switchCoordinatesToNeighbourShip($neighbourX, $neighbourY, $fieldArray);
                    return Helper::checkShip($neighbourX,$neighbourY, $fieldArray, $deckCount);
                }else{
                    return 0;
                }
            default:
                return 0;
        }
    }

    public static function switchCoordinatesToNeighbourShip(int &$x, int &$y, array $fieldArray)
    {
        if(!empty($fieldArray[(string)($x+1).'-'.(string)($y)]) &&
            $fieldArray[(string)($x+1).'-'.(string)($y)]===HtmlHelper::CELL_WITH_SHIP_STRING){
            $x+=1;
        }elseif (!empty($fieldArray[(string)($x-1).'-'.(string)($y)]) &&
            $fieldArray[(string)($x-1).'-'.(string)($y)]===HtmlHelper::CELL_WITH_SHIP_STRING){
            $x-=1;
        }elseif (!empty($fieldArray[(string)($x).'-'.(string)($y+1)]) &&
            $fieldArray[(string)($x).'-'.(string)($y+1)]===HtmlHelper::CELL_WITH_SHIP_STRING){
            $y+=1;
        }elseif (!empty($fieldArray[(string)($x).'-'.(string)($y-1)]) &&
            $fieldArray[(string)($x).'-'.(string)($y-1)]===HtmlHelper::CELL_WITH_SHIP_STRING) {
            $y-=1;
        }
    }

    public static function checkNearShipsNum(int $x,int $y,array $fieldArray): int
    {
        $resultNum=0;
        if(!empty($fieldArray[(string)($x+1).'-'.(string)($y)]) &&
            $fieldArray[(string)($x+1).'-'.(string)($y)]===HtmlHelper::CELL_WITH_SHIP_STRING){
            $resultNum++;
        }
        if (!empty($fieldArray[(string)($x-1).'-'.(string)($y)]) &&
            $fieldArray[(string)($x-1).'-'.(string)($y)]===HtmlHelper::CELL_WITH_SHIP_STRING){
            $resultNum++;
        }
        if (!empty($fieldArray[(string)($x).'-'.(string)($y+1)]) &&
            $fieldArray[(string)($x).'-'.(string)($y+1)]===HtmlHelper::CELL_WITH_SHIP_STRING){
            $resultNum++;
        }
        if (!empty($fieldArray[(string)($x).'-'.(string)($y-1)]) &&
            $fieldArray[(string)($x).'-'.(string)($y-1)]===HtmlHelper::CELL_WITH_SHIP_STRING) {
            $resultNum++;
        }
        return $resultNum;
    }

    public static function checkExistDiagonalNodes(int $x, int $y, array $fieldArray): bool
    {
        if(!empty($fieldArray[(string)($x+1).'-'.(string)($y+1)])){
            return true;
        }elseif (!empty($fieldArray[(string)($x-1).'-'.(string)($y+1)])){
            return true;
        }elseif (!empty($fieldArray[(string)($x-1).'-'.(string)($y-1)])){
            return true;
        }elseif (!empty($fieldArray[(string)($x+1).'-'.(string)($y-1)])) {
            return true;
        }
        return false;
    }

    public static function getEnemyClass(int $x, int $y, array $field): string
    {
        foreach ($field as $value){
            if($value->coordinateX===$x && $value->coordinateY===$y){
                switch ($value->cellState){
                    case Cell::HIT_CELL_STATE: return HtmlHelper::BREAK_SHIP_CLASS_STRING;
                        break;
                    case Cell::MISS_CELL_STATE: return HtmlHelper::EMPTY_CELL_CLASS_STRING;
                        break;
                    default: return HtmlHelper::HIDE_CELL_CLASS_STRING;
                }
            }
        }
    }

    public static function getFriendlyClass(int $x, int $y, array $field): string
    {
        foreach ($field as $value){
            if($value->coordinateX===$x && $value->coordinateY===$y){
                switch ($value->cellState){
                    case Cell::EMPTY_CELL_STATE:
                        return HtmlHelper::EMPTY_CELL_CLASS_STRING;
                        break;
                    case Cell::SHIP_CELL_STATE:
                        return HtmlHelper::SHIP_CLASS_STRING;
                        break;
                    case Cell::HIT_CELL_STATE:
                        return HtmlHelper::BREAK_SHIP_CLASS_STRING;
                        break;
                    case Cell::MISS_CELL_STATE:
                        return HtmlHelper::MISS_CELL_CLASS_STRING;
                        break;
                }
            }
        }
    }

//    public static function loadFieldOneFromFile(){
//        $file=fopen("./task6/sea_battle/files/field_one.txt","r");
//        $result=json_decode(fread($file,
//            filesize("./task6/sea_battle/files/field_one.txt")));
//        fclose($file);
//        return $result;
//    }
//
//    public static function loadFieldTwoFromFile(){
//        $file=fopen("./task6/sea_battle/files/field_two.txt","r");
//        $result=json_decode(fread($file,
//            filesize("./task6/sea_battle/files/field_two.txt")));
//        fclose($file);
//        return $result;
//    }

}