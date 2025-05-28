# An advanced library offering type safety and identity with Distance

## Identity

This library uses some tricks to intern values so that two distances are always equal to one another,
no matter the distance in time or space.

```php
use Withinboredom\Distance;
use Withinboredom\Distance\Unit;

$meter = Distance::from(Unit::Meters, 1);
$centimeters = Distance::from(Unit::Centimeters, 100);

echo $meter === $centimeters ? 'true' : 'false'
// outputs: true
```

## Type Safety

You can ensure nobody will accidentally confuse inches with centimeters or Nautical Miles with Miles:

```php
function moveForward(Distance $distance) { /* move */ }

moveForward(Distance::from(Unit::Miles, 10));
```

## Conversions and Math

You can convert between units and even perform operations, like sorting and arithmetic:

```php
$meter = Meters(1);

$meter = $meter->multiply(10)->add(Inches(10)); // get 10 meters and 10 inches

echo Centimeters(10) < $meter ? 'true' : 'false';
// output: true
```

## Support for Crell\Serde

You cannot serialize/deserialize/clone `Distance` objects.
However, if you use something like Serde, you can still serialize your value objects:

```php
class Robot {
    public function __construct(
        #[Field('height_in_centimeters')]
        #[DistanceAs(Unit::Centimeters)]
        public Distance $height,
    ) {}
}

$serde = new SerdeCommon(handlers: new \Withinboredom\Distance\SerdeExporter());
$serde->serialize(new Robot(Meters(5)), 'json');
```

The above will be serialized (and deserialized) from:

```json
{
    "height_in_centimeters": 500
}
```

## Units

There are several distance units supported

### SI Units

- Micrometers
- Millimeters
- Centimeters
- Meters
- Kilometers

### Imperial Units

- Inches
- Feet
- Yards
- Miles
- Furlongs

### Misc.

- Nautical Miles
- Astronomical Units

## FAQ

> How far can I go?

The base unit is in micrometers, so on a 64-bit system you can go ~60AU with micrometer accuracy.
For reference, Pluto is usually about 40 AU away from the sun.

If you are limited to 32-bit systems, this is not for you.
The maximum distance on a 32-bit system is just a couple of meters.

> Why does this exist?

I don’t like [magic numbers](https://en.wikipedia.org/wiki/Magic_number_(programming)#:~:text=Magic%20numbers%20are%20common%20in%20programs%20across%20many,have%20such%20constants%20that%20identify%20the%20contained%20data.).

> How performant is this?

The main overhead is in autoloading and function-call overhead. Thus, if realtime performance is a concern, you might
want to stick to magic numbers.

## Developing

If you wish to create a PR or update the code here:

1. Clone the repo
2. `composer install` to install test dependencies
3. `yarn` to install git hooks for formatting
4. Open in favorite IDE.

## Code Standards

[Per](https://www.php-fig.org/per/coding-style/) coding styles are followed.
