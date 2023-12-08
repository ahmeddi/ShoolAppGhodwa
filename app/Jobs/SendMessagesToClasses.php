<?php

namespace App\Jobs;

use App\Models\Prof;
use App\Models\Classe;
use Illuminate\Bus\Queueable;
use App\Services\WhatsappApiService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMessagesToClasses implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $message;
    protected $classId;

    public function __construct($message, $classId)
    {
        $this->message = $message;
        $this->classId = $classId;
    }

    public function handle()
    {
        $class = Classe::with('etuds.parent')->find($this->classId);

        if ($class) {
            $create = new WhatsappApiService();

            foreach ($class->etuds as $etud) {
                $parent = $etud->parent;
                if ($parent && $parent->whatsapp) {
                    $code = $parent->whcode;
                    $phone = $code . $parent->whatsapp;
                    $create->sendCurlRequest($phone, $this->message);
                }
            }
        }
    }
}
