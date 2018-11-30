<?php

class DatabaseHelper
{
    private static $dbc;

    public static function getConnection(){
        self::$dbc = new PDO("pgsql:host=/var/run/postgresql port=5432 
        dbname=battleship user=www-data");
    }

    public static function getPlayerIdFromDb(string $playerName)
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
}