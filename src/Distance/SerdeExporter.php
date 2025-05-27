<?php

namespace Withinboredom\Distance;

use Crell\Serde\Attributes\Field;
use Crell\Serde\DeformatterResult;
use Crell\Serde\Deserializer;
use Crell\Serde\PropertyHandler\Exporter;
use Crell\Serde\PropertyHandler\Importer;
use Crell\Serde\Serializer;
use Withinboredom\Distance;

class SerdeExporter implements Exporter, Importer
{
    public function exportValue(Serializer $serializer, Field $field, mixed $value, mixed $runningValue): mixed
    {
        $typeField = $field->typeField;
        assert($typeField instanceof DistanceAs);
        assert($value instanceof Distance);

        return $serializer->formatter->serializeInt($runningValue, $field, $value->as($typeField->unit));
    }

    public function canExport(Field $field, mixed $value, string $format): bool
    {
        return $value instanceof Distance && $field->typeField instanceof DistanceAs;
    }

    public function importValue(Deserializer $deserializer, Field $field, mixed $source): mixed
    {
        $typeField = $field->typeField;
        assert($typeField instanceof DistanceAs);

        $number = $deserializer->deformatter->deserializeInt($source, $field);

        if ($number === DeformatterResult::Missing) {
            return null;
        }

        return Distance::from($typeField->unit, $number);
    }

    public function canImport(Field $field, string $format): bool
    {
        return $field->typeField instanceof DistanceAs;
    }
}
