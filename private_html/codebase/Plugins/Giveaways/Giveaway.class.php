<?php
namespace vlobby\Plugins\Giveaways;

class Giveaway {
    public $personaname, $avatar;
    public $id, $hash, $title, $description, $status, $end_date, $max_entries, $entries, $visibility, $delivery, $created_by;
    public $ITEMS = array();
    public $ENTRIES = array();
    
    public function getMaxEntries(){
        if($this->max_entries == 0){
            return 'Unlimited';
        }else{
            return $this->max_entries;
        }
    }
    
    public function getDeliveryType(){
        switch($this->delivery){
            case 0:
                return 'User';
            case 1:
                return 'Automatic';
            default:
                return 'Unkown ? ERROR';
        }
    }
    
    public function getVisibilityType(){
        switch($this->visibility){
            case 0:
                return 'Public Giveaway';
            case 1:
                return 'Private Giveaway';
            case 2:
                return 'Group Giveaway';
            default:
                return 'Unkown ? ERROR';
        }
    }
}
