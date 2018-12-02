<?php

//namespace sea_battle;


class Cell
{
    /*
     * Состояние клетки поля показывает её числовое значение:
     * 0 = пустая клетка; 1 = клетка с кораблем или палубой корабля;
     * 2 = подбитый корабль или палуба; 3 = подбитая пустая клетка;
     * empty= пустая клетка; ship= клетка с кораблём;
     * hit= клетка в которую выстрелили и попали по кораблю;
     * miss= клетка в которую выстрелили и попали в пустую клетку;
     */
    public $cellId;
    public $cellState;
    public $coordinateX;
    public $coordinateY;

    public function __construct(int $x, int $y, int $fieldId)
    {
        $this->cellState='empty';
        $this->coordinateX=$x;
        $this->coordinateY=$y;
        $this->cellId=DatabaseHelper::createCell($fieldId, $x, $y,
            $this->cellState);
    }
}