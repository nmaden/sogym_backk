<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;
use Log;
use Mobizon\MobizonApi;

class MobizonJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data   = $this->data;
        $phone  = '87074252290';
        $api    = new MobizonApi(env('MOBIZON_APP_KEY'),'api.mobizon.kz');
        // API call to send a message
        $api->call('message', 'sendSMSMessage',
        [
            'recipient' =>  $phone,
            'text'      => $data["text"]
        ]);
    }


    private function _PhoneCorrector($phone)
    {
        $whitelisted_chars = [
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
        ];

        $res = null;
        for ($i = 0; $i != mb_strlen($phone); $i++)
        {
            if (in_array($phone[$i], $whitelisted_chars))
            {
                $res .= $phone[$i];
            }
        }

        if ($res[0] == '8') $res[0] = '7';
        return $res;
    }
}
