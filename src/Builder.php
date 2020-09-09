<?php 

namespace Armincms\Eset;

use Armincms\EasyLicense\Credit;

class Builder
{  
   static $usernamePrefix = 'eav';

   static public function build()
   {   
        return [
            'username'  => self::username(),
            'password'  => self::password(),
            'key'       => self::key(), 
        ];   
   }

   static public function username()
   {
   		$username = strtoupper(static::$usernamePrefix).'-0' .rand(100000000, 999999999); 

        return self::isUnique($username, 'username') ? $username : self::username(); 
   }

   static public function password()
   {
   		return substr(self::validCodeString(), 0, 10);
   }

   static public function key()
   {
   		$key = preg_replace(
   			'/(.{4})(.{4})(.{4})(.{4})(.{4})/', '${1}-${2}-${3}-${4}-${5}', 
            self::validCodeString()
   		);  

   		return self::isUnique($key, 'key') ? $key : self::key(); 
   }

   static public function validCodeString()
   {
   		$code = substr(md5(time()), 0 , 20); 

        return str_replace('0', 'o', $code);
   }

   static public function isUnique($value, $column)
   {
      return Credit::where('data->'. $column, $value)->count() === 0;
   }

   static public function ess()
   {
      self::$usernamePrefix = 'ess';
      return self::build();
   }

   static public function essp()
   {
      self::$usernamePrefix = 'essp';
      return self::build();
   }

   static public function eis()
   {
      self::$usernamePrefix = 'eis';
      return self::build();
   }

   static public function eav()
   {
      self::$usernamePrefix = 'eav';
      return self::build();
   }

   static public function eea()
   {
      self::$usernamePrefix = 'eea';
      return self::build();
   }

   static public function ees()
   {
      self::$usernamePrefix = 'ees';
   		return self::build();
   }
}
