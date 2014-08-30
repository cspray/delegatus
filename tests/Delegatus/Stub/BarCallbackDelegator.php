<?php

/**
 * 
 * @license See LICENSE in source root
 * @version 1.0
 * @since   1.0
 */

namespace Delegatus\Stub;

use Delegatus\Delegator;

class BarCallbackDelegator {

    use Delegator;

    function __construct() {
        $this->delegateToCallable(['bar'], function() { return 'bar'; });
    }

} 
