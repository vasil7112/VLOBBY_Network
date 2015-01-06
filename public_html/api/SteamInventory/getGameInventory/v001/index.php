<?php
require_once('../../../../../private_html/config.php');
if($_GET['appid'] == '440'){
    $HTML = '';
    $content = json_decode(file_get_contents('http://vlobbys.net:8082/newjson.json'), true);
    $bannedDefindex = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
                            10, 11, 12, 13, 14, 15, 16, 17, 18, 19,
                            20, 21, 22, 23, 24, 25, 26, 27, 28, 29,
                            30, 472, 735, 1132, 1133, 1134, 1135, 1136, 1137, 1138,
                            1139, 1140, 1152, 2061, 2066, 2067, 2068, 2078, 2082, 2083,
                            2084, 2085, 2086, 2087, 2088, 2089, 2090, 2091, 2109, 2110,
                            2111, 2112, 2113, 2114, 2115, 2116, 2117, 2118, 2119, 2120,
                            2121, 2122, 2127, 2128, 2132, 2133, 2134, 2136, 2137, 30143,
                            30144, 30145, 30146, 30147, 30148, 30149, 30150, 30151, 30152,
                            30153, 30154, 30155, 30156, 30157, 30158, 30159, 30160, 30161);
    foreach($content['result']['items'] as $item){
        if(in_array($item['defindex'], $bannedDefindex)){
            continue;
        }
        if(isset($item['attributes'])){
            $cannot_trade = false;
            foreach($item['attributes'] as $attr){
                if($attr['class'] == 'cannot_trade'){
                    $cannot_trade = true;
                    break;
                }
            }
            if($cannot_trade){
                continue;
            }
        }
        $HTML .= '<div data-tooltip data-title="'.$item['name'].'" data-toggle="popover" class="img-rounded-container gameinv-item" height="75" width="75" style="background-image:url(\''.$item['image_url'].'\');border-color:#000000;"></div>';
    }
    echo $HTML;
}else{
    echo 'NOT YET AVAILABLE (ONLY TF2)';
}
?>