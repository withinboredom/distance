<?php

namespace Withinboredom;

use WeakReference;
use Withinboredom\Distance\Unit;

final class Distance
{
    private static array $map = [];

    private static function getValue(int $micrometers): Distance
    {
        // Attempt to get the value from the array, and if it exists, get the
        // value from the WeakReference, otherwise, create a new one
        $realValue = (self::$map[$micrometers] ?? null)?->get() ?? new self($micrometers);

        // Store the value in the array, even if another reference exists
        self::$map[$micrometers] = WeakReference::create($realValue);

        return $realValue;
    }

    public function __destruct()
    {
        // The values no longer exist, and we can delete the value from the array
        unset(self::$map[$this->micrometers]);
    }

    private function __construct(private readonly int $micrometers)
    {
        if ($this->micrometers < 0) {
            throw new \InvalidArgumentException('Distance cannot be negative');
        }
    }

    public static function from(Unit $unit, float $value): Distance
    {
        return self::getValue($unit->value * $value);
    }

    public function as(Unit $unit): float
    {
        return $this->micrometers / $unit->value;
    }

    public function add(Distance $distance): Distance
    {
        return self::getValue($this->micrometers + $distance->micrometers);
    }

    public function subtract(Distance $distance): Distance
    {
        return self::getValue(abs($this->micrometers - $distance->micrometers));
    }

    public function multiply(float $value): Distance
    {
        return self::getValue($this->micrometers * $value);
    }

    public function divide(float $value): Distance
    {
        return self::getValue($this->micrometers / $value);
    }

    public function __toString(): string
    {
        $micrometers = $this->as(Unit::Micrometers);

        $units = [
            Unit::Micrometers,
            Unit::Millimeters,
            Unit::Centimeters,
            Unit::Meters,
            Unit::Kilometers,
            Unit::AstronomicalUnits,
        ];

        foreach (array_reverse($units) as $unit) {
            $value = $this->as($unit);
            if ($value >= 1) {
                // For AU/parsecs, show up to 8 decimals; for meters/km, maybe 2
                $decimals = $unit->value >= Unit::Kilometers->value ? 2 : 1;
                if ($unit === Unit::AstronomicalUnits) {
                    $decimals = 8;
                }
                return number_format($value, $decimals, '.', ',') . ' ' . $unit->label();
            }
        }

        // Fallback (should never hit)
        return $micrometers . ' µm';
    }

    public function __clone(): void
    {
        throw new \LogicException('Cannot clone a Distance object');
    }

    public function __serialize(): array
    {
        throw new \LogicException('Cannot serialize a Distance object');
    }
}
