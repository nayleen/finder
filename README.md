# nayleen/finder
Yet another class finder implementation.

## Installation
`composer require nayleen/finder`

## Usage
The finder comes with two different sets of classes: `Engine`s and `Expectation`s.

### Engines
Currently supported `Engine` implementations:
- ComposerEngine (simpler to use, only finds autoloadable classes)
- [BetterReflectionEngine](https://github.com/Roave/BetterReflection) (optional, can find built-in and load classes from strings)

`Engine`s provide iterators over class strings which can then be filtered using `Expectation`s.

### Expectations
`Expectation`s filter the class strings according to certain criteria. They're chainable, composable and negatable. You can
(and should) write your own `Expectation`s depending on your requirements in class filtering.

Building blocks:
- `Composed` - chains two expectation (like boolean `AND`s)
- `Not` - negates a wrapped expectation

Concrete implementations:
- `CallableExpectation` - wraps a callable with signature: `callable(class-string): bool`
- `ExtendsClass`
- `ImplementsInterface`
- `IsInstantiable`
