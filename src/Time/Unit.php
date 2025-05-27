<?php

namespace Withinboredom\Time;

if (!enum_exists(Unit::class)) {
    enum Unit: int
    {
        case Nanoseconds = 1;
        case Microseconds = 1_000;
        case Milliseconds = 1_000_000;
        case Seconds = 1_000_000_000;
        case Minutes = 60_000_000_000;
        case Hours = 3_600_000_000_000;
        case Days = 86_400_000_000_000;
        case Weeks = 604_800_000_000_000;
    }
}
