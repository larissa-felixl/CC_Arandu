<?php
    namespace App\Enums;

    enum FireLevelEnum: int {
        case CONTROLLED     = 1;
        case SPREADING      = 2;
        case HARMFUL        = 3;
        case UNCONTROLLABLE = 4;

        public function label(): string
        {
            return match($this) {
                self::CONTROLLED     => 'baixo',
                self::SPREADING      => 'médio',
                self::HARMFUL        => 'alto',
                self::UNCONTROLLABLE => 'prejudicial',
            };
        }

        // public static function fromLabel(string $label): ?self
        // {
        //     return match(strtolower($label)) {
        //         'baixo'        => self::CONTROLLED,
        //         'médio', 'medio' => self::SPREADING, // 
        //         'alto'         => self::HARMFUL,
        //         'prejudicial'  => self::UNCONTROLLABLE,
        //         default => null,
        //     };
        // }
}