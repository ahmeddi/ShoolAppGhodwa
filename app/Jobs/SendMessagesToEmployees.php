<?php

namespace App\Jobs;

use App\Models\Emp;
use Illuminate\Bus\Queueable;
use App\Services\WhatsappApiService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Artisan;

class SendMessagesToEmployees implements ShouldQueue
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

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $emps = Emp::all();
        $create = new WhatsappApiService(); // Ensure this service is properly imported

        foreach ($emps as $emp) {
            if ($emp->tel2 === null) {
                continue;
            }

            $code = '222'; // Modify as needed
            $phone = $code . $emp->tel2;

            $create->sendCurlRequest($phone, $this->message);  // Assuming sendCurlRequest is a globally available function.


         //   SendMessage::dispatch($phone, $this->message);

        }



    }
}