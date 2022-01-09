<?php

namespace App\Jobs;

use App\Mail\NewUser;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class AdminCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Admin $admin)
    {
        $this->admin = $admin;
        $this->password = Str::random(6);

        $this->admin->update([
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
        Mail::to($this->user->email)->send(new NewUser($this->user, $this->password));
    }
}
