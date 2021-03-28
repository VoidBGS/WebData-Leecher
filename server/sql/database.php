<?php 
    class SQL {
        
        public static function SaveDataRows($dataRows){
            require_once "./core/core.php";

            $query = $db->prepare('INSERT INTO dotabuff (hero, skill, role, outcome, lane, type, genre, length, kda) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $query->bindParam(1, $dataRows['hero']);
            $query->bindParam(2, $dataRows['skill']);
            $query->bindParam(3, $dataRows['role']);
            $query->bindParam(4, $dataRows['outcome']);
            $query->bindParam(5, $dataRows['lane']);
            $query->bindParam(6, $dataRows['type']);
            $query->bindParam(7, $dataRows['genre']);
            $query->bindParam(8, $dataRows['length']);
            $query->bindParam(9, $dataRows['kda']);
            $query->execute();
        }
    }
