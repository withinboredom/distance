<?php

namespace Withinboredom\Time;

use Crell\AttributeUtils\SupportsScopes;
use Crell\Serde\TypeField;
use Withinboredom\Time;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class TimeAs implements TypeField, SupportsScopes
{
    public function __construct(public readonly Unit $unit, protected readonly array $scopes = []) {}

    public function scopes(): array
    {
        return $this->scopes;
    }

    public function acceptsType(string $type): bool
    {
        return is_a($type, Time::class, true);
    }

    public function validate(mixed $value): bool
    {
        return true;
    }
}
