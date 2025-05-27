<?php

namespace Withinboredom\Distance;

use Withinboredom\Distance;

function Micrometers(int $value): Distance
{
    return Distance::from(Unit::Micrometers, $value);
}

function Millimeters(int $value): Distance
{
    return Distance::from(Unit::Millimeters, $value);
}

function Centimeters(int $value): Distance
{
    return Distance::from(Unit::Centimeters, $value);
}

function Meters(int $value): Distance
{
    return Distance::from(Unit::Meters, $value);
}

function Kilometers(int $value): Distance
{
    return Distance::from(Unit::Kilometers, $value);
}

function Inches(int $value): Distance
{
    return Distance::from(Unit::Inches, $value);
}

function Feet(int $value): Distance
{
    return Distance::from(Unit::Feet, $value);
}

function Yards(int $value): Distance
{
    return Distance::from(Unit::Yards, $value);
}

function Miles(int $value): Distance
{
    return Distance::from(Unit::Miles, $value);
}

function NauticalMiles(int $value): Distance
{
    return Distance::from(Unit::NauticalMiles, $value);
}

function AstronomicalUnits(int $value): Distance
{
    return Distance::from(Unit::AstronomicalUnits, $value);
}

function Furlongs(int $value): Distance
{
    return Distance::from(Unit::Furlongs, $value);
}
