<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordCustom extends ResetPassword
{
    use Queueable;

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            ->mailer('security')
            ->from(env('SECURITY_MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->markdown('vendor.notifications.email', [
                'notifiable' => $notifiable,
            ])
            ->subject('Passwort zurücksetzen')
            ->line('Es wurde eine Änderung der Anmeldeinformationen für Ihren Account angefordert. Wenn Sie diese Änderung beantragt haben, klicken Sie auf den unten stehenden Link.')
            ->action('Passwort zurücksetzen', $this->resetUrl($notifiable))
            ->line('Die Gültigkeit des Links wird in ' . config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') . ' Minuten verfallen.')
            ->line('Sollten Sie keine Änderung vollziehen wollen können Sie diese Nachricht ignorieren und an Ihrem Account wird nichts geändert.');
    }

}
