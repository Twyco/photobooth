<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailCustom extends VerifyEmail
{
    use Queueable;

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->subject('Aktivieren Sie Ihren neuen Account')
            ->markdown('vendor.notifications.email', [
                'notifiable' => $notifiable,
            ])
            ->line('Sie haben Ihre E-Mail-Adresse zur Registrierung eines Domes Fotobox-Accounts verwendet.')
            ->line('Bitte klicken sie auf den unten stehenden Aktivierungslink, um ihr Konto zu aktivieren.')
            ->action('Bestätigen Sie Ihre Email Adresse', $verificationUrl)
            ->line('Falls Sie die Registrierung nicht selbst durchgeführt haben, ignorieren Sie bitte diese E-Mail. Der Aktivierungslink verfällt automatisch.');
    }

}
