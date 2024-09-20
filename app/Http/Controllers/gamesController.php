<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Games;
use App\Repositories\GameRepository ;
use Illuminate\Support\Arr;

class gamesController extends Controller
{
    public function addGame(){
        $gameRepo=new GameRepository;
        $gameRepo->addGame($_POST['gameName'],$_POST['gameDev'],$_POST['gameGenres']);

        return "Игра добавлена";
    }

    public function getGame(){
       
        $gameRepo=new GameRepository;
        if(ctype_digit($_GET['id']) && $gameRepo->checkId($_GET['id'])){
            return $gameRepo->getFullINfoById($_GET['id']);
        }
        else{
            $respArr=['response'=>"Введите корректный id"];
            return json_encode($respArr);
        }

    }

    public function delGame(){
        $gameRepo=new GameRepository;
        if(ctype_digit($_POST['id']) && $gameRepo->checkId($_POST['id'])){
            $gameRepo->delById($_POST['id']);
            return "Игра удалена";
        }
        else{
            return "Введите корректный id";
        }
        
    }

    public function changeGame(){
        
        $gameRepo=new GameRepository;
        if(ctype_digit($_GET['id']) && $gameRepo->checkId($_GET['gameId'])){
            $gameRepo->updateGame($_POST['gameId'],$_POST['gameName'],$_POST['gameDev'],$_POST['gameGenres']);
            $respArr=['response'=>"Игра изменена"];
            return json_encode($respArr);
        }
        else{
            $respArr=['response'=>"Введите корректный id"];
            return json_encode($respArr);
        }
    
    }

    public function getGamesByGenre(){
        $gameRepo=new GameRepository;
        return $gameRepo->getGamesByGenre($_GET['genre']);


        
    }
}
