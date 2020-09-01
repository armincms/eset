<?php 

namespace Armincms\Eset;


class Decoder 
{
    static public function decode($key)
    {
    	$map = static::map();

        $i = 1; 

        return trim(preg_replace_callback('/[a-zA-Z0-9]/', function ($value='') use (&$i, $map) { 
            if (! isset($map[$value[0]][$i])) return;

            $codec = $map[$value[0]][$i];
            $i++;

            return  $codec.','; 
        }, $key), ',');
    }

    static public function map()
    {
        $json = file_get_contents(__DIR__.'/../resources/codex.json');

        return json_decode($json, true);
    }

    static public function hexDecode($key)
    {
    	$hex = '';

        for ($i=0; $i<strlen($key); $i++){
            $ord = ord($key[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2) .',';
        }

        return strToUpper(trim($hex, ',')); 
    }
}