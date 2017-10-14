<?php

namespace Dhii\Output\FuncTest\Exception;

use Xpmock\TestCase;
use Exception as RootException;
use Dhii\Output\AbstractBaseTemplate as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractBaseTemplateTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Output\AbstractBaseTemplate';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return TestSubject The new instance of the test subject.
     */
    public function createInstance($renderResult = null)
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->_renderWithContext($renderResult)
                ->_validateContext()
                ->_normalizeContext($this->returnArgument(0))
                ->new();

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
     * Tests that the subject correctly creates a renderer exception.
     *
     * @since [*next-version*]
     */
    public function testCreateRendererException()
    {
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $message = uniqid('message-');
        $code = rand(1, 100);
        $innerException = $this->createException();

        $result = $_subject->_createRendererException($message, $code, $innerException);

        $this->assertInstanceOf('Dhii\Output\Exception\RendererExceptionInterface', $result,
            'The created message does not implement required interface');
        $this->assertEquals($message, $result->getMessage(), 'The result message is wrong');
        $this->assertEquals($code, $result->getCode(), 'The result code is wrong');
        $this->assertEquals($innerException, $result->getPrevious(), 'The result inner exception is wrong');
        $this->assertEquals($subject, $result->getRenderer(), 'The result renderer is wrong');
    }

    /**
     * Tests that the subject correctly produces output during normal operation.
     *
     * @since [*next-version*]
     */
    public function testRender()
    {
        $subject = $this->createInstance(uniqid('render-result-'));
        $result = $subject->render();

        $this->assertInternalType('string', $result, 'Returned value must be a string');
    }
}
