<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class ClearRedis
{
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle()
    {
        $domain = rtrim(env('API_URL'),'/') . '/';
        Redis::del('setting.init');
        $setting = $domain . 'setting';
        
        $this->fire_curl($setting);
    }

    public function fire_curl($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl,[CURLOPT_URL=>$url,CURLOPT_TIMEOUT_MS=>100,CURLOPT_RETURNTRANSFER=>TRUE]);
        curl_exec($curl);
        curl_close ($curl);
    }

    public function del_redis_arr($text)
    {
        $redis_arr = Redis::keys($text);
        $prefix = env('REDIS_PREFIX', Str::slug(env('REDIS_NAME', 'laravel'), '_').'_database_');
        foreach ($redis_arr as $key => $redis) {
            $redis_key = str_replace($prefix, '', $redis);
            if($redis_key){
                Redis::del($redis_key);
            }
        }
    }
}
