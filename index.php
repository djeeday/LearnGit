<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$var1 = "Йопсель";
$var2 = "Мопсель";
echo "{$var1}-{$var2}!";
$_delimeter = '#';
function _normalize($pattern, $_delimeter )
        {
            return $_delimeter.trim($pattern, $_delimeter).$_delimeter;
        }

$pattern = "^get([a-zA-Z0-9]+)$";
$string = "getColor";
preg_match_all(_normalize($pattern,$_delimeter ), $string, $matches, PREG_PATTERN_ORDER);
var_dump($matches);
function getIncludedInfo($path)
{
    $someInfo = array();
    include("{$path}.php");
    return $someInfo;
}

var_dump(getIncludedInfo("includeMe")["info1"]);