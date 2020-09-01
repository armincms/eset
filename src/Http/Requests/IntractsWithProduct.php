<?php

namespace Armincms\Eset\Http\Requests;
 
use Armincms\EasyLicense\Credit;

trait IntractsWithProduct
{ 
    /**
     * Detect if can pass product restriction.
     * 
     * @param  \Armincms\EasyLicense\Credit $credit 
     * @return bool         
     */
    public function passesProductRestriction(Credit $credit)
    {
        return ! $this->option('eset_operator_restriction') || $this->hasValidOperator($credit);
    }

    public function hasValidOperator(Credit $credit)
    {
        return $this->getOperator() === data_get($credit->load('license.product'), 'license.product.driver');
    }

    public function getOperator()
    {
        return $this->get(static::OPERATOR_KEY) ?: 'default';
    }
}
