<?php
/**
 * Created by PhpStorm.
 * User: Flatty
 * Date: 10.11.2018
 * Time: 10:57
 */

//namespace sea_battle;


class Field
{
    private $cellsArray;

    public function __construct()
    {
        $this->cellsArray=array();

        for($i=1;$i<=10;$i++)
        {
            for($j=1;$j<=10;$j++)
            {
                $this->cellsArray[$i][$j]=new Cell();
            }
        }
    }

    public function fillWithShips(array $ships)
    {
        foreach ($ships as $value)
        {
            $this->cellsArray[$value[0]][$value[1]]->setCellState(1);
        }
    }

}