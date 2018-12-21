<?php

class Player
{
    protected $playerId;
    /**
     * @var string
     */
    public $playerName;


    /**
     * @param $playerName
     */
    public function setPlayer(string $playerName)
    {
        $this->playerName=$playerName;
        $this->playerId=DatabaseHelper::getPlayerIdFromDb($playerName);
    }

    /**
     * @param int $playerId
     */
    public function loadPlayer(int $playerId)
    {
        $this->playerId=$playerId;
        $this->playerName=DatabaseHelper::loadPlayer($playerId);
    }

    /**
     * @return int
     */
    public function getPlayerId(): int
    {
        return $this->playerId;
    }
}