<?php

namespace Armincms\Eset\Http\Requests;

use Illuminate\Foundation\Http\FormRequest; 

abstract class EsetRequest extends FormRequest
{
    use IntractsWithOption, IntractsWithCredit;
    
    /**
     * API Configurations.
     * 
     * @var null
     */
    protected static $options = null;

    const OPERATOR_KEY = 'operator';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {  
        return  $this->getHost() == $this->option('_api_doamin_') &&
                $this->get('apikey') == $this->option('eset_apikey') &&
                $this->expectsJson();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    { 
        return [
            //
        ];
    }
}
