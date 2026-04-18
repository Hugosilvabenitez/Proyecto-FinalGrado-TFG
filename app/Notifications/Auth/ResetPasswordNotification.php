<?php
namespace App\Notifications\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🔐 Restablece tu contraseña - Gameflux')
            ->greeting('Hola 👋')
            ->line('Hemos recibido una solicitud para restablecer tu contraseña en Gameflux.')
            ->action('Restablecer contraseña', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Este enlace expirará en 60 minutos por seguridad.')
            ->line('Si no has solicitado este cambio, puedes ignorar este correo.')
            ->salutation('— Equipo Gameflux');
    }
}
?>