<?php
/**
 * Created by PhpStorm.
 * User: Flatty
 * Date: 10.11.2018
 * Time: 10:46
 */

//namespace sea_battle;


class Application
{
    private $game;

    public function runPreparePhase()
    {
        Helper::showPrepareView();
    }

    public function runGame(string $fieldOne, string $fieldTwo)
    {
        $this->game=new Game($fieldOne, $fieldTwo);
        $_SESSION['currentPlayerNum']=0;
        $this->game->saveFieldsToFile();
        $_SESSION['app']=$this;
        Helper::showGameView();
    }

    public function doStep(string $x, string $y,  int $currentPlayerNum)
    {
        //Доработать вывод, функция возвращает текущего игрока.
        $_SESSION['currentPlayerNum']=$this->game->
        doStep($x, $y, $currentPlayerNum);
        $this->game->saveFieldsToFile();
        $_SESSION['app']=$this;
        Helper::showGameView();
    }

    public function getPlayerFieldOne()
    {
        return $this->game->getFieldOne();
    }

    public function getPlayerFieldTwo()
    {
        return $this->game->getFieldTwo();
    }
}