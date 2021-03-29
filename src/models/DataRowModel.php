<?php 
class DataRowModel implements \JsonSerializable 
{
    private $hero;

    private $skill;

    private $role;

    private $outcome;

    private $lane;

    private $type;

    private $genre;

    private $length;

    private $kda;

    public function GetHero(){
        return $this->hero;
    }

    public function SetHero($hero){
        $this->hero = $hero;
    }

    public function GetSkill(){
        return $this->skill;
    }

    public function SetSkill($skill){
        $this->skill = $skill;
    }

    public function GetRole(){
        return $this->role;
    }

    public function SetRole($role){
        $this->role = $role;
    }

    public function GetOutcome(){
        return $this->outcome;
    }

    public function SetOutcome($outcome){
        $this->outcome = $outcome;
    }

    public function GetLane(){
        return $this->lane;
    }

    public function SetLane($lane){
        $this->lane = $lane;
    }

    public function GetType(){
        return $this->type;
    }

    public function SetType($type){
        $this->type = $type;
    }

    public function GetGenre(){
        return $this->genre;
    }

    public function SetGenre($genre){
        $this->genre = $genre;
    }
    
    public function GetLength(){
        return $this->length;
    }

    public function SetLength($length){
        $this->length = $length;
    }

    public function GetKDA(){
        return $this->kda;
    }

    public function SetKDA($kda){
        $this->kda = $kda;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
?>