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

    //можно ли не ставить жесткую типизаци
    public function doRoute(string $state)
    {
        switch ($state){
            case 'preparePhase':
                $this->runPreparePhase();
                break;
            case 'startGame':
                $this->runGame($_SESSION['player_one_field'], $_SESSION['player_two_field']);
                unset($_SESSION['player_one_field'],$_SESSION['player_two_field']);
                break;
            case 'doStep':
                $this->doStep($_GET['x'], $_GET['y'], $_SESSION['currentPlayerNum']);
                unset($_GET['x'], $_GET['y']);
                break;
            default:
                $this->runPreparePhase();
        }
    }

}