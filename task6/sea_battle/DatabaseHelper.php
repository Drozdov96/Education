<?php

class DatabaseHelper
{
    private static $dbc;

    public static function getConnection(){
        self::$dbc = new PDO("pgsql:host=/var/run/postgresql port=5432 
        dbname=battleship user=www-data");
    }

    public static function getPlayerIdFromDb(string $playerName): int
    {
        if(!isset(self::$dbc)){
            return false;
        }

        do{
            $query=self::$dbc->query("SELECT id FROM players WHERE 
              name='${playerName}'");
            $result=$query->fetch();
            if(empty($result)){
                self::$dbc->query("INSERT INTO players (name) 
              VALUES ('${playerName}')");
            }
        }while(empty($result));

        return $result['id'];
    }

    public static function createGame(int $idOne, int $idTwo)
    {
        if(!isset(self::$dbc)){
            return false;
        }

        self::$dbc->query("INSERT INTO games (player_one, player_two) 
              VALUES (".(string)$idOne.", ".(string)$idTwo.")");

        $query=self::$dbc->query("SELECT id FROM games WHERE
              player_one=".(string)$idOne."AND player_two= ".(string)$idTwo.
            "AND winner IS NULL AND end_timestamp IS NULL");
        $result=$query->fetch();

        return $result['id'];
    }


    public static function createField(int $gameId, int $ownerId)
    {
        if(!isset(self::$dbc)){
            return false;
        }

        self::$dbc->query("INSERT INTO fields (game_id, owner) 
              VALUES (".(string)$gameId.", ".(string)$ownerId.")");

        $query=self::$dbc->query("SELECT fields.id, games.player_one, 
        games.player_two FROM fields INNER JOIN games ON 
        fields.game_id=games.id WHERE fields.game_id=".(string)$gameId.
            "AND fields.owner= ".(string)$ownerId);
        $result=$query->fetch();

        switch ($ownerId){
            case $result['player_one']:
                self::$dbc->query("UPDATE games SET field_one=".$result['id'].
                    "WHERE id=".(string)$gameId);
                break;
            case $result['player_two']:
                self::$dbc->query("UPDATE games SET field_two=".$result['id'].
                    "WHERE id=".(string)$gameId);
                break;
            default:
                return false;
        }

        return $result['id'];
    }

    public static function createCell(int $fieldId, int $coordX,int $coordY,
                                      string $state)
    {
        if(!isset(self::$dbc)){
            return false;
        }

        self::$dbc->query("INSERT INTO cells (field, state, coordinate_x, 
        coordinate_y) VALUES (".(string)$fieldId.", '${state}', ".
            (string)$coordX.", ".(string)$coordY.")");

        $query=self::$dbc->query("SELECT id FROM cells WHERE field=".
            (string)$fieldId." AND coordinate_x=".(string)$coordX.
            " AND coordinate_y=".(string)$coordY);
        $result=$query->fetch();

        return $result['id'];
    }

    public static function loadGame(int $gameId): array
    {
        if(!isset(self::$dbc)){
            return false;
        }

        $query=self::$dbc->query("SELECT * FROM games WHERE id=".
            (string)$gameId);
        $result=$query->fetch();

        return $result;
    }

    public static function loadPlayer(int $playerId): string
    {
        if(!isset(self::$dbc)){
            return false;
        }

        $query=self::$dbc->query("SELECT name FROM games WHERE id=".
            (string)$playerId);
        $result=$query->fetch();

        return $result['name'];
    }

    public static function loadCell(int $fieldId, int $x, int $y)
    {
        if(!isset(self::$dbc)){
            return false;
        }

        $query=self::$dbc->query("SELECT * FROM cells WHERE field=".
            (string)$fieldId." AND coordinate_x=".(string)$x." AND coordinate_y=".(string)$y);
        $result=$query->fetch();

        return $result;
    }

    public static function changeCellState(int $cellId, string $state)
    {
        if(!isset(self::$dbc)){
            return false;
        }

        self::$dbc->query("UPDATE cells SET state='${state}' WHERE id=".
            (string)$cellId);
    }
}