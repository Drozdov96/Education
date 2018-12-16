<?php

class Cell
{
    /*
     * Состояние клетки поля показывает её числовое значение:
     *
     * empty= пустая клетка;
     * ship= клетка с кораблём;
     * hit= клетка в которую выстрелили и попали по кораблю;
     * miss= клетка в которую выстрелили и попали в пустую клетку;
     */
    protected $cellId;
    public $cellState;
    public $coordinateX;
    public $coordinateY;

    //пробелы добавлены из-за особенности хранения этого поля в базе данных
    public const EMPTY_CELL_STATE='empty   ';
    public const SHIP_CELL_STATE='ship    ';
    public const HIT_CELL_STATE='hit     ';
    public const MISS_CELL_STATE='miss    ';
    public const CREATE_ACTION='create';
    public const LOAD_ACTION='load';

    public function __construct(string $action, int $x, int $y, int $fieldId){

        $this->coordinateX=$x;
        $this->coordinateY=$y;
        switch ($action){
            case CREATE_ACTION:
                $this->cellState=EMPTY_CELL_STATE;
                $this->cellId=DatabaseHelper::createCell($fieldId, $x, $y,
                    $this->cellState);
                break;
            case LOAD_ACTION:
                $cellParamsArray=DatabaseHelper::loadCell($fieldId, $x, $y);
                $this->cellId=$cellParamsArray['id'];
                $this->cellState=$cellParamsArray['state'];
                break;
        }
    }

    public function setCellState(string $state)
    {
        $this->cellState=$state;
        DatabaseHelper::changeCellState($this->cellId, $this->cellState);
    }
}