<?php

namespace Armincms\Eset\Http\Requests;
 
use Armincms\EasyLicense\Credit;
use Armincms\Eset\EsetDevice;

trait IntractsWithDevice
{ 
    /**
     * Detect if can pass product restriction.
     * 
     * @param  \Armincms\EasyLicense\Credit $credit 
     * @return bool         
     */
    public function passesDeviceRestriction(Credit $credit)
    {
        return ! $this->option('eset_device_restriction') && $this->isAccessible($credit->withDuration());
    }

    public function isAccessible(Credit $credit)
    { 
        if($this->deviceQuery($credit)->where('device_id', $this->getDeviceId())->count() > 0) {
            return true;
        }  

        return $this->deviceQuery($credit)->count() < intval(optional($credit->license)->users);
    } 

    public function deviceQuery(Credit $credit)
    {
        return EsetDevice::where('credit_id', $credit->getKey());
    }
    
    public function getDeviceId()
    {
        return $this->get('device_id');
    } 
}
