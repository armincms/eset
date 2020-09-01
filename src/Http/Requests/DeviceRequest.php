<?php

namespace Armincms\Eset\Http\Requests; 

use Armincms\Eset\EsetDevice; 

class DeviceRequest extends ValidationRequest
{  
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    { 
        return [
            'device_id' => 'required',
        ];
    }
}
