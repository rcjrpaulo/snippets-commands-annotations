<?php

$string = 'my name is paulo';

function isTextInString($text, $string)
{
    return is_numeric(strpos($string, $text));
}

$caique = isTextInString('is caique', $string);
$paulo = isTextInString('is paulo', $string);

var_dump($caique, $paulo);
//saida $caique=false, $paulo=true