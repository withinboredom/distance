<?php

namespace Withinboredom\Distance;

if (!enum_exists(Unit::class)) {
    enum Unit: int
    {
        case Micrometers = 1;
        case Millimeters = 1_000;
        case Centimeters = 10_000;
        case Meters = 1_000_000;
        case Kilometers = 1_000_000_000;

        case Inches = 25_400;
        case Feet = 304_800;
        case Yards = 914_400;
        case Miles = 1_609_344_000;
        case Furlongs = 201_168_000;

        case NauticalMiles = 1_852_000_000;
        case AstronomicalUnits = 149_597_870_700_000_000;

        public function label(): string
        {
            return match ($this) {
                self::Micrometers => 'µm',
                self::Millimeters => 'mm',
                self::Centimeters => 'cm',
                self::Meters => 'm',
                self::Kilometers => 'km',
                self::Inches => 'in',
                self::Feet => 'ft',
                self::Yards => 'yd',
                self::Miles => 'mi',
                self::NauticalMiles => 'NM',
                self::AstronomicalUnits => 'AU',
                self::Furlongs => 'furlongs',
            };
        }
    }
}
