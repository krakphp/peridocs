<?php

use Krak\Peridocs;

return function($emitter) {
    Peridocs\bootstrap($emitter, function() {
        return new Peridocs\DocsContext(null, [
            'nsPrefix' => 'Krak\\Peridocs\\',
            'showLinks' => true,
        ]);
    });
};

