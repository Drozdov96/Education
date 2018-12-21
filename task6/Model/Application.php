<?php

class Application
{
    protected $game;
    public const NEW_GAME_NUM=-1;

    /**
     * Application constructor.
     * @param int $gameId
     */
    public function __construct(int $gameId)
    {
        DatabaseHelper::getConnection();

        //где лучше проверять на пустоту. уже в функции, или до того, как её дёрнуть
        if($gameId !== self::NEW_GAME_NUM){
            $this->game=new Game();
            $this->game->loadGame($gameId);
        }
    }

    protected function runPlacementPhase()
    {
        if(isset($_POST['submit_btn_place'])) {
            if($this->game->fieldEmpty(Game::FIELD_ONE_NUM)) {
                if (Helper::verifyInputFieldArray($_POST)){
                    $this->game->setField(Game::FIELD_ONE_NUM, Helper::convertFieldArrayToString($_POST));
                    echo HtmlHelper::getShipsPlacementPage($this->game->playerTwo->playerName);
                }else{
                    echo HtmlHelper::getShipsPlacementPage($this->game->playerOne->playerName);
                }
            }else{
                if (Helper::verifyInputFieldArray($_POST)){
                    $this->game->setField(Game::FIELD_TWO_NUM, Helper::convertFieldArrayToString($_POST));
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
        header("Refresh:0; url=index.php?state=preparePhase");
        exit;
    }

    protected function runSetNamesPhase()
    {
        echo HtmlHelper::getPlayersNamePage();
    }

    protected function runGame()
    {
        $_SESSION['currentPlayerNum']=Game::PLAYER_ONE_NUM;
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
            if($_SESSION['currentPlayerNum']===Game::PLAYER_ONE_NUM){
                echo HtmlHelper::getEndGamePage($this->game->playerOne->playerName);
            }else{
                echo HtmlHelper::getEndGamePage($this->game->playerTwo->playerName);
            }
        }elseif($_SESSION['currentPlayerNum']===Game::PLAYER_ONE_NUM){
            echo HtmlHelper::getGamePage($this->game->playerOne->playerName,
                $this->game->getFieldOne(), $this->game->getFieldTwo());
        }else{
            echo HtmlHelper::getGamePage($this->game->playerTwo->playerName,
                $this->game->getFieldTwo(),$this->game->getFieldOne());
        }
    }

    /**
     * @param string $state
     */
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
}