<?php 
namespace app\Repositories;

use App\Models\Games;
use App\Models\GameGenres;

class GAmeRepository{

    function checkId($id){
        if (Games::where('id', '=', $id)->exists()) {
           return true;
        }
        else{
            return false;
        }
    }
    function getFullINfoById($gameId){
        $gameResult=Games::find($gameId);
        $genreResult=GameGenres::where('gameId',$gameId)->get();
        
        $result=['gameInfo'=>$gameResult, 'genreInfo'=>$genreResult];

        return json_encode($result);
    }
    function delById($gameId){
        return Games::find($gameId)->delete();
    }
    function addGame($name,$dev,$genres){

        $game=new Games;
        $game->gameName=$name;
        $game->gameDev=$dev;

        $game->save();
        $createdId=$game->id;

        foreach ($genres as $genre) {
            $gameGenre=new GameGenres;
            $gameGenre->gameId=$createdId;
            $gameGenre->genre=$genre;

            $gameGenre->save();
        }
    }
    function updateGame($gameId, $name, $dev, $genres){
        $game= Games::find($gameId);

        $game->gameName=$name;
        $game->gameDev=$dev;
        $game->save();

        $res=GameGenres::where("gameId",$gameId)->delete();

        foreach ($genres as $genre) {
            $gameGenre=new GameGenres;
            $gameGenre->gameId=$gameId;
            $gameGenre->genre=$genre;

            $gameGenre->save();
        }

    }
    function getGamesByGenre($genre){
        return Games::join('gameGenres','games.id','=','gameGenres.gameId')->where('genre','=',$genre)->get()->toJson()  ;
    }
}