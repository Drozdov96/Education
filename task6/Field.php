<?php
/**
 * Created by PhpStorm.
 * User: Flatty
 * Date: 10.11.2018
 * Time: 10:57
 */

namespace sea_battle;


class Field
{
    private $cellsArray;

    public function __construct()
    {
        $cellsArray=array();

        for($i=1;$i<=10;$i++)
        {
            for($j=1;$j<=10;$j++)
            {
                $cellsArray[$i][$j]=new Cell();
            }
        }
    }
}