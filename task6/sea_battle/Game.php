<?php

class Game
{
    protected $gameId;
    protected $steps;
    protected $fieldOne;
    protected $fieldTwo;
    public $playerOne;
    public $playerTwo;

    public const FIELD_ONE_NUM=0;
    public const FIELD_TWO_NUM=1;
    public const PLAYER_ONE_NUM=0;
    public const PLAYER_TWO_NUM=1;

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

    //TODO refactor this method.
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

    public function getFieldOne()
    {
        return $this->fieldOne->cellsArray;
    }

    public function getFieldTwo()
    {
        return $this->fieldTwo->cellsArray;
    }

    //TODO discover usefulness of this function
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
    public function doStep(string $x, string $y, int $currentPlayerNum)
    {
//        $step=[
//            'x'=>$x,
//            'y'=>$y,
//            'playerNum'=>$currentPlayerNum
//        ];
//        array_push($this->steps, $step);

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