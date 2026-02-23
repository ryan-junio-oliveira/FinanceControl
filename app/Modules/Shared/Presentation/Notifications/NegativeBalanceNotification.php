<?php

namespace App\Modules\Shared\Presentation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NegativeBalanceNotification extends Notification
{
    use Queueable;

    protected float $income;
    protected float $expense;

    public function __construct(float $income, float $expense)
    {
        $this->income = $income;
        $this->expense = $expense;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Saldo negativo detectado')
            ->line("As despesas ({$this->expense}) excedem as receitas ({$this->income}), resultando em saldo negativo.")
            ->line('Revise o fluxo de caixa e ajuste os valores.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'negative_balance',
            'income' => $this->income,
            'expense' => $this->expense,
        ];
    }
}
