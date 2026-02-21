<?php

namespace App\Modules\Shared\Presentation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InviteNotification extends Notification
{
    use Queueable;

    protected string $temporaryPassword;

    public function __construct(string $temporaryPassword)
    {
        $this->temporaryPassword = $temporaryPassword;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Você foi convidado para a organização')
            ->greeting('Olá ' . ($notifiable->username ?? 'usuário'))
            ->line('Você foi convidado para a organização. Use a senha temporária abaixo para entrar e troque por uma senha segura ao acessar:')
            ->line('Senha temporária: '.$this->temporaryPassword)
            ->action('Redefinir senha', route('password.request'))
            ->line('Ao entrar, você será solicitado a alterar sua senha.');
    }
}
