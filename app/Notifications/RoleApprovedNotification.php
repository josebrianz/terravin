<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class RoleApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $dashboardUrl = url('/dashboard');
        if ($this->role === 'Retailer') {
            $dashboardUrl = url(route('retailer.dashboard', [], false));
        }
        return (new MailMessage)
            ->subject('Your Role Request Has Been Approved')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Congratulations! Your request to become a ' . $this->role . ' has been approved by the admin.')
            ->action('Go to Dashboard', $dashboardUrl)
            ->line('You now have access to your new dashboard and features.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your request to become a ' . $this->role . ' has been approved.',
            'role' => $this->role,
        ];
    }
} 