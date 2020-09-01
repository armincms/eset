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

    public function ftp($operator, $key, $default = null)
    {
        $ftp = array_merge($this->scopeFTP('default'), $this->scopeFTP($operator)); 

        return data_get($ftp, $key, $default);
    } 

    protected function scopeFTP($operator = 'default')
    {
        $data = collect(static::option('eset_ftp'))->where('layout', $operator)->first();

        return (array) data_get($data, 'attributes.ftp');
    }

    public function ftp2($operator, $key, $default = null)
    {
        $ftp2 = array_merge($this->scopeFTP2('default'), $this->scopeFTP2($operator)); 

        return data_get($ftp2, $key, $default);
    } 

    protected function scopeFTP2($operator = 'default')
    {
        $data = collect(static::option('eset_ftp'))->where('layout', $operator)->first();

        return (array) data_get($data, 'attributes.ftp');
    }

    public function servers($operator, $key, $default = null)
    { 
        $servers = array_merge($this->scopeServers('default'), $this->scopeServers($operator)); 

        return data_get($servers, $key, $default);
    }

    public function scopeServers($operator = 'default')
    {
        $data = collect(static::option('est_servers'))->where('layout', $operator)->first();

        return (array) data_get($data, 'attributes');
    }
}
