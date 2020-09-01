<?php

namespace Armincms\Eset\Http\Controllers;

use Illuminate\Routing\Controller;
use Armincms\Eset\Http\Requests\SettingRequest; 

class SettingController extends Controller
{
    /**
     * Handle incoming setting request.
     * 
     * @param  \Armincms\Eset\Http\Requests\SettingRequest $request
     * @return \Illuminate\Http\ResResponse                
     */
    public function handle(SettingRequest $request)
    {
        return [ 
            'username'=> $request->option('username'),   
            'password'=> $request->option('password'),   
            'file_server'=> $request->option('file_server'),   
            'ftp' => [
                'server'=> $request->ftp('host'), 
                'path'=> $request->ftp('path'), 
            ],
            'ftp2' => [
                'username'=> $request->ftp2('username'),   
                'password'=> $request->ftp2('password'),  
            ] 
        ];
         
    }
}
