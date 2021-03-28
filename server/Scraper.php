<?php 
include "./models/DataRowModel.php";
include "./Helper.php";
include "./HttpUser.php";
include "./enums/Genre.php";

$user = new HttpUser();
$response = $user->Request("https://www.dotabuff.com/players/66296404/matches?enhance=overview&page=1");
$cleanPage = Helper::CleanInitialPage($response);
$seperatedRows = Helper::SeperateTables($cleanPage);
$dataRows = [];
$allRows = substr_count($cleanPage, 'Skill');

for ($i=0; $i <= $allRows ; $i++) { 
    $currentRow = $seperatedRows[$i];

    $hero    = GetHeroName($currentRow);
    $skill   = GetSkillLevel($currentRow);
    $role    = GetHeroRole($currentRow);
    $outcome = GetGameOutcome($currentRow);
    $lane    = GetHeroLane($currentRow);
    $type    = GetGameType($currentRow);
    $genre   = GetGameGenre($currentRow);
    $length  = GetGameLength($currentRow);

    $dataRow = new DataRowModel();

    isset($hero)    ? $dataRow->SetHero($hero)       : $dataRow->SetHero(NULL);
    isset($skill)   ? $dataRow->SetSkill($skill)     : $dataRow->SetSkill(NULL);
    isset($role)    ? $dataRow->SetRole($role)       : $dataRow->SetRole(NULL);
    isset($outcome) ? $dataRow->SetOutcome($outcome) : $dataRow->SetOutcome(NULL);
    isset($lane)    ? $dataRow->SetLane($lane)       : $dataRow->SetLane(NULL);
    isset($type)    ? $dataRow->SetType($type)       : $dataRow->SetType(NULL);
    isset($genre)   ? $dataRow->SetGenre($genre)     : $dataRow->SetGenre(NULL);
    isset($length)  ? $dataRow->SetLength($length)   : $dataRow->SetLength(NULL);

    array_push($dataRows, $dataRow);
}

function GetSkillLevel($string){
    $skillLevel = Helper::get_string_between($string, '<div class="subtext">',  '<div class="grouped-icons r-only-mobile">');

    return $skillLevel;
}
function GetHeroName($string){
    $heroName = Helper::get_string_between($string, 'data-tooltip-url="/heroes/', '/tooltip"');

    return $heroName;
}
function GetHeroRole($string){
    $role = Helper::get_string_between($string, 'fa-role-', ' fa-fw role-icon');

    return $role;
}
function GetHeroLane($string){
    $lane = Helper::get_string_between($string, 'fa-lane-', ' fa-fw lane-icon');

    return $lane;
}
function GetGameOutcome($string){
    $outcome = "TBD";

    !empty(strstr($string, 'Won')) ? $outcome = "Win" : $outcome = "Loss";

    return $outcome;
}
function GetGameType($string){
    $type = "TBD";

    !empty(strstr($string, 'Normal')) ? $type = "Normal" : $type = "Ranked";

    return $type;
}
function GetGameGenre($string){
    $genres = Genre::GENRES;
    $genre = '';
    for ($i=0; $i < count($genres); $i++) { 
        if (!empty(strstr($string, $genres[$i])))
        {
            $genre = $genres[$i];
            break;
        }
    }

    return $genre;
}
function GetGameLength($string){
    $length = Helper::get_string_between($string, '</div></td><td>', '<div class="bar bar-default"><div class="segment');

    return $length;
}

var_dump(json_encode($dataRows));
?>