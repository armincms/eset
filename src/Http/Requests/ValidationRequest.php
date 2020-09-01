<?php

namespace Armincms\Eset\Http\Requests;


class ValidationRequest extends EsetRequest
{
	use IntractsWithDevice, IntractsWithProduct; 

    public function findCreditOrFail()
    {
    	return tap(parent::findCreditOrFail(), function($credit) {
    		abort_if(! $this->passesProductRestriction($credit), 403, __('Invalid Product'));
    		abort_if(! $this->passesDeviceRestriction($credit), 403, __('Invalid Devaice'));
    	});
    }
    
    public function getDeviceId()
    {
    	return $this->get('device_id');
    } 
}
