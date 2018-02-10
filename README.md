# Peridocs

Peridocs is a Peridot plugin that generates automated markdown documentation from your peridot tests. I've found that my peridot tests are usually the best source of documentation. This project allows you to utilize your test documentation in an automated way.

## Installation

Load with composer as a dev dependency: `krak/peridocs`.

In your `peridot.php` configuration file, add the following:

```php
<?php

use Krak\Peridocs;

return function($emitter) {
    Peridocs\bootstrap($emitter);
};
```

## Usage

Once registered, you can utilize the `docFn` function in your tests to enable documentation for the given test.

```php
// function to test
function addMaybe(int $a, int $b): int {
    return $a == $b ? $a * $a : $a + $b;
}

// in some spec.php file
describe('Demo Package', function() {
    describe('addMaybe', function() {
        docFn(addMaybe::class); // this is the fully qualified name for the function e.g. 'Acme\Prefix\addMaybe'
        docIntro('`addMaybe` optional foreword/introduction.');

        it('usually adds two numbers together', function() {
            expect(addMaybe(1, 2))->equal(3);
        });
        it('but will multiply the two numbers when they are equal', function() {
            expect(addMaybe(3, 3))->equal(9);
        });

        docOutro('This is the optional outro/conclusion to be appended to the text');
    });
});
```

Now, you can generate the markdown by running peridot with the peridocs reporter.

```
./vendor/bin/peridot -r peridocs
```

It should output the following markdown:

    ### addMaybe(int $a, int $b): int

    **Name:** Krak\Peridocs\addMaybe

    `addMaybe` optional foreword/introduction.

    usually adds two numbers together:

    ```php
    expect(addMaybe(1, 2))->equal(3);
    ```

    but will multiply the two numbers when they are equal:

    ```php
    expect(addMaybe(3, 3))->equal(9);
    ```

    This is the optional outro/conclusion to be appended to the text
