<?php

class Player
{
    protected $playerId;
    public $playerName;


    public function setPlayer($playerName)
    {
        $this->playerName=$playerName;
        $this->playerId=DatabaseHelper::getPlayerIdFromDb($playerName);
    }

    public function loadPlayer($playerId)
    {
        $this->playerId=$playerId;
        $this->playerName=DatabaseHelper::loadPlayer($playerId);
    }

    public function getPlayerId(): int
    {
        return $this->playerId;
    }
}