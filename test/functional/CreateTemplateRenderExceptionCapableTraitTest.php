<?php

namespace Dhii\Output\FuncTest;

use Psr\Container\ContainerInterface;
use Xpmock\TestCase;
use Exception as RootException;
use Dhii\Output\TemplateInterface;
use Dhii\Output\CreateTemplateRenderExceptionCapableTrait as TestSubject;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class CreateTemplateRenderExceptionCapableTraitTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Output\CreateTemplateRenderExceptionCapableTrait';

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
     * Creates a new template.
     *
     * @since [*next-version*]
     *
     * @return TemplateInterface The new renderer.
     */
    public function createTemplate()
    {
        $container = $this->mock('Dhii\Output\TemplateInterface')
                ->render()
                ->new();

        return $container;
    }

    /**
     * Creates a new context.
     *
     * @since [*next-version*]
     *
     * @return ContainerInterface The new context.
     */
    public function createContext()
    {
        $mock = $this->getMockBuilder('Psr\Container\ContainerInterface')
            ->getMockForAbstractClass();

        return $mock;
    }

    /**
     * Tests that a Template Render exception can be created correctly.
     *
     * @since [*next-version*]
     */
    public function testCreateTemplateRenderException()
    {
        $message = uniqid('message-');
        $code = intval(rand(1, 99));
        $previous = $this->createException(uniqid('message-'), intval(rand(100, 199)), null);
        $template = $this->createTemplate();
        $context = $this->createContext();
        $subject = $this->createInstance($message, $code, $previous, $template);
        $_subject = $this->reflect($subject);
        $exception = $_subject->_createTemplateRenderException($message, $code, $previous, $template, $context);

        $this->assertSame($message, $exception->getMessage(), 'The new exception does not have the correct message');
        $this->assertSame($code, $exception->getCode(), 'The new exception does not have the correct code');
        $this->assertSame($previous, $exception->getPrevious(), 'The new exception does not have the correct inner exception');
        $this->assertSame($template, $exception->getRenderer(), 'The new exception does not have the correct template');
        $this->assertSame($context, $exception->getContext(), 'The new exception does not have the correct context');
    }
}
