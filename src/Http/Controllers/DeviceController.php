<?php

namespace Armincms\Eset\Http\Controllers;

use Illuminate\Routing\Controller;
use Armincms\Eset\Http\Requests\DeviceRequest; 

class DeviceController extends Controller
{ 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handle(DeviceRequest $request)
    {    
        $credit = tap($request->findCreditOrFail(), function($credit) {
            $credit->startIfNotStarted()->withDuration(); 
        });  

        $device = $request->deviceQuery($credit)->firstOrCreate([ 
            'device_id' => $request->getDeviceId(),
            'credit_id' => $credit->getKey(),
        ]);

        $device->update([
            'data' => array_merge((array) $device->data, (array) $request->get('params', []))
        ]);

        return response()->json([
            'expiresOn' => $credit->expires_on->toDateTimeString(),
            'daysLeft'  => $credit->daysLeft(),
            'inUse'     => $users = $request->deviceQuery($credit)->count(), 
            'available' => $credit->license->users - $users, 
        ], 201);         
    }   
}
