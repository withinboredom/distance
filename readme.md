# An advanced library offering type safety and identity with Durations

## Identity

This library uses some tricks to intern values so that two times are always equal to one another,
no matter the distance in time or space.

```php
use Withinboredom\Time;
use Withinboredom\Time\Unit;

$hour = Time::from(Unit::Hours, 1);
$minutes = Time::from(Unit::Minutes, 60);

echo $hour === $minutes ? 'true' : 'false'
// outputs: true
```

## Type Safety

You can ensure nobody will accidentally confuse seconds with milliseconds or minutes with seconds:

```php
function sleep(Time $time): void {
    \sleep($time->as(Unit::Seconds));
}

// Helper functions are included so you can type less code:
sleep(Minutes(5));
```

## Conversions and Math

You can easily convert between units and even perform operations, like sorting and arithmetic:

```php
// use the hour constant to get one hour
$hour = Hour;

$hour = $hour->multiply(10)->add(Minutes(10)); // get 10:10 hours

$interval = $hour->toDateInterval();

echo Hours(10) < $hour ? 'true' : 'false';
// output: true
```

## Support for Crell\Serde

You cannot serialize/deserialize/clone `Time` objects.
However, if you use something like Serde, you can still serialize your value objects:

```php
class CacheItem {
    public function __construct(
        #[Field('expiration_in_seconds')]
        #[TimeAs(Unit::Seconds)]
        public Time $expiration,
    ) {}
}

$serde = new SerdeCommon(handlers: new \Withinboredom\Time\SerdeExporter());
$serde->serialize(new CacheItem(Minutes(5)), 'json');
```

The above will be serialized (and deserialized) from:

```json
{
    "expiration_in_seconds": 300
}
```

## Units

- Nanoseconds
- Microseconds
- Milliseconds
- Minutes
- Hours
- Days
- Weeks

## FAQ

> Why not months/years?

There are no set days in a month/year, so it’s better to use `DateInterval` for those types of measures.

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
