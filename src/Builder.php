<?php 

namespace Armincms\Eset;

use Armincms\EasyLicense\Credit;

class Builder
{  
    static $usernamePrefix = 'eav';

   static public function build($access = null, $fields = [])
   {   
        return [
            'username'  => array_get($fields, 'username') ?: self::username(),
            'password'  => array_get($fields, 'password') ?: self::password(),
            'key'       => array_get($fields, 'key') ?: self::key(), 
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

   static public function ess($access = null, $fields = [])
   {
      self::$usernamePrefix = 'ess';
      return self::build($access, $fields);
   }

   static public function essp($access = null, $fields = [])
   {
      self::$usernamePrefix = 'essp';
      return self::build($access, $fields);
   }

   static public function eis($access = null, $fields = [])
   {
      self::$usernamePrefix = 'eis';
      return self::build($access, $fields);
   }

   static public function eav($access = null, $fields = [])
   {
      self::$usernamePrefix = 'eav';
      return self::build($access, $fields);
   }

   static public function eea($access = null, $fields = [])
   {
      self::$usernamePrefix = 'eea';
      return self::build($access, $fields);
   }

   static public function ees($access = null, $fields = [])
   {
      self::$usernamePrefix = 'ees';
   		return self::build($access, $fields);
   }
}
