<?php

/**
 * @license See LICENSE in source root
 * @version 0.1.0
 * @since   0.1.0
 */

namespace Delegatus\Unit;

use Delegatus\Stub\BarCallbackDelegator;
use Delegatus\Stub\FooObjectDelegator;
use Delegatus\Stub\FooService;
use Delegatus\Stub\InvalidDelegator;
use PHPUnit_Framework_TestCase as UnitTestCase;

class DelegatorTest extends UnitTestCase {

    private function getFooDelegator() {
        $service = new FooService();
        return new FooObjectDelegator($service);
    }

    private function getBarDelegator() {
        return new BarCallbackDelegator();
    }

    private function getInvalidDelegator() {
        $service = new FooService();
        return new InvalidDelegator($service);
    }

    function testMethodNotDelegatedThrowsException() {
        $delegator = $this->getFooDelegator();
        $this->setExpectedException('Delegatus\\Exception\\MethodNotFoundException', 'Could not find "bar" method.');
        $delegator->bar();
    }

    function testObjectMethodDelegatedReturnsValue() {
        $delegator = $this->getFooDelegator();
        $actual = $delegator->foo();
        $this->assertEquals('foo', $actual);
    }

    function testCallbackDelegatedReturnsValue() {
        $delegator = $this->getBarDelegator();
        $actual = $delegator->bar();
        $this->assertSame('bar', $actual);
    }

    function testDelegateDoesNotHaveMethodThrowsException() {
        $msg = 'Could not find "notFound" method on delegate of type "Delegatus\\Stub\\FooService"';
        $this->setExpectedException('Delegatus\\Exception\\MethodNotFoundException', $msg);
        $this->getInvalidDelegator();
    }


} 
