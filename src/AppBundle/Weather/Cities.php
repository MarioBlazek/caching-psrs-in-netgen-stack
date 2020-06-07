<?php

declare(strict_types=1);

namespace AppBundle\Weather;

final class Cities
{
    public const CITY_ZAGREB = 'zagreb';
    public const CITY_VALPOVO = 'valpovo';
    public const CITY_SARAJEVO = 'sarajevo';
    public const CITY_SPLIT = 'split';
    public const CITY_MOSTAR = 'mostar';
    public const CITY_BELGRADE = 'belgrade';
    public const CITY_SKOPJE = 'skopje';

    public static function getCities(): array
    {
        return [
            self::CITY_ZAGREB,
            self::CITY_VALPOVO,
            self::CITY_SPLIT,
            self::CITY_SARAJEVO,
            self::CITY_MOSTAR,
            self::CITY_BELGRADE,
            self::CITY_SKOPJE,
        ];
    }
}
