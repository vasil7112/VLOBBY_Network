<?php
namespace vlobby\trade;
class TradeManager {
    public static $TRADES = array();
    public function __construct($TRADEID = NULL) {
        if(empty(self::$TRADE)){
            $PDO = \vlobby\Database\Connect::getInstance();
            $query = ($TRADEID == NULL ? '`trades`.`status` = 0' : '`trades`.`id` = :TRADEID');
            $STMT = $PDO->prepare('SELECT `steamInfo`.`personaname`, 
                                          `steamInfo`.`avatar`, 
                                          `trades`.`id`, 
                                          `trades`.`steamID`,
                                          `trades`.`status`,
                                          `trades`.`title`,
                                          `trades`.`description`,
                                          `trades`.`type`
                                   FROM `trades`
                                    JOIN `steamInfo` ON `trades`.`steamID` = `steamInfo`.`steamID`
                                   WHERE ('.$query.')');
            $STMT->bindParam(':TRADEID', $TRADEID, \PDO::PARAM_INT);
            $STMT->execute();
            $STMT->setFetchMode(\PDO::FETCH_CLASS, __NAMESPACE__ . '\\Trade');
            $TradeIDs = array();
            while($result = $STMT->fetch(\PDO::FETCH_CLASS)){
                self::$TRADES[$result->id] = $result;
                array_push($TradeIDs, $result->id);
            }
            
            if(!empty($TradeIDs)){
                $STMT2 = $PDO->prepare('SELECT `id`,
                                               `item_name`,
                                               `item_image`,
                                               `type`,
                                               `trade_id`
                                        FROM `trades_items`
                                        WHERE `trade_id` IN ('.implode(',', $TradeIDs).')');
                $STMT2->bindParam(':TRADEID', $TRADEID, \PDO::PARAM_INT);
                $STMT2->execute();
                while($result = $STMT2->fetch()){
                     $trade = self::$TRADES[$result['trade_id']];
                     if($result['type'] == 0){
                        array_push($trade->MY_ITEMS, $result);
                     }else if($result['type'] == 1){
                        array_push($trade->OTHER_ITEMS, $result);
                     }
                }
            }
        }
    }
    
    public function getTrades(){
        if(empty(self::$TRADES)){
            return '<h3 class="text-center">No Trades Available</h3>';
        }else{
            $HTML = '';
            foreach(self::$TRADES as $trade){
                $HTML .= '<div data-tradetype="'.$trade->getType().'" class="panel panel-vlobby">
                            <div class="panel-heading">'.$trade->title.' <span class="pull-right">by '.$trade->personaname.'</span></div>
                            <div style="color:black;" class="panel-body congruent">
                                <div>
                                    <button type="button" class="btn btn-vlobby pull-right" onclick="location.href = \'' . \vlobby\THIS_DOMAIN('TRADE') . '/'.$trade->id.'\';">See Trade</button>
                                    <div class="clear-both"></div>
                                </div>
                                <div class="col-xs-12 col-sm-5-5 col-md-5-5 font-PoiretOne">
                                    <span style="display:block;"><b>I will give:</b></span>';
                                    foreach($trade->MY_ITEMS as $item){
                                        $HTML .= '<div data-title="'.$item['item_name'].'" class="img-rounded-container item-block" height="75" width="75" style="background-image:url(\''.$item['item_image'].'\');border-color:#000000;"><span>&nbsp;</span></div>';
                                    }
                       $HTML .='</div>
                                <div class="hidden-xs col-xs-12 col-sm-1 col-md-1 font-PoiretOne">
                                    <span class="glyphicon glyphicon-arrow-right" style="font-size: 40px;margin-top:50px;" aria-hidden="true"></span>
                                </div>
                                <div class="visible-xs col-xs-12 col-sm-1 col-md-1-10per font-PoiretOne">
                                    <span class="glyphicon glyphicon-arrow-down" style="font-size: 40px;margin-top:30px;" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-12 col-sm-5-5 col-md-5-5 font-PoiretOne">
                                    <span style="display:block;"><b>and i need:</b></span>';
                                    foreach($trade->OTHER_ITEMS as $item){
                                        $HTML .= '<div data-title="'.$item['item_name'].'" class="img-rounded-container item-block" height="75" width="75" style="background-image:url(\''.$item['item_image'].'\');border-color:#000000;"><span>&nbsp;</span></div>';
                                    }
                       $HTML .='</div>
                            </div>
                          </div>';
            }
            return $HTML;
        }
    }
}