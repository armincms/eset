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

    public static function encrypt($plainpasswd)
    {
        $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
        $len = strlen($plainpasswd);
        $text = $plainpasswd.'$apr1$'.$salt;
        $bin = pack("H32", md5($plainpasswd.$salt.$plainpasswd));
        for($i = $len; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
        for($i = $len; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $plainpasswd[0]; }
        $bin = pack("H32", md5($text));
        for($i = 0; $i < 1000; $i++)
        {
            $new = ($i & 1) ? $plainpasswd : $bin;
            if ($i % 3) $new .= $salt;
            if ($i % 7) $new .= $plainpasswd;
            $new .= ($i & 1) ? $bin : $plainpasswd;
            $bin = pack("H32", md5($new));
        }
        $tmp = '';
        for ($i = 0; $i < 5; $i++)
        {
            $k = $i + 6;
            $j = $i + 12;
            if ($j == 16) $j = 5;
            $tmp = $bin[$i].$bin[$k].$bin[$j].$tmp;
        }
        $tmp = chr(0).chr(0).$bin[11].$tmp;
        $tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
        "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");

        return "$"."apr1"."$".$salt."$".$tmp;
    } 
}