<?php
/**
 * Created by PhpStorm.
 * User: Flatty
 * Date: 10.11.2018
 * Time: 19:33
 */

class Game
{
    protected $steps;
    protected $fieldOne;
    protected $fieldTwo;
    public $playerOne;
    public $playerTwo;

    public function __construct(string $playerOne, string $playerTwo)
    {
        $this->playerOne=$playerOne;
        $this->playerTwo=$playerTwo;
    }

    public function startGame()
    {
        $this->steps=array();
//        $this->FieldOne=new Field();
//        $this->FieldOne->fillWithShips($fieldOne);
//
//        $this->FieldTwo=new Field();
//        $this->FieldTwo->fillWithShips($fieldTwo);
    }

    public function setField(int $fieldNum, string $field)
    {
        if($fieldNum===0){
            $this->fieldOne=new Field();
            $this->fieldOne->fillWithShips($field);
        }else{
            $this->fieldTwo=new Field();
            $this->fieldTwo->fillWithShips($field);
        }
    }

    public function fieldEmpty(int $fieldNum)
    {
        if($fieldNum===0){
            return !empty($this->fieldOne);
        }else{
            return !empty($this->fieldTwo);
        }
    }

        /*
         * Функция обрабатывает ход игрока, делает соответствующие изменения в полях и возвращает
         * игрока, который будет делать следующий ход.
         */
    public function doStep(string $x, string $y, int $currentPlayerNum)
    {
        $step=[
            'x'=>$x,
            'y'=>$y,
            'playerNum'=>$currentPlayerNum
        ];
        array_push($this->steps, $step);

        if($currentPlayerNum===0){
            switch($this->fieldTwo->getCellState((int)$x,(int)$y)) {
                case 'empty': $this->fieldTwo->setCellState((int)$x,(int)$y, 'miss');
                    $currentPlayerNum=1;
                    break;
                case 'ship': $this->fieldTwo->setCellState((int)$x,(int)$y, 'hit');
                    break;
            }
        }else{
            switch($this->fieldOne->getCellState((int)$x,(int)$y)) {
                case 'empty': $this->fieldOne->setCellState((int)$x,(int)$y, 'miss');
                    $currentPlayerNum=0;
                    break;
                case 'ship': $this->fieldOne->setCellState((int)$x,(int)$y, 'hit');
                    break;
            }
        }
        return $currentPlayerNum;
    }

    public function saveFieldsToFile()
    {
        $json=$this->fieldOne->convertCellsArrayToJson();
        $fileOne=fopen("./task6/sea_battle/files/field_one.txt","w");
        fwrite($fileOne, $json);
        fclose($fileOne);

        $json=$this->fieldTwo->convertCellsArrayToJson();
        $fileTwo=fopen("./task6/sea_battle/files/field_two.txt","w");
        fwrite($fileTwo, $json);
        fclose($fileTwo);
    }
}