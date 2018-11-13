<?php
/**
 * Created by PhpStorm.
 * User: Flatty
 * Date: 10.11.2018
 * Time: 11:01
 */

//namespace sea_battle;


class Cell
{
    /*
     * Состояние клетки поля показывает её числовое значение:
     * 0 = пустая клетка; 1 = клетка с кораблем или палубой корабля;
     * 2 = подбитый корабль или палуба; 3 = подбитая пустая клетка;
     */
    public $cellState;

    public function __construct()
    {
        $this->cellState=0;
    }
}