<?php

namespace App\Notifications;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class FollowUpScheduled extends Notification
{
    use Queueable;

    protected $patient;
    protected $scheduledDate;

    public function __construct(Patient $patient, Carbon $scheduledDate)
    {
        $this->patient = $patient;
        $this->scheduledDate = $scheduledDate;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = route('patients.show', $this->patient->id);

        return (new MailMessage)
            ->subject('Follow-up Scheduled - ' . $this->patient->full_name)
            ->line('A follow-up examination has been scheduled for ' . $this->patient->full_name)
            ->line('Scheduled Date: ' . $this->scheduledDate->format('Y-m-d H:i'))
            ->action('View Patient', $url)
            ->line('Please ensure to review the patient\'s history before the follow-up.');
    }

    public function toDatabase($notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'title' => 'Follow-up Scheduled',
            'patient_id' => $this->patient->id,
            'message' => 'Follow-up scheduled for ' . $this->patient->full_name . ' on ' . $this->scheduledDate->format('Y-m-d H:i'),
            'action_url' => route('patients.show', $this->patient->id),
            'scheduled_date' => $this->scheduledDate,
            'type' => 'follow_up'
        ]);
    }
}
