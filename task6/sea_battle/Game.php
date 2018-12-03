<?php

class Game
{
    protected $gameId;
    protected $steps;
    protected $fieldOne;
    protected $fieldTwo;
    public $playerOne;
    public $playerTwo;

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
        if($fieldNum===0){
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
        if($fieldNum===0){
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

        if($currentPlayerNum===0){
            switch($this->fieldTwo->getCellState((int)$x,(int)$y)) {
                case 'empty   ': $this->fieldTwo->setCellState((int)$x,(int)$y, 'miss    ');
                    $currentPlayerNum=1;
                    break;
                case 'ship    ': $this->fieldTwo->setCellState((int)$x,(int)$y, 'hit     ');
                    break;
            }
        }else{
            switch($this->fieldOne->getCellState((int)$x,(int)$y)) {
                case 'empty   ': $this->fieldOne->setCellState((int)$x,(int)$y, 'miss    ');
                    $currentPlayerNum=0;
                    break;
                case 'ship    ': $this->fieldOne->setCellState((int)$x,(int)$y, 'hit     ');
                    break;
            }
        }
        return $currentPlayerNum;
    }

    public function saveFieldsToFile()
    {
        $json=$this->fieldOne->convertCellsArrayToJson();
        $fileOne=fopen("./task6/sea_battle/files/field_one.txt","w");
        fwrite($fileOne, $json);
        fclose($fileOne);

        $json=$this->fieldTwo->convertCellsArrayToJson();
        $fileTwo=fopen("./task6/sea_battle/files/field_two.txt","w");
        fwrite($fileTwo, $json);
        fclose($fileTwo);
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
}