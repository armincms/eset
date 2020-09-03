<?php

namespace Armincms\Eset\Http\Requests;


class ValidationRequest extends EsetRequest
{
	use IntractsWithDevice, IntractsWithProduct; 

    public function findCreditOrFail()
    {
    	return tap(parent::findCreditOrFail(), function($credit) {
    		abort_if(! $this->passesProductRestriction($credit), 400, __('Requested product not support'));
    		abort_if(! $this->passesDeviceRestriction($credit), 403, __('Requested credit is fully filled'));
    	});
    }
}
