<?php

namespace App\Modules\Shared\Presentation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Modules\CreditCard\Domain\Entities\CreditCard as CreditCardEntity;

class CreditCardDueNotification extends Notification
{
    use Queueable;

    protected CreditCardEntity $card;

    public function __construct(CreditCardEntity $card)
    {
        $this->card = $card;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Fatura do cartão '{$this->card->name()}' está próxima")
            ->line("A fatura do cartão '{$this->card->name()}' vence em {$this->card->dueDay()}.")
            ->line('Verifique se o pagamento foi agendado para evitar juros.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'creditcard_due',
            'card_id' => $this->card->id(),
            'card_name' => $this->card->name(),
            'due_day' => $this->card->dueDay(),
        ];
    }
}
