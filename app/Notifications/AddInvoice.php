<?php

namespace App\Notifications;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class AddInvoice extends Notification
{
    use Queueable;
    public $bill_id;
    public $user;
    /**
     * Create a new notification instance.
     */
    public function __construct( $bill_id,$user)
    {
        $this->bill_id=$bill_id;
        $this->user=$user;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }


    public function toDatabase(object $notifiable): array
{
      return [
            'bill'=>$this->bill_id,
            'data'=>' تمت اضافة فاتورة جديدة من قبل المستخدم:',
            'user_name'=>$this->user->name,
        ];
}
}
