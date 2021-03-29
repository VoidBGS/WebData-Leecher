<?php 
    abstract class SQL {
        
        public static function SaveDataRows($dataRow){
            require "./core/core.php";
            $extractedVars = [
                'hero'    => $dataRow->GetHero(),
                'skill'   => $dataRow->GetSkill(),
                'role'    => $dataRow->GetRole(),
                'outcome' => $dataRow->GetOutcome() == 'Win' ? "1" : "0",
                'lane'    => $dataRow->GetLane(),
                'type'    => $dataRow->GetType(),
                'genre'   => $dataRow->GetGenre(),
                'length'  => $dataRow->GetLength(), 
                'kda'     => $dataRow->GetKDA()
            ];

            $query = $db->prepare('INSERT INTO dotabuff (hero, skill, role, outcome, lane, type, genre, length, kda) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $query->bindParam(1, $extractedVars['hero']);
            $query->bindParam(2, $extractedVars['skill']);
            $query->bindParam(3, $extractedVars['role']);
            $query->bindParam(4, $extractedVars['outcome']);
            $query->bindParam(5, $extractedVars['lane']);
            $query->bindParam(6, $extractedVars['type']);
            $query->bindParam(7, $extractedVars['genre']);
            $query->bindParam(8, $extractedVars['length']);
            $query->bindParam(9, $extractedVars['kda']);
            $query->execute();
        }
    }
