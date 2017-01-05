<?php

function level2Text($level){
    $levelTxt = "";
    switch($level){
        case Config::get('constants.DIFFICULTY_LEVEL_EASY'):
            $levelTxt = "Easy";
            break;
        case Config::get('constants.DIFFICULTY_LEVEL_MEDIUM'):
            $levelTxt = "Medium";
            break;
        case Config::get('constants.DIFFICULTY_LEVEL_HARD'):
            $levelTxt = "Hard";
            break;
    }
    return $levelTxt;
}
