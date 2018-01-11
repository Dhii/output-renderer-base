<?php

namespace Dhii\Output\FuncTest;

use Xpmock\TestCase;
use Exception as RootException;
use Dhii\Output\RendererInterface;
use Dhii\Output\CreateRendererExceptionCapableTrait as TestSubject;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class CreateRendererExceptionCapableTraitTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Output\CreateRendererExceptionCapableTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return MockObject The new instance of the test subject.
     */
    public function createInstance()
    {
        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
                ->getMockForTrait();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInternalType('object', $subject, 'A valid instance of the test subject could not be created');
    }

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string        $message
     * @param int           $code
     * @param RootException $previous
     *
     * @return RootException The new exception.
     */
    public function createException($message = null, $code = null, RootException $previous = null)
    {
        return new RootException($message, $code, $previous);
    }

    /**
     * Creates a new renderer.
     *
     * @since [*next-version*]
     *
     * @return RendererInterface The new renderer.
     */
    public function createRenderer()
    {
        $container = $this->mock('Dhii\Output\RendererInterface')
                ->render()
                ->new();

        return $container;
    }

    /**
     * Tests that a renderer exception can be created correctly.
     *
     * @since [*next-version*]
     */
    public function testCreateRendererException()
    {
        $message = uniqid('message-');
        $code = intval(rand(1, 99));
        $previous = $this->createException(uniqid('message-'), intval(rand(100, 199)), null);
        $renderer = $this->createRenderer();
        $subject = $this->createInstance($message, $code, $previous, $renderer);
        $_subject = $this->reflect($subject);
        $exception = $_subject->_createRendererException($message, $code, $previous, $renderer);

        $this->assertSame($message, $exception->getMessage(), 'The new exception does not have the correct message');
        $this->assertSame($code, $exception->getCode(), 'The new exception does not have the correct code');
        $this->assertSame($previous, $exception->getPrevious(), 'The new exception does not have the correct inner exception');
        $this->assertSame($renderer, $exception->getRenderer(), 'The new exception does not have the correct renderer');
    }
}
