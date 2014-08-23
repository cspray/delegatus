<?php

/**
 * @license See LICENSE in source root
 * @version 0.1.0
 * @since   0.1.0
 */

namespace Delegatus\Stub;

use Delegatus\Delegator;

class InvalidDelegator {

    use Delegator;

    function __construct(FooService $foo) {
        $this->delegate($foo, ['notFound']);
    }

} 
