<?php

class Game
{
    protected $gameId;
    protected $steps;
    /**
     * @var Field
     */
    protected $fieldOne;
    /**
     * @var Field
     */
    protected $fieldTwo;
    /**
     * @var Player
     */
    public $playerOne;
    /**
     * @var Player
     */
    public $playerTwo;

    public const FIELD_ONE_NUM=0;
    public const FIELD_TWO_NUM=1;
    public const PLAYER_ONE_NUM=0;
    public const PLAYER_TWO_NUM=1;

    /**
     * @param string $playerOne
     * @param string $playerTwo
     */
    public function createGame(string $playerOne, string $playerTwo)
    {
        $this->steps=array();
        $this->playerOne=new Player();
        $this->playerTwo=new Player();
        $this->playerOne->setPlayer($playerOne);
        $this->playerTwo->setPlayer($playerTwo);
        $idOne=$this->playerOne->getPlayerId();
        $idTwo=$this->playerTwo->getPlayerId();

        $this->gameId=DatabaseHelper::createGame($idOne, $idTwo);
        $_SESSION['gameId']=$this->gameId;
    }

    /**
     * @param int $fieldNum
     * @param string $field
     */
    public function setField(int $fieldNum, string $field)
    {
        if($fieldNum===self::FIELD_ONE_NUM){
            $this->fieldOne=new Field();
            $this->fieldOne->createField($this->gameId,$this->playerOne->
            getPlayerId());
            $this->fieldOne->fillWithShips($field);
        }else{
            $this->fieldTwo=new Field();
            $this->fieldTwo->createField($this->gameId,$this->playerTwo->
            getPlayerId());
            $this->fieldTwo->fillWithShips($field);
        }
    }

    /**
     * @return array
     */
    public function getFieldOne()
    {
        return $this->fieldOne->cellsArray;
    }

    /**
     * @return array
     */
    public function getFieldTwo()
    {
        return $this->fieldTwo->cellsArray;
    }

    /**
     * @param int $fieldNum
     * @return bool
     */
    public function fieldEmpty(int $fieldNum): bool
    {
        if($fieldNum===self::FIELD_ONE_NUM){
            return empty($this->fieldOne);
        }else{
            return empty($this->fieldTwo);
        }
    }

    /*
     * Функция обрабатывает ход игрока, делает соответствующие изменения в полях и возвращает
     * игрока, который будет делать следующий ход.
     */
    /**
     * @param string $x
     * @param string $y
     * @param int $currentPlayerNum
     * @return int
     */
    public function doStep(string $x, string $y, int $currentPlayerNum)
    {
        if($currentPlayerNum===self::PLAYER_ONE_NUM){
            switch($this->fieldTwo->getCellState((int)$x,(int)$y)) {
                case Cell::EMPTY_CELL_STATE: $this->fieldTwo->setCellState((int)$x,(int)$y, Cell::MISS_CELL_STATE);
                    $currentPlayerNum=self::FIELD_TWO_NUM;
                    break;
                case Cell::SHIP_CELL_STATE: $this->fieldTwo->setCellState((int)$x,(int)$y, Cell::HIT_CELL_STATE);
                    break;
            }
        }else{
            switch($this->fieldOne->getCellState((int)$x,(int)$y)) {
                case Cell::EMPTY_CELL_STATE: $this->fieldOne->setCellState((int)$x,(int)$y, Cell::MISS_CELL_STATE);
                    $currentPlayerNum=self::PLAYER_ONE_NUM;
                    break;
                case Cell::SHIP_CELL_STATE: $this->fieldOne->setCellState((int)$x,(int)$y, Cell::MISS_CELL_STATE);
                    break;
            }
        }
        return $currentPlayerNum;
    }

    /**
     * @param int $gameId
     */
    public function loadGame(int $gameId)
    {
        $this->gameId=$gameId;
        $gameArray=DatabaseHelper::loadGame($gameId);

        $this->playerOne=new Player();
        $this->playerOne->loadPlayer($gameArray['player_one']);
        $this->playerTwo=new Player();
        $this->playerTwo->loadPlayer($gameArray['player_two']);

        if(!empty($gameArray['field_one'])){
            $this->fieldOne=new Field();
            $this->fieldOne->loadField($gameArray['field_one']);
        }
        if(!empty($gameArray['field_two'])){
            $this->fieldTwo=new Field();
            $this->fieldTwo->loadField($gameArray['field_two']);
        }
    }

    /**
     * @param int $currentPlayer
     * @return bool
     */
    public function checkEndGame(int $currentPlayer): bool
    {
        if($currentPlayer===self::PLAYER_ONE_NUM){
            if(DatabaseHelper::getShipsNum($this->fieldTwo->getFieldId())===0) {
                DatabaseHelper::setWinnerAndTime($this->playerOne->getPlayerId(),
                    $this->gameId);
                return true;
            }
        }else {
            if (DatabaseHelper::getShipsNum($this->fieldOne->getFieldId()) === 0) {
                DatabaseHelper::setWinnerAndTime($this->playerTwo->getPlayerId(),
                    $this->gameId);
                return true;
            }
        }
        return false;
    }
}