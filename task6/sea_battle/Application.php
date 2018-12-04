<?php

//namespace sea_battle;


class Application
{
    protected $game;

    public function __construct(int $gameId)
    {
        DatabaseHelper::getConnection();

        //где лучше проверять на пустоту. уже в функции, или до того, как её дёрнуть
        if($gameId !== -1){
            $this->game=new Game();
            $this->game->loadGame($gameId);
        }
    }

    //TODO maybe refactor this
    protected function runPlacementPhase()
    {
        if(isset($_POST['submit_btn_place'])) {
            if($this->game->fieldEmpty(0)) {
                if (Helper::verifyInputFieldArray($_POST)){
                    $this->game->setField(0, Helper::convertFieldArrayToString($_POST));
                    //$_SESSION['game']=$this->game;
                    echo HtmlHelper::getShipsPlacementPage($this->game->playerTwo->playerName);
                }else{
                    echo HtmlHelper::getShipsPlacementPage($this->game->playerOne->playerName);
                }
            }else{
                if (Helper::verifyInputFieldArray($_POST)){
                    $this->game->setField(1, Helper::convertFieldArrayToString($_POST));
                    //$_SESSION['game']=$this->game;
                    header("Refresh:0; url=index.php?state=startGame");
                    exit;
                }else{
                    echo HtmlHelper::getShipsPlacementPage($this->game->playerTwo->playerName);
                }
            }
        }else{
            echo HtmlHelper::getShipsPlacementPage($this->game->playerOne->playerName);
        }
    }

    protected function createGame(string $playerOne, string $playerTwo)
    {
        $this->game=new Game();
        $this->game->createGame($playerOne, $playerTwo);
        //$_SESSION['game']=$this->game;
        header("Refresh:0; url=index.php?state=preparePhase");
        exit;
    }

    protected function runSetNamesPhase()
    {
        echo HtmlHelper::getPlayersNamePage();
    }

    protected function runGame()
    {
        $_SESSION['currentPlayerNum']=0;
        //$this->game->saveFieldsToFile();
//        for ($i=1; $i<=10;$i++){
//            for($j=1;$j<=10; $j++){
//                echo Helper::getFriendlyClass($i, $j, $this->game->getFieldOne())."<br>";
//            }
//        }
        //$_SESSION['game']=$this->game;
        echo HtmlHelper::getGamePage($this->game->playerOne->playerName,
            $this->game->getFieldOne(), $this->game->getFieldTwo());
    }

    protected function doStep(string $x, string $y,  int $currentPlayerNum)
    {
        //Доработать вывод, функция возвращает текущего игрока.
        $_SESSION['currentPlayerNum']=$this->game->
        doStep($x, $y, $currentPlayerNum);

        if($this->game->checkEndGame($_SESSION['currentPlayerNum'])){
            unset($_SESSION['gameId']);
            if($_SESSION['currentPlayerNum']===0){
                echo HtmlHelper::getEndGamePage($this->game->playerOne->playerName);
            }else{
                echo HtmlHelper::getEndGamePage($this->game->playerTwo->playerName);
            }
        }elseif($_SESSION['currentPlayerNum']===0){
            echo HtmlHelper::getGamePage($this->game->playerOne->playerName,
                $this->game->getFieldOne(), $this->game->getFieldTwo());
        }else{
            echo HtmlHelper::getGamePage($this->game->playerTwo->playerName,
                $this->game->getFieldTwo(),$this->game->getFieldOne());
        }
    }

    //можно ли не ставить жесткую типизацию
    public function doRoute(string $state)
    {
        switch ($state){
            case 'preparePhase':
                $this->runPlacementPhase();
                break;
            case 'startGame':
                $this->runGame();
                break;
            case 'doStep':
                $this->doStep($_GET['x'], $_GET['y'], $_SESSION['currentPlayerNum']);
                unset($_GET['x'], $_GET['y']);
                break;
            case 'setNames':
                $this->createGame($_POST['playerOneName'], $_POST['playerTwoName']);
                break;
            default:
                $this->runSetNamesPhase();
        }
    }

//    public function setGame(Game $game)
//    {
//        $this->game=$game;
//    }

}