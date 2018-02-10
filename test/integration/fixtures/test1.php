<?php

namespace Krak\Peridocs;

function addMaybe(int $a, int $b) {
    return $a == $b ? $a * $a : $a + $b;
}

describe('Demo Package', function() {
    describe('addMaybe', function() {
        docFn(addMaybe::class); // this is the fully qualified name for the function e.g. 'Acme\Prefix\addMaybe'
        docIntro('`addMaybe` optional foreword/introduction.');

        it('usually adds two numbers together', function() {
            expect(addMaybe(1, 2))->equal(3);
        });
        it('but will multiply the two numbers when they are equal.', function() {
            expect(addMaybe(3, 3))->equal(9);
        });

        docOutro('This is the optional outro/conclusion to be appended to the text');
    });
});
