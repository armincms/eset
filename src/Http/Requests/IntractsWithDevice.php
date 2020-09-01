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
        return ! $this->option('eset_device_restriction') && $this->isAccessible($credit);
    }

    public function isAccessible(Credit $credit)
    {
        $credit->relationLoaded('license') || $credit->load('license');

        if($this->deviceQuery($credit)->where('device_id', $this->get('device_id'))->count() > 0) {
            return true;
        }  

        return $this->deviceQuery($credit)->count() < intval(optional($credit->license)->users);
    } 

    public function deviceQuery(Credit $credit)
    {
        return EsetDevice::where('credit_id', $credit->getKey());
    }
}
