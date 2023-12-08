<?php

namespace App\Jobs;

use App\Models\Prof;
use Illuminate\Bus\Queueable;
use App\Services\WhatsappApiService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMessagesToProfs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        $profs = Prof::all();
        $create = new WhatsappApiService();

        foreach ($profs as $prof) {
            if ($prof->tel2 === null) {
                continue;
            }

            $code = '222'; // Modify as needed
            $phone = $code . $prof->tel2;

            // Assuming sendCurlRequest is a method in WhatsappApiService for sending messages
            $create->sendCurlRequest($phone, $this->message);
        }
    }
}
