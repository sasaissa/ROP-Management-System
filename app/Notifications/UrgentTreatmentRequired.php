<?php

namespace App\Notifications;

use App\Models\Examination;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class UrgentTreatmentRequired extends Notification
{
    use Queueable;

    protected $examination;

    public function __construct(Examination $examination)
    {
        $this->examination = $examination;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = route('examinations.show', $this->examination->id);

        return (new MailMessage)
            ->subject('Urgent: Treatment Required - Patient ' . $this->examination->patient->full_name)
            ->line('An urgent treatment is required for patient ' . $this->examination->patient->full_name)
            ->line('Examination Date: ' . $this->examination->examination_date)
            ->action('View Examination', $url)
            ->line('Please review and take necessary action immediately.');
    }

    public function toDatabase($notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'title' => 'Urgent Treatment Required',
            'patient_id' => $this->examination->patient_id,
            'examination_id' => $this->examination->id,
            'message' => 'Urgent treatment required for patient ' . $this->examination->patient->full_name,
            'action_url' => route('examinations.show', $this->examination->id),
            'type' => 'urgent_treatment'
        ]);
    }
}
