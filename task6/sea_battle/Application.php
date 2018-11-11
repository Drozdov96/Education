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

    public function run()
    {
        $this->game=new Game();
        Helper::showGameView();
    }

    public function addStep(string $x, string $y)
    {
        $this->game->addStep($x, $y);
    }
}