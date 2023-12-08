<?php

namespace App\Jobs;

use App\Models\Parentt;
use Illuminate\Bus\Queueable;
use App\Services\WhatsappApiService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMessagesToParents implements ShouldQueue
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
        $parents = Parentt::all();

        $create = new WhatsappApiService();

        foreach ($parents as $parent) {
            if ($parent->whatsapp) {
                $code = $parent->whcode;
                $phone = $code . $parent->whatsapp;
                $create->sendCurlRequest($phone, $this->message);
            }
        }
    }
}
