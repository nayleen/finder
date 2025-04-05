# nayleen/finder
Yet another class finder implementation.

## Installation
`composer require nayleen/finder`

## Usage
The finder comes with two different sets of classes: `Engine`s and `Expectation`s.

### Engines
Currently supported `Engine` implementations:
- [BetterReflectionEngine](https://github.com/Roave/BetterReflection) (can find built-in and load classes from strings)
- [ComposerEngine](https://github.com/Roave/BetterReflection) (can find built-in and load classes from strings)

`Engine`s provide iterators over class strings which can then be filtered using `Expectation`s.

### Expectations
`Expectation`s filter the class strings according to certain criteria. They're chainable, composable and negatable. You can
(and should) write your own `Expectation`s depending on your requirements in class filtering.

Building blocks (located in `Nayleen\Finder\Expectation` sub-namespaces):
- `Combinator\Composed` - chains two expectation (like boolean `AND`s)
- `Combinator\Not` - negates a wrapped expectation

Concrete implementations:
- `Any`
- `CallableExpectation` - wraps a callable with signature: `callable(class-string): bool`
- `ExtendsClass`
- `HasAttribute`
- `ImplementsInterface`
- `IsInstantiable`
