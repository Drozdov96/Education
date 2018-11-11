<?php
/**
 * Created by PhpStorm.
 * User: Flatty
 * Date: 10.11.2018
 * Time: 19:33
 */

class Game
{
    private $steps;
    private $initialFieldOne;
    private $initialFieldTwo;

    public function __construct()
    {
        $this->steps=array();
        $this->initialFieldOne=new Field();
        $keysArray=Helper::convertStringToFieldArray($_SESSION['player_one_field']);
        $this->initialFieldOne->fillWithShips($keysArray);

        $this->initialFieldTwo=new Field();
        $keysArray=Helper::convertStringToFieldArray($_SESSION['player_two_field']);
        $this->initialFieldTwo->fillWithShips($keysArray);
    }

    public function addStep(string $x, string $y)
    {
        $step=[
            'x'=>$x,
            'y'=>$y
        ];
        array_push($this->steps, $step);
        var_dump($this->steps);
    }
}