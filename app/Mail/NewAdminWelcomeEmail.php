<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

//implements ShouldQueue
class NewAdminWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    // public Admin $admin;
    protected Admin $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Admin $admin)
    {
        //
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@bank-system.com')
            ->subject('Welcome in Bank-System')
            // ->cc('momen.sisalem@gmail.com')
            ->with([
                'fullName' => $this->admin->full_name
            ])
            ->markdown('email.new_admin_email');
    }
}
