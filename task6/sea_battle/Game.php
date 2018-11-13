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
    protected $FieldOne;
    protected $FieldTwo;

    public function __construct(string $fieldOne, string $fieldTwo)
    {
        $this->steps=array();
        $this->FieldOne=new Field();
        $keysArray=Helper::convertStringToFieldArray($fieldOne);
        $this->FieldOne->fillWithShips($keysArray);

        $this->FieldTwo=new Field();
        $keysArray=Helper::convertStringToFieldArray($fieldTwo);
        $this->FieldTwo->fillWithShips($keysArray);
    }

    public function doStep(string $x, string $y, int $currentPlayerNum)
    {
        $step=[
            'x'=>$x,
            'y'=>$y,
            'playerNum'=>$currentPlayerNum
        ];
        array_push($this->steps, $step);

        if($currentPlayerNum===0){
            switch($this->FieldTwo->getCellState()) {
                case 0: $this->FieldTwo->setCellState((int)$x,(int)$y, 3);
                    $currentPlayerNum=1;
                    break;
                case 1: $this->FieldTwo->setCellState((int)$x,(int)$y, 2);
                    break;
            }
        }else{
            switch($this->FieldOne->getCellState()) {
                case 0: $this->FieldOne->setCellState((int)$x,(int)$y, 3);
                    $currentPlayerNum=0;
                    break;
                case 1: $this->FieldOne->setCellState((int)$x,(int)$y, 2);
                    break;
            }
        }
        return $currentPlayerNum;
    }

    public function getFieldOne()
    {
        return $this->FieldOne;
    }

    public function getFieldTwo()
    {
        return $this->FieldTwo;
    }
}