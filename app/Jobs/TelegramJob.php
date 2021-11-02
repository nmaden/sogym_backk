<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TelegramJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $message = $this->message;
        $this->send_telegram(281900870,$message); // I
        $this->send_telegram(546286304,$message); // Wygila
        $this->send_telegram(2091260232,$message); // Nurbolat
        $this->send_telegram(2014378443,$message); // ASIA
     
    }

    public function send_telegram($id,$message) {
        $token = '2034414802:AAF5hZtx71Aup0dnIwN0LWwj9mHVJj6x6ME';
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" .$id;
        $url = $url . "&text=" . urlencode($message);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        // return $result;
    }
}
