<?php

    namespace App\Enums;

    enum ReportTypeEnum: int
    {
        case QUEIMADA = 1;
        case FOCO_DE_LIXO = 2;

        public function label(): string
        {
            return match($this) {
                self::QUEIMADA      => 'Queimada',
                self::FOCO_DE_LIXO  => 'Foco de Lixo',
            };
        }

        public static function fromScreen(string $screen): ?self
        {
            return match(strtolower($screen)) {
                'queimada' => self::QUEIMADA,
                'foco_de_lixo', 'lixo' => self::FOCO_DE_LIXO,
                default => null,
            };
        }
    }