<?php

declare(strict_types=1);

namespace App\Enums\Car;

enum CarColor: string
{
    case WHITE = 'white';
    case BLACK = 'black';
    case SILVER = 'silver';
    case GRAY = 'gray';
    case RED = 'red';
    case BLUE = 'blue';
    case YELLOW = 'yellow';
    case GREEN = 'green';
    case ORANGE = 'orange';
    case ANTHRACITE = 'anthracite';
    case BURGUNDY = 'burgundy';
    case NAVY = 'navy';
    case BROWN = 'brown';
    case BEIGE = 'beige';
    case GOLD = 'gold';
    case PURPLE = 'purple';
    case CYAN = 'cyan';
    case BRONZE = 'bronze';

    public function getHex(): string
    {
        return match ($this) {
            self::WHITE => '#FFFFFF',
            self::BLACK => '#000000',
            self::SILVER => '#C0C0C0',
            self::GRAY => '#808080',
            self::RED => '#FF0000',
            self::BLUE => '#0000FF',
            self::YELLOW => '#FFFF00',
            self::GREEN => '#008000',
            self::ORANGE => '#FFA500',
            self::ANTHRACITE => '#383E42',
            self::BURGUNDY => '#800020',
            self::NAVY => '#000080',
            self::BROWN => '#A52A2A',
            self::BEIGE => '#F5F5DC',
            self::GOLD => '#FFD700',
            self::PURPLE => '#800080',
            self::CYAN => '#00FFFF',
            self::BRONZE => '#CD7F32',
        };
    }

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
