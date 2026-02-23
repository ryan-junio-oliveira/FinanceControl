<?php

namespace App\Modules\Shared\Presentation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Modules\Budget\Domain\Entities\Budget as BudgetEntity;

class BudgetLimitNotification extends Notification
{
    use Queueable;

    protected BudgetEntity $budget;
    protected float $spent;

    public function __construct(BudgetEntity $budget, float $spent)
    {
        $this->budget = $budget;
        $this->spent = $spent;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $percent = $this->budget->amount() > 0 ? round(($this->spent / $this->budget->amount()) * 100, 2) : 0;

        return (new MailMessage)
            ->subject("Orçamento '{$this->budget->name()}' excedido")
            ->line("O orçamento '{$this->budget->name()}' atingiu {$percent}% ({$this->spent} / {$this->budget->amount()}).")
            ->line('Verifique suas despesas ou ajuste o limite.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'budget_limit',
            'budget_id' => $this->budget->id(),
            'budget_name' => $this->budget->name(),
            'spent' => $this->spent,
            'limit' => $this->budget->amount(),
        ];
    }
}
