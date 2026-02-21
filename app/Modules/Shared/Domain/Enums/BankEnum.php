<?php

namespace App\Modules\Shared\Domain\Enums;

enum BankEnum: string
{
    case PicPay        = 'PicPay';
    case Caixa         = 'Caixa';
    case BancoDoBrasil = 'Banco do Brasil';
    case Santander     = 'Santander';
    case Inter         = 'Inter';
    case Nubank        = 'Nubank';
    case Bradesco      = 'Bradesco';
    case Sicoob        = 'Sicoob';
    case Itau          = 'Itaú';
    case C6Bank        = 'C6 Bank';
    case BTGPactual    = 'BTG Pactual';
    case XP            = 'XP';
    case Neon          = 'Neon';
    case PagBank       = 'PagBank';
    case Mercadopago   = 'Mercado Pago';
    case Agibank       = 'Agibank';
    case BRB           = 'BRB';
    case Banrisul      = 'Banrisul';

    /** Cor oficial da marca (cartão / identidade visual) */
    public function color(): string
    {
        return match($this) {
            self::PicPay        => '#21C25E', // verde PicPay
            self::Caixa         => '#0066B3', // azul Caixa
            self::BancoDoBrasil => '#FFCC00', // amarelo BB
            self::Santander     => '#EC0000', // vermelho Santander
            self::Inter         => '#FF7A00', // laranja Inter
            self::Nubank        => '#8A05BE', // roxo Nubank
            self::Bradesco      => '#CC092F', // vermelho Bradesco
            self::Sicoob        => '#00A859', // verde Sicoob
            self::Itau          => '#EC7000', // laranja Itaú
            self::C6Bank        => '#242424', // preto C6
            self::BTGPactual    => '#072C54', // azul marinho BTG
            self::XP            => '#111111', // preto XP
            self::Neon          => '#00E5A0', // verde-neon Neon
            self::PagBank       => '#00A859', // verde PagSeguro/PagBank
            self::Mercadopago   => '#009EE3', // azul Mercado Pago
            self::Agibank       => '#E30613', // vermelho Agibank
            self::BRB           => '#005CA8', // azul BRB
            self::Banrisul      => '#004B8D', // azul Banrisul
        };
    }

    /** Cor de texto contrastante (branco ou preto) para badges/chips */
    public function textColor(): string
    {
        return match($this) {
            self::BancoDoBrasil => '#1a1a1a', // fundo amarelo → texto escuro
            default             => '#ffffff',
        };
    }

    /** Ícone Font Awesome sugerido */
    public function icon(): string
    {
        return 'fa-solid fa-building-columns';
    }

    /**
     * Resolve a cor pelo nome do banco (string livre).
     * Útil para buscar a cor a partir de um campo string do banco de dados.
     */
    public static function colorByName(string $name): string
    {
        foreach (self::cases() as $case) {
            if (mb_strtolower($case->value) === mb_strtolower($name)) {
                return $case->color();
            }
        }

        return '#6B7280'; // cinza neutro como fallback
    }

    /**
     * Retorna array pronto para uso no front-end via @json / select.
     * [['value' => '...', 'label' => '...', 'color' => '...', 'textColor' => '...'], ...]
     */
    public static function forSelect(): array
    {
        return array_map(
            fn(self $case) => [
                'value'     => $case->value,
                'label'     => $case->value,
                'color'     => $case->color(),
                'textColor' => $case->textColor(),
            ],
            self::cases()
        );
    }
}
