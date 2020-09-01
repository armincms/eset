<?php

namespace Armincms\Eset\Http\Requests;
 
use Armincms\EasyLicense\Credit;

trait IntractsWithCredit
{ 
    public function findCreditOrFail()
    {
        return tap($this->findCredit(), function($credit) {  
            abort_if(is_null($credit), 404, __('This credit not exists'));
            abort_if($credit->isExpired(), 404, __('This credit is expired'));
        });
    }

    public function findCredit()
    {
        return $this->creditQuery()
                    ->where(function($query) {
                        $query
                            ->whereJsonContains('data->username', $this->get('username'))
                            ->whereJsonContains('data->password', $this->get('password'));
                    })
                    ->orWhereJsonContains('data->key', $this->get('key'))
                    ->first();
    }

    public function creditQuery()
    {
        return Credit::query();
    } 
}
