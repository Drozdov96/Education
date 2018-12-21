<?php

class Field
{
    protected $fieldId;
    /**
     * @var array
     */
    public $cellsArray;
    /**
     * @var CellStateMachine
     */
    public $stateMachine;

    /**
     * @param int $gameId
     * @param int $ownerId
     */
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

        $this->stateMachine=new CellStateMachine(current($this->cellsArray));
    }

    /**
     * @param int $fieldId
     */
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

    /**
     * @param string $fieldString
     */
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

    /**
     * @param int $x
     * @param int $y
     * @param string $state
     */
    public function setCellState(int $x, int $y, string $state)
    {
        foreach ($this->cellsArray as &$cell){
            if($cell->coordinateX===$x && $cell->coordinateY===$y){
                $cell->setCellState($state);
                return;
            }
        }
    }

    /**
     * @param int $x
     * @param int $y
     * @return string
     */
    public function getCellState(int $x, int $y): string
    {
        foreach ($this->cellsArray as &$cell){
            if($cell->coordinateX===$x && $cell->coordinateY===$y){
                return $cell->cellState;
            }
        }
        return "";
    }

    /**
     * @return int
     */
    public function getFieldId(): int
    {
        return $this->fieldId;
    }
}