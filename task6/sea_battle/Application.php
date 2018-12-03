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
    protected $game;

    public function __construct($gameId)
    {
        //где лучше проверять на пустоту. уже в функции, или до того, как её дёрнуть
        if(!empty($game)){
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
        //$_SESSION['game']=$this->game;
        echo HtmlHelper::getGamePage($_SESSION['currentPlayerNum']===0?
            $this->game->playerOne->playerName: $this->game->playerTwo->playerName);
    }

    protected function doStep(string $x, string $y,  int $currentPlayerNum)
    {
        //Доработать вывод, функция возвращает текущего игрока.
        $_SESSION['currentPlayerNum']=$this->game->
        doStep($x, $y, $currentPlayerNum);
        //$this->game->saveFieldsToFile();
        //$_SESSION['game']=$this->game;
        echo HtmlHelper::getGamePage($_SESSION['currentPlayerNum']===0?
            $this->game->playerOne->playerName: $this->game->playerTwo->playerName);
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