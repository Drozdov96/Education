<?php

//namespace sea_battle;
//TODO make separate function to work with DB.

class Field
{
    protected $fieldId;
    public $cellsArray;

    public function createField(int $gameId, int $ownerId)
    {
        $this->fieldId=DatabaseHelper::createField($gameId, $ownerId);
        $this->cellsArray=array();

        for($i=1;$i<=10;$i++)
        {
            for($j=1;$j<=10;$j++)
            {
                $this->cellsArray[]=new Cell(Cell::CREATE_ACTION,$i,$j, $this->fieldId);
            }
        }
    }

    public function loadField(int $fieldId)
    {
        $this->fieldId=$fieldId;

        $this->cellsArray=array();

        for($i=1;$i<=10;$i++)
        {
            for($j=1;$j<=10;$j++)
            {
                $this->cellsArray[]=new Cell(Cell::LOAD_ACTION, $i,$j, $this->fieldId);
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
                    $cell->setCellState(Cell::SHIP_CELL_STATE);
                }
            }
        }
    }

    public function setCellState(int $x, int $y, string $state)
    {
        foreach ($this->cellsArray as &$cell){
            if($cell->coordinateX===$x && $cell->coordinateY===$y){
                $cell->setCellState($state);
                return;
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

    public function getFieldId(): int
    {
        return $this->fieldId;
    }
}