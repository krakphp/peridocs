<?php

describe('Peridocs Integration', function() {
    it('adds the peridocs reporter', function() {
        $res = $res = `./vendor/bin/peridot test/integration/fixtures/test1.php --configuration=test/integration/peridot.php --reporters`;
        expect($res)->match('/peridocs - /');
    });
    it('can generate documentation', function() {
        $res = `./vendor/bin/peridot test/integration/fixtures/test1.php --configuration=test/integration/peridot.php --reporter=peridocs`;
        $expected = <<<'HTML'
### addMaybe(int $a, int $b)

**Name:** Krak\Peridocs\addMaybe

`addMaybe` optional foreword/introduction.

usually adds two numbers together:

```php
expect(addMaybe(1, 2))->equal(3);
```

but will multiply the two numbers when they are equal.:

```php
expect(addMaybe(3, 3))->equal(9);
```

This is the optional outro/conclusion to be appended to the text

HTML;
        expect($res)->equal($expected);
    });
});
