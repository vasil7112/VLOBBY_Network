<?php
namespace vlobby\trade;

class Trade {
    public $personaname, $avatar, $id, $steamID, $status, $title, $description, $type;
    public $MY_ITEMS = array();
    public $OTHER_ITEMS = array();
    
    public function getType(){
        switch ($this->type) {
            case 1:
                return 'csgo';
            case 2:
                return 'tf2';
            case 3:
                return 'dota';
            case 4:
                return 'steamcards';
            case 5:
                return 'other';
        }
    }
}
