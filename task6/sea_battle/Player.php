<?php

class Player
{
    protected $playerId;
    public $playerName;

    public function __construct(string $playerName)
    {
        $this->playerName=$playerName;
        DatabaseHelper::getPlayerIdFromDb($playerName);
    }
}