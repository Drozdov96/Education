<?php

class Controller
{
    public function doRoute()
    {
        if(!empty($_SESSION['app'])) {

            $app=$_SESSION['app'];
        }else{
            $app= new Application;
        }

        switch ($_GET['state']){
            case 'preparePhase':
                $app->runPreparePhase();
                break;
            case 'startGame':
                $app->runGame($_SESSION['player_one_field'], $_SESSION['player_two_field']);
                unset($_SESSION['player_one_field'],$_SESSION['player_two_field']);
                break;
            case 'doStep':
                $app->doStep($_GET['x'], $_GET['y'], $_SESSION['currentPlayerNum']);
                unset($_GET['x'], $_GET['y']);
                break;
            default:
                $app->runPreparePhase();
        }
    }
}