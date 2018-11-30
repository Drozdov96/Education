<?php

//namespace sea_battle;


class Field
{
    public $cellsArray;

    public function __construct()
    {
        $this->cellsArray=array();

        for($i=1;$i<=10;$i++)
        {
            for($j=1;$j<=10;$j++)
            {
                $this->cellsArray[]=new Cell($i,$j);
            }
        }
    }

    public function fillWithShips(string $fieldString)
    {
        $ships=Helper::convertStringToFieldArray($fieldString);

        foreach ($ships as $value)
        {
            foreach ($this->cellsArray as &$cell){
                reset($value);
                if($cell->coordinateX===(int)current($value) &&
                    $cell->coordinateY===(int)next($value)){
                    $cell->cellState='ship';
                }
            }
        }
    }

    public function setCellState(int $x, int $y, string $state)
    {
        foreach ($this->cellsArray as &$cell){
            if($cell->coordinateX===$x && $cell->coordinateY===$y){
                $cell->cellState=$state;
            }
        }
    }

    public function getCellState(int $x, int $y): string
    {
        foreach ($this->cellsArray as &$cell){
            if($cell->coordinateX===$x && $cell->coordinateY===$y){
                return $cell->cellState;
            }
        }
        return "";
    }

    public function convertCellsArrayToJson() : string
    {
        return json_encode($this->cellsArray);
    }
}