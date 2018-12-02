<?php

class Player
{
    protected $playerId;
    public $playerName;

    public function __construct(string $playerName)
    {
        $this->playerName=$playerName;
        $this->playerId=DatabaseHelper::getPlayerIdFromDb($playerName);
    }

    public function getPlayerId(): int
    {
        return $this->playerId;
    }
}