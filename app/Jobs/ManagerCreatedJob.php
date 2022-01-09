<?php

namespace App\Jobs;

use App\Mail\NewUser;
use App\Models\Admin;
use App\Models\Manager;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ManagerCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $password;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Manager $manager)
    {
        $this->manager = $manager;
        $this->password = Str::random(6);

        $this->manager->update([
            'password' => $this->password,
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->manager->email)
            ->send(new NewUser($this->manager, $this->password));
    }
}
