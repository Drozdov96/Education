<?php

class Helper
{
//    public static function showPrepareView()
//    {
//        require_once("../code/task6/prepareUI.php");
//    }

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
                if(!empty($fieldArray[(string)$i.'-'.(string)$j]) && $fieldArray[(string)$i.'-'.(string)$j]==='ship') {
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
        if($fieldArray[(string)($x+1).'-'.(string)($y)]==='ship'){
            $x+=1;
        }elseif ($fieldArray[(string)($x-1).'-'.(string)($y)]==='ship'){
            $x-=1;
        }elseif ($fieldArray[(string)($x).'-'.(string)($y+1)]==='ship'){
            $y+=1;
        }elseif ($fieldArray[(string)($x).'-'.(string)($y-1)]==='ship') {
            $y-=1;
        }
    }

    public static function checkNearShipsNum(int $x,int $y,array $fieldArray): int
    {
        $resultNum=0;
        if($fieldArray[(string)($x+1).'-'.(string)($y)]==='ship'){
            $resultNum++;
        }
        if ($fieldArray[(string)($x-1).'-'.(string)($y)]==='ship'){
            $resultNum++;
        }
        if ($fieldArray[(string)($x).'-'.(string)($y+1)]==='ship'){
            $resultNum++;
        }
        if ($fieldArray[(string)($x).'-'.(string)($y-1)]==='ship') {
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
                    case 'hit     ': return "breakShipCell";
                        break;
                    case 'miss    ': return "emptyCell";
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
                    case 'empty   ':
                        return "emptyCell";
                        break;
                    case 'ship    ':
                        return "ship";
                        break;
                    case 'hit     ':
                        return "breakShipCell";
                        break;
                    case 'miss    ':
                        return "miss";
                        break;
                }
            }
        }
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