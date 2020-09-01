<?php

namespace Armincms\Eset;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\{Heading, Text, Number, Select, Boolean, Password}; 
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel; 
use Whitecube\NovaFlexibleContent\Flexible;
use Inspheric\Fields\Url;
use NovaItemsField\Items;
use Armincms\Bios\Resource;
use Armincms\Json\Json;

class Eset extends Resource
{ 
    /**
     * The option storage driver name.
     *
     * @var string
     */
    public static $store = '';

    public static $options = null;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    { 
        return [
            (new Panel(__('License'), [
                Heading::make(__('The original license information here'), 'license'),

                Text::make('Username', 'eset_original_username')
                    ->required()
                    ->rules('required'),

                Text::make('Password', 'eset_original_password')
                    ->required()
                    ->rules('required'),
            ]))->withToolbar(),

            (new Panel('API', [
                Heading::make(__('Application connection authorization'), 'api'),

                Text::make('API Key', 'eset_apikey')
                    ->required()
                    ->rules('required')
                    ->withMeta(['value' => md5(time())]),

                Select::make(__('Domain'), 'eset_domain') 
                    ->required()
                    ->rules('required')
                    ->readonly(),

                Boolean::make(__('Device Serial Restriction'), 'eset_customer_restriction'),

                Boolean::make(__('ESET Product Restriction'), 'eset_operator_restriction'),
            ])),

            new Panel('FTP', [
                tap(Flexible::make('FTP', 'eset_ftp'), function ($flexible) {

                    $flexible
                        ->addLayout(__('Default'), 'default', $this->ftpFields(true))
                        ->collapsed(true)
                        ->required()
                        ->button(__('FTP Connection Configuration'))
                        ->rules(['required', function($attribute, $value, $fail) {
                            collect($value)->where('layout', 'default')->first() ||
                            $fail(__('You should specify default configurations'));
                        }]); 

                    collect(config('licence-management.operators.eset.drivers'))
                        ->each(function($driver, $name) use ($flexible) { 
                            $flexible->addLayout($driver['title'] ?? $name, $name, $this->ftpFields());
                        }); 
                }),
            ]),

            new Panel(__('Servers'), [
                tap(Flexible::make('Servers', 'est_servers'), function ($flexible) {

                    $flexible
                        ->addLayout(__('Default'), 'default', $this->serverFields())
                        ->collapsed(true)
                        ->required()
                        ->button(__('Servers Configuration'))
                        ->rules(['required', function($attribute, $value, $fail) {
                            collect($value)->where('layout', 'default')->first() ||
                            $fail(__('You should specify default servers'));
                        }]); 

                    collect(config('licence-management.operators.eset.drivers'))
                        ->each(function($driver, $name) use ($flexible) { 
                            $flexible->addLayout($driver['title'] ?? $name, $name, $this->serverFields());
                        }); 
                }),
            ]),
        ];
    } 

    public function ftpFields()
    {
        return array_merge(
            Json::make('ftp', [
                Url::make(__('Host Name'), 'host')
                    ->required()
                    ->rules('required'),

                Text::make('Root')
                    ->withMeta(['value' => 'public_html'])
                    ->required()
                    ->rules('required'),

                Text::make(__('Folder Name'), 'path')
                    ->required()
                    ->rules('required'),

                Text::make('Username')
                    ->required()
                    ->rules('required'),

                Text::make('Password')
                    ->required()
                    ->rules('required'),

                Number::make('Port')
                    ->withMeta(['value' => 21]),

                Number::make('Timeout')
                    ->withMeta(['value' => 30])
            ])->ignoreCasting()->toArray(),

            [Heading::make('FTP2', 'heading')], 

            Json::make('ftp2', [ 
                Text::make('Username')
                    ->required()
                    ->rules('required'),

                Text::make('Password')
                    ->required()
                    ->rules('required'),
            ])->ignoreCasting()->saveHistory()->toArray(),
        ); 
    }

    public function serverFields()
    {
        return [
            Url::make(__('File Server'), 'file_server'),

            Url::make(__('Fails Server'), 'fails_server'),

            Items::make(__('Servers'), 'servers')
                ->inputType('url')
                ->listFirst()
                ->draggable()
                ->resolveUsing(function($value) {
                    return is_array($value) ? $value : (array) json_decode($value, true);
                }),
        ];
    }
}
