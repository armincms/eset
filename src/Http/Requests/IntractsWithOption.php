<?php

namespace Armincms\Eset\Http\Requests;
 
use Armincms\Eset\Eset;

trait IntractsWithOption
{ 
    public function options()
    {
        if(! isset(static::$options)) {
            static::$options = Eset::options(); 
        }

        return static::$options;
    }

    public function option($key, $default = null)
    {
        return data_get(static::options(), $key, $default);
    }

    public function ftp($key, $default = null)
    {
        $ftp = array_merge($this->scopeFTP('default'), $this->scopeFTP(static::OPERATOR_KEY)); 

        return data_get($ftp, $key, $default);
    } 

    protected function scopeFTP($operator = 'default')
    {
        $data = collect(static::option('ftp'))->where('layout', $operator)->first();

        return (array) data_get($data, 'attributes.ftp');
    }

    public function ftp2($key, $default = null)
    {
        $ftp2 = array_merge($this->scopeFTP2('default'), $this->scopeFTP2(static::OPERATOR_KEY)); 

        return data_get($ftp2, $key, $default);
    } 

    protected function scopeFTP2($operator = 'default')
    {
        $data = collect(static::option('ftp2'))->where('layout', $operator)->first();

        return (array) data_get($data, 'attributes.ftp2');
    }
}
