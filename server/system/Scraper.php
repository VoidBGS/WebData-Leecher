<?php
require_once "./models/DataRowModel.php";
require_once "./system/Helper.php";
require_once "./system/HttpUser.php";
require_once "./enums/Genre.php";

class Scraper
{

    private $dataRows = [];

    public function TraverseDOM()
    {
        for ($i = 1; $i < 5; $i++) {
            $user = new HttpUser();
            $response = $user->Request("https://www.dotabuff.com/players/66296404/matches?enhance=overview&page=" . $i);
            $cleanPage = Helper::CleanInitialPage($response);
            $seperatedRows = Helper::SeperateTables($cleanPage);

            $this->ExtractDataRows($seperatedRows);
        }

        echo (json_encode($this->dataRows));
    }

    private function ExtractDataRows($seperatedRows)
    {
        for ($i = 1; $i < count($seperatedRows); $i++) {
            $currentRow = $seperatedRows[$i];

            $hero    = $this->GetHeroName($currentRow);
            $skill   = $this->GetSkillLevel($currentRow);
            $role    = $this->GetHeroRole($currentRow);
            $outcome = $this->GetGameOutcome($currentRow);
            $lane    = $this->GetHeroLane($currentRow);
            $type    = $this->GetGameType($currentRow);
            $genre   = $this->GetGameGenre($currentRow);
            $length  = $this->GetGameLength($currentRow);
            $kda     = $this->GetKDARecord($currentRow);

            $dataRow = new DataRowModel();

            isset($hero)    ? $dataRow->SetHero($hero)       : $dataRow->SetHero(NULL);
            isset($skill)   ? $dataRow->SetSkill($skill)     : $dataRow->SetSkill(NULL);
            isset($role)    ? $dataRow->SetRole($role)       : $dataRow->SetRole(NULL);
            isset($outcome) ? $dataRow->SetOutcome($outcome) : $dataRow->SetOutcome(NULL);
            isset($lane)    ? $dataRow->SetLane($lane)       : $dataRow->SetLane(NULL);
            isset($type)    ? $dataRow->SetType($type)       : $dataRow->SetType(NULL);
            isset($genre)   ? $dataRow->SetGenre($genre)     : $dataRow->SetGenre(NULL);
            isset($length)  ? $dataRow->SetLength($length)   : $dataRow->SetLength(NULL);
            isset($kda)     ? $dataRow->SetKDA($kda)         : $dataRow->SetKDA(NULL);

            array_push($this->dataRows, $dataRow);
        }
    }

    private function GetSkillLevel($string)
    {
        $skillLevel = Helper::get_string_between($string, '<div class="subtext">',  '<div class="grouped-icons r-only-mobile">');

        return $skillLevel;
    }
    private function GetHeroName($string)
    {
        $heroName = Helper::get_string_between($string, 'data-tooltip-url="/heroes/', '/tooltip"');

        return $heroName;
    }
    private function GetHeroRole($string)
    {
        $role = Helper::get_string_between($string, 'fa-role-', ' fa-fw role-icon');

        return $role;
    }
    private function GetHeroLane($string)
    {
        $lane = Helper::get_string_between($string, 'fa-lane-', ' fa-fw lane-icon');

        return $lane;
    }
    private function GetGameOutcome($string)
    {
        $outcome = "TBD";

        !empty(strstr($string, 'Won')) ? $outcome = "Win" : $outcome = "Loss";

        return $outcome;
    }
    private function GetGameType($string)
    {
        $type = "TBD";

        !empty(strstr($string, 'Normal')) ? $type = "Normal" : $type = "Ranked";

        return $type;
    }
    private function GetGameGenre($string)
    {
        $genres = Genre::GENRES;
        $genre = '';
        for ($i = 0; $i < count($genres); $i++) {
            if (!empty(strstr($string, $genres[$i]))) {
                $genre = $genres[$i];
                break;
            }
        }

        return $genre;
    }
    private function GetGameLength($string)
    {
        $length = Helper::get_string_between($string, '</div></td><td>', '<div class="bar bar-default"><div class="segment');

        return $length;
    }
    private function GetKDARecord($string)
    {
        //KDA = (kills + assists)/ deaths
        $htmlTree = Helper::get_string_between($string, '<span class="kda-record">', '</span></span>');
        $extract = explode('<span class="value">', $htmlTree);
        $kda = $this->CalcKDA(trim($extract[1], "</span>"), trim($extract[2], "</span>"), $extract[3]);

        return $kda;
    }

    private function CalcKDA($kills, $deaths, $assists)
    {
        //Can't divide by 0.
        if($deaths == 0) return $kda = round($kills + $assists, 2);

        $kda = ($kills + $assists) / $deaths;

        return round($kda, 2);
    }
}
