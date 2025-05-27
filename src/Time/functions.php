<?php

namespace Withinboredom\Time;

use Withinboredom\Time;

function Nanoseconds(float $time): Time
{
    return Time::from(Unit::Nanoseconds, $time);
}

function Microseconds(float $time): Time
{
    return Time::from(Unit::Microseconds, $time);
}

function Milliseconds(float $time): Time
{
    return Time::from(Unit::Milliseconds, $time);
}

function Seconds(float $time): Time
{
    return Time::from(Unit::Seconds, $time);
}

function Minutes(float $time): Time
{
    return Time::from(Unit::Minutes, $time);
}

function Hours(float $time): Time
{
    return Time::from(Unit::Hours, $time);
}

function Days(float $time): Time
{
    return Time::from(Unit::Days, $time);
}

function Weeks(float $time): Time
{
    return Time::from(Unit::Weeks, $time);
}

define('Nanosecond', Nanoseconds(1));
define('Microsecond', Microseconds(1));
define('Millisecond', Milliseconds(1));
define('Second', Seconds(1));
define('Minute', Minutes(1));
define('Hour', Hours(1));
define('Day', Days(1));
define('Week', Weeks(1));
