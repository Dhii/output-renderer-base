<?php

namespace Dhii\Output\FuncTest\Exception;

use Xpmock\TestCase;
use Exception as RootException;
use Dhii\Output\TemplateInterface;
use Psr\Container\ContainerInterface;
use Dhii\Output\Exception\TemplateRenderException as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class TemplateRenderExceptionTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Output\Exception\TemplateRenderException';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return TestSubject The new instance of the test subject.
     */
    public function createInstance($message = null, $code = null, $previous = null, $renderer = null, $context = null)
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->new($message, $code, $previous, $renderer, $context);

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

        $this->assertInstanceOf(self::TEST_SUBJECT_CLASSNAME, $subject, 'A valid instance of the test subject could not be created');
        $this->assertInstanceOf('Dhii\Output\Exception\RendererExceptionInterface', $subject, 'Subject does not implement required interface');
        $this->assertInstanceOf('Dhii\Output\Exception\CouldNotRenderExceptionInterface', $subject, 'Subject does not implement required interface');
        $this->assertInstanceOf('Dhii\Output\Exception\TemplateRenderExceptionInterface', $subject, 'Subject does not implement required interface');
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
        return new \Exception($message, $code, $previous);
    }

    /**
     * Creates a new renderer.
     *
     * @since [*next-version*]
     *
     * @return TemplateInterface The new renderer.
     */
    public function createRenderer()
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
     * @param array $data The data for the context, if any.
     *
     * @return ContainerInterface The new context.
     */
    public function createContext($data = [])
    {
        $context = $this->mock('Psr\Container\ContainerInterface')
                ->get(function ($key) use ($data) {
                    return isset($data[$key]) ? $data[$key] : null;
                })
                ->has(function ($key) use ($data) {
                    return isset($data[$key]) ? true : false;
                })
                ->new();

        return $context;
    }

    /**
     * Tests that a renderer exception can be created correctly.
     *
     * @since [*next-version*]
     */
    public function testConstructorArguments()
    {
        $message = uniqid('message-');
        $code = intval(rand(1, 99));
        $previous = $this->createException(uniqid('message-'), intval(rand(100, 199)), null);
        $renderer = $this->createRenderer();
        $context = $this->createContext();
        $subject = $this->createInstance($message, $code, $previous, $renderer, $context);

        $this->assertSame($message, $subject->getMessage(), 'The new test subject does not have the correct message');
        $this->assertSame($code, $subject->getCode(), 'The new test subject does not have the correct code');
        $this->assertSame($previous, $subject->getPrevious(), 'The new test subject does not have the correct inner exception');
        $this->assertSame($renderer, $subject->getRenderer(), 'The new test subject does not have the correct renderer');
        $this->assertSame($context, $subject->getContext(), 'The new test subject does not have the correct context');
    }
}
