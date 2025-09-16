<?php
    namespace App\Enums;

    enum FireLevelEnum: int
    {
        case CONTROLLED     = 1;
        case SPREADING      = 2;
        case HARMFUL        = 3;
        case UNCONTROLLABLE = 4;

        public function label(): string
        {
            return match($this) {
                self::CONTROLLED     => 'Controlled Fire',
                self::SPREADING      => 'Spreading Fire',
                self::HARMFUL        => 'Harmful Fire',
                self::UNCONTROLLABLE => 'Uncontrollable Fire',
            };
        }

        public static function fromLabel(string $label): ?self
        {
            return match(strtolower($label)) {
                'controlled fire'     => self::CONTROLLED,
                'spreading fire'      => self::SPREADING,
                'harmful fire'        => self::HARMFUL,
                'uncontrollable fire' => self::UNCONTROLLABLE,
                default => null,
            };
        }
    }