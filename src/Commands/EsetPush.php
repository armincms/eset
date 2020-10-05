<?php

namespace Armincms\Eset\Commands;

use Illuminate\Console\Command;
use Armincms\EasyLicense\{Credit};
use Armincms\Eset\{Eset, Decoder};

class EsetPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eset:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push the licneses into the update servers';  

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Credit::with([
            'license' => function($query) {
                $query->withTrashed()->with([
                    'product' => function($query) {
                        $query->withTrashed()->whereIn('driver', array_keys($this->drivers()));
                    },
                    'duration' => function($query) {
                        $query->withTrashed();
                    }
                ]);
            }
        ])
        ->whereNotNull('expires_on')
        ->get()
        ->reject->isExpired()
        ->groupBy('license.product.driver')
        ->map(function($credits, $driver) { 
            $credits = $credits->reduce(function($carry, $credit) {
                $username = data_get($credit, 'data.username');
                $password = Decoder::encrypt(data_get($credit, 'data.password'));

                return "{$username}:{$password}".PHP_EOL.$carry;
            }, PHP_EOL);

            return compact('credits', 'driver');
        })
        ->groupBy(function($credits, $driver) { 
            return collect(Eset::ftp($driver))->only(['host', 'path', 'root'])->implode(',');
        })
        ->each(function($group) { 
            $this->put(
                $group->map->driver, 
                $group->map->credits->implode(PHP_EOL)
            );
        });
    }

    public function drivers()
    {
        return config('licence-management.operators.eset.drivers');
    } 

    public function put($drivers, $content)
    { 
        with($this->storage($drivers->first()), function($storage) use ($drivers, $content) {

            $path = data_get(Eset::ftp($drivers->first()), 'path', 'eset_upd');  

            try { 
                $storage->delete("{$path}/.htpasswd");
                $storage->put("{$path}/.htpasswd", $content); 

                \Log::info('`' .$drivers->implode(''). '` licenses inserted at: '. now());
                
            } catch (\Exception $e) {
                \Log::warning("insertion licenses of the `{$drivers->implode('')}` failed. read error below.");
                \Log::error($e->getMessage());
            } 
        });
    }

    public function storage($driver)
    {   
        \Config::set("filesystems.disks.eset.{$driver}", array_merge([
            'driver'   => 'ftp', 
            'port'     => 21,
            'root'     => 'public_html',
            'passive'  => true,
            'ssl'      => true,
            'timeout'  => 60, 
        ], (array) Eset::ftp($driver))); 

        return \Storage::disk("eset.{$driver}"); 
    }
}
