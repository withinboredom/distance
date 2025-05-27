<?php

use Withinboredom\Distance;
use Withinboredom\Distance\SerdeExporter;
use Withinboredom\Distance\DistanceAs;
use Withinboredom\Distance\Unit;

use function Withinboredom\Distance\Feet;
use function Withinboredom\Distance\Kilometers;
use function Withinboredom\Distance\Meters;

test('unit', function (Distance $distance) {
    expect($distance)
        ->toBe(Kilometers(1))
        ->and($distance->as(Unit::Kilometers))->toBe(1.0);
})->with([
    'kilometers' => [Kilometers(1)],
    'meters' => [Meters(1000)],
]);

test('equality', function () {
    $secondInMs = Meters(1000);
    $second = Kilometers(1);
    expect($second)
        ->toBe(Kilometers(1))
        ->and($secondInMs)->toBe(Kilometers(1));
});

it('cannot be serialized', function () {
    $var = Meters(1);
    expect(fn() => serialize($var))->toThrow(LogicException::class);
});

it('cannot be cloned', function () {
    $var = Meters(1);
    expect(fn() => clone $var)->toThrow(LogicException::class);
});

it('can be compared', function () {
    $middle = Meters(3);
    $left = Meters(1);
    $right = Meters(5);

    expect(Distance::from(Unit::Meters, 1) < Distance::from(Unit::Meters, 1))
        ->toBeFalse()
        ->and($left < $middle)
        ->toBeTrue()
        ->and($right > $middle)->toBeTrue()
        ->and($left < $right)->toBeTrue()
        ->and($left > $middle)->toBeFalse();
});

it('can be converted to a string', function () {
    expect((string) Kilometers(10))->toBe('10.00 km');
    expect((string) Meters(10))->toBe('10.0 m');
    expect((string) Feet(5)->add(Distance\Inches(4)))->toBe('1.6 m');
});

it('can handle big distances', function () {
    $pluto = Distance\AstronomicalUnits(40);
    $earth = Distance\AstronomicalUnits(1);
    expect($pluto)->toBeGreaterThan($earth);
});

it('works with serde', function () {
    if (!class_exists(\Crell\Serde\Serde::class)) {
        $this->markTestSkipped();
    }

    $serde = new \Crell\Serde\SerdeCommon(handlers: [new SerdeExporter()]);
    $class = new class (Kilometers(1)) {
        public function __construct(#[DistanceAs(Unit::Meters)] public Distance $distance) {}
    };
    $json = $serde->serialize($class, 'json');
    expect($json)
        ->toBeJson()
        ->and($json)->json()->toBe(['distance' => 1000]);
    $class = $serde->deserialize($json, 'json', get_class($class));
    expect($class->distance)->toBe(Meters(1000));
});
