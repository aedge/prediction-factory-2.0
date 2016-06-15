<?php

include('simple_html_dom.php');

$dataURL = 'http://www.skysports.com/football/competitions/euro-2016/fixtures';


$html = file_get_html($dataURL);

$team1Count = 21;
$team1Count = 22;


foreach($html->find('h4.matches__group-header') as $header){
    $matchDate = $header->plaintext;
    
    $team1 = $html->find('span.swap-text__target', $team1Count)->innertext;
    $team2 = $html->find('span.swap-text__target', $team2Count)->innertext;
    
    $team1Count+=2;
    $team2Count+=2;

    echo $matchDate . " " . $team1 . " V " . $team2 . '</br>';
}