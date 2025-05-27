<?php

namespace Withinboredom\Time;

use Crell\Serde\Attributes\Field;
use Crell\Serde\DeformatterResult;
use Crell\Serde\Deserializer;
use Crell\Serde\PropertyHandler\Exporter;
use Crell\Serde\PropertyHandler\Importer;
use Crell\Serde\Serializer;
use Withinboredom\Time;

class SerdeExporter implements Exporter, Importer
{
    public function exportValue(Serializer $serializer, Field $field, mixed $value, mixed $runningValue): mixed
    {
        $typeField = $field->typeField;
        assert($typeField instanceof TimeAs);
        assert($value instanceof Time);

        return $serializer->formatter->serializeInt($runningValue, $field, $value->as($typeField->unit));
    }

    public function canExport(Field $field, mixed $value, string $format): bool
    {
        return $value instanceof Time && $field->typeField instanceof TimeAs;
    }

    public function importValue(Deserializer $deserializer, Field $field, mixed $source): mixed
    {
        $typeField = $field->typeField;
        assert($typeField instanceof TimeAs);

        $number = $deserializer->deformatter->deserializeInt($source, $field);

        if ($number === DeformatterResult::Missing) {
            return null;
        }

        return Time::from($typeField->unit, $number);
    }

    public function canImport(Field $field, string $format): bool
    {
        return $field->typeField instanceof TimeAs;
    }
}
