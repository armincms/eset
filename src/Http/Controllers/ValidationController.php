<?php

namespace Armincms\Eset\Http\Controllers;

use Illuminate\Routing\Controller;
use Armincms\Eset\Http\Requests\ValidationRequest; 
use Armincms\Eset\Decoder; 

class ValidationController extends Controller
{ 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handle(ValidationRequest $request)
    {     
        $credit = tap($request->findCreditOrFail(), function($credit) use ($request) {
            $request->option('eset_device_restriction') || $credit->startIfNotStarted();  
        });  

        $devices = $request->deviceQuery($credit)->get();

        return [ 
            'username'  => Decoder::hexDecode(data_get($credit, 'data.username')),
            'password'  => Decoder::decode(data_get($credit, 'data.password')), 
            'expiresOn' => $credit->expires_on->toDateTimeString(),
            'startedAt' => optional($credit->startedAt())->toDateTimeString(), 
            'daysLeft'  => $credit->daysLeft(),
            'users'     => $credit->license->users,
            'inUse'     => $devices->count(),
            'fileServer'=> $request->servers($request->getOperator(), 'file_server'),
            'failServer'=> $request->servers($request->getOperator(), 'fails_server'),
            'servers'   => $request->servers($request->getOperator(), 'servers'), 
            'serials'   => $devices->pluck('device_id')->all(), 
        ];  
    }   
}
